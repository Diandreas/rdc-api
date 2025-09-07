<?php

namespace App\Http\Controllers;

use App\Models\ViewStatistic;
use App\Models\FileView;
use App\Services\FileCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    protected $compressionService;

    public function __construct(FileCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

    /**
     * Servir un fichier avec comptage des vues et mise en cache
     */
    public function serve(Request $request, string $type, string $filename)
    {
        // Validation des paramètres
        $allowedTypes = ['images', 'videos', 'documents', 'photos', 'audio'];
        if (!in_array($type, $allowedTypes)) {
            abort(404, 'Type de fichier non autorisé');
        }

        $path = $type . '/' . $filename;
        
        // Vérifier que le fichier existe
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Fichier non trouvé');
        }

        try {
            $fullPath = Storage::disk('public')->path($path);
            
            // Vérifier les extensions autorisées
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $this->validateFileExtension($type, $extension);

            // Incrémenter les vues (de façon asynchrone pour ne pas ralentir la réponse)
            $this->incrementFileViews($type, $filename);

            // Obtenir les informations du fichier
            $fileInfo = $this->getFileInfo($fullPath, $extension);
            
            // Gérer le cache HTTP
            $lastModified = Storage::disk('public')->lastModified($path);
            $etag = md5($path . $lastModified);
            
            // Vérifier si le client a déjà le fichier en cache
            if ($request->header('If-None-Match') === $etag) {
                return response('', 304);
            }

            // Préparer la réponse avec les bons headers
            $response = Response::file($fullPath, [
                'Content-Type' => $fileInfo['mime_type'],
                'Cache-Control' => $this->getCacheControl($type),
                'ETag' => $etag,
                'Last-Modified' => gmdate('D, d M Y H:i:s T', $lastModified),
            ]);

            // Ajouter les headers spécifiques selon le type
            if ($type === 'videos') {
                $response->headers->set('Accept-Ranges', 'bytes');
                $response->headers->set('X-Content-Duration', $this->getVideoDuration($fullPath));
            }

            // Headers de sécurité
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            
            return $response;

        } catch (\Exception $e) {
            abort(500, 'Erreur lors du chargement du fichier: ' . $e->getMessage());
        }
    }

    /**
     * Servir une image avec redimensionnement à la volée
     */
    public function serveImage(Request $request, string $filename)
    {
        $path = 'images/' . $filename;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Image non trouvée');
        }

        // Paramètres de redimensionnement
        $width = $request->get('w');
        $height = $request->get('h');
        $quality = $request->get('q', 85);

        // Si pas de redimensionnement demandé, servir l'image normale
        if (!$width && !$height) {
            return $this->serve($request, 'images', $filename);
        }

        try {
            // Clé de cache basée sur les paramètres
            $cacheKey = "image_" . md5($filename . $width . $height . $quality);
            
            // Vérifier le cache
            if (Cache::has($cacheKey)) {
                $cachedData = Cache::get($cacheKey);
                return response($cachedData['content'])
                    ->header('Content-Type', $cachedData['mime_type'])
                    ->header('Cache-Control', 'public, max-age=31536000');
            }

            // Redimensionner l'image
            $fullPath = Storage::disk('public')->path($path);
            $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $imageManager->read($fullPath);

            // Appliquer le redimensionnement
            if ($width && $height) {
                $image->cover((int)$width, (int)$height);
            } elseif ($width) {
                $image->scaleDown(width: (int)$width);
            } elseif ($height) {
                $image->scaleDown(height: (int)$height);
            }

            // Encoder
            $encoded = $image->toWebp((int)$quality);
            
            // Mettre en cache (pendant 1 heure)
            Cache::put($cacheKey, [
                'content' => $encoded,
                'mime_type' => 'image/webp'
            ], 3600);

            // Incrémenter les vues
            $this->incrementFileViews('images', $filename);

            return response($encoded)
                ->header('Content-Type', 'image/webp')
                ->header('Cache-Control', 'public, max-age=31536000');

        } catch (\Exception $e) {
            // En cas d'erreur, servir l'image originale
            return $this->serve($request, 'images', $filename);
        }
    }

    /**
     * Upload et compression d'un fichier
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:50240', // 50MB max
            'type' => 'required|in:images,videos,documents,photos'
        ]);

        $file = $request->file('file');
        $type = $request->get('type');
        
        try {
            if (in_array($type, ['images', 'photos'])) {
                // Compresser l'image
                $results = $this->compressionService->compressSingleImage(
                    $file,
                    $type,
                    1920, // largeur max
                    1080, // hauteur max
                    85    // qualité
                );
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploadée et compressée avec succès',
                    'data' => [
                        'path' => $results,
                        'url' => route('file.serve', ['type' => $type, 'filename' => basename($results)]),
                        'type' => 'image'
                    ]
                ]);
                
            } elseif ($type === 'videos') {
                // Pour les vidéos (compression basique)
                $path = $this->compressionService->compressVideo($file, $type);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Vidéo uploadée avec succès',
                    'data' => [
                        'path' => $path,
                        'url' => route('file.serve', ['type' => $type, 'filename' => basename($path)]),
                        'type' => 'video'
                    ]
                ]);
                
            } else {
                // Documents normaux
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs($type, $filename, 'public');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Fichier uploadé avec succès',
                    'data' => [
                        'path' => $path,
                        'url' => route('file.serve', ['type' => $type, 'filename' => $filename]),
                        'type' => 'document'
                    ]
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les statistiques d'usage du stockage
     */
    public function storageStats()
    {
        try {
            $stats = $this->compressionService->getStorageUsage();
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques'
            ], 500);
        }
    }

    /**
     * Nettoyer les anciens fichiers
     */
    public function cleanup(Request $request)
    {
        $days = $request->get('days', 30);
        $folder = $request->get('folder');
        
        try {
            if ($folder) {
                $deletedCount = $this->compressionService->cleanOldFiles($folder, $days);
            } else {
                $deletedCount = 0;
                foreach (['images', 'videos', 'documents', 'photos'] as $f) {
                    $deletedCount += $this->compressionService->cleanOldFiles($f, $days);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Nettoyage terminé. {$deletedCount} fichiers supprimés.",
                'deleted_count' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du nettoyage: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Incrémenter les vues d'un fichier
     */
    private function incrementFileViews(string $type, string $filename)
    {
        try {
            // Créer un modèle virtuel pour le fichier
            $fileModel = FileView::createVirtual($type, $filename);
            ViewStatistic::incrementViews($fileModel);
        } catch (\Exception $e) {
            // Ignorer silencieusement les erreurs de comptage des vues
            // pour ne pas affecter le service du fichier
        }
    }

    /**
     * Valider l'extension du fichier
     */
    private function validateFileExtension(string $type, string $extension)
    {
        $allowedExtensions = [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'],
            'photos' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'],
            'videos' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'],
            'documents' => ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'],
            'audio' => ['mp3', 'wav', 'ogg', 'aac', 'm4a', 'flac', 'wma']
        ];

        if (!in_array($extension, $allowedExtensions[$type] ?? [])) {
            abort(403, 'Type de fichier non autorisé');
        }
    }

    /**
     * Obtenir les informations du fichier
     */
    private function getFileInfo(string $path, string $extension): array
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
            'gif' => 'image/gif', 'webp' => 'image/webp', 'bmp' => 'image/bmp',
            'svg' => 'image/svg+xml', 'mp4' => 'video/mp4', 'avi' => 'video/avi',
            'mov' => 'video/quicktime', 'wmv' => 'video/x-ms-wmv',
            'pdf' => 'application/pdf', 'doc' => 'application/msword',
            'mp3' => 'audio/mpeg', 'wav' => 'audio/wav'
        ];

        return [
            'mime_type' => $mimeTypes[$extension] ?? mime_content_type($path),
            'size' => filesize($path),
            'extension' => $extension
        ];
    }

    /**
     * Obtenir les paramètres de cache selon le type
     */
    private function getCacheControl(string $type): string
    {
        $cacheSettings = [
            'images' => 'public, max-age=31536000', // 1 an
            'photos' => 'public, max-age=31536000', // 1 an
            'videos' => 'public, max-age=31536000', // 1 an
            'documents' => 'public, max-age=3600',  // 1 heure
            'audio' => 'public, max-age=31536000',  // 1 an
        ];

        return $cacheSettings[$type] ?? 'public, max-age=3600';
    }

    /**
     * Obtenir la durée d'une vidéo (placeholder)
     */
    private function getVideoDuration(string $path): string
    {
        // Pour obtenir la vraie durée, il faudrait utiliser FFmpeg
        return '0';
    }
}