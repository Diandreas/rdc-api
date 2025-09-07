<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

class FileCompressionService
{
    protected $imageManager;
    
    // Tailles d'images optimisées
    const IMAGE_SIZES = [
        'thumbnail' => ['width' => 300, 'height' => 300, 'quality' => 80],
        'medium' => ['width' => 800, 'height' => 600, 'quality' => 85],
        'large' => ['width' => 1200, 'height' => 900, 'quality' => 90],
    ];
    
    // Tailles maximales pour la compression
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1080;
    const IMAGE_QUALITY = 85;
    
    // Tailles vidéo (pour référence - compression vidéo nécessite FFmpeg)
    const VIDEO_PROFILES = [
        'low' => ['width' => 640, 'height' => 360, 'bitrate' => '500k'],
        'medium' => ['width' => 1280, 'height' => 720, 'bitrate' => '2000k'],
        'high' => ['width' => 1920, 'height' => 1080, 'bitrate' => '5000k'],
    ];

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Compresser et redimensionner une image
     */
    public function compressImage(UploadedFile $file, string $folder = 'images', array $sizes = null): array
    {
        $results = [];
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Vérifier que c'est bien une image supportée
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            throw new Exception('Format d\'image non supporté');
        }

        try {
            // Charger l'image originale
            $image = $this->imageManager->read($file->getRealPath());
            
            // Si aucune taille spécifiée, utiliser les tailles par défaut
            if ($sizes === null) {
                $sizes = self::IMAGE_SIZES;
                
                // Ajouter l'image originale compressée
                $sizes['original'] = [
                    'width' => min($image->width(), self::MAX_IMAGE_WIDTH),
                    'height' => min($image->height(), self::MAX_IMAGE_HEIGHT),
                    'quality' => self::IMAGE_QUALITY
                ];
            }

            foreach ($sizes as $sizeName => $sizeConfig) {
                $filename = $originalName . '_' . $sizeName . '_' . time() . '.webp';
                $path = $folder . '/' . $filename;
                
                // Créer une copie de l'image pour cette taille
                $resizedImage = clone $image;
                
                // Redimensionner en gardant les proportions
                if (isset($sizeConfig['width']) && isset($sizeConfig['height'])) {
                    $resizedImage->cover(
                        $sizeConfig['width'],
                        $sizeConfig['height']
                    );
                } elseif (isset($sizeConfig['width'])) {
                    $resizedImage->scaleDown(width: $sizeConfig['width']);
                } elseif (isset($sizeConfig['height'])) {
                    $resizedImage->scaleDown(height: $sizeConfig['height']);
                }
                
                // Encoder en WebP pour une meilleure compression
                $encoded = $resizedImage->toWebp($sizeConfig['quality'] ?? 85);
                
                // Sauvegarder
                Storage::disk('public')->put($path, $encoded);
                
                $results[$sizeName] = [
                    'path' => $path,
                    'url' => route('file.serve', ['type' => $folder, 'filename' => $filename]),
                    'size' => strlen($encoded),
                    'width' => $resizedImage->width(),
                    'height' => $resizedImage->height()
                ];
            }
            
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la compression de l\'image: ' . $e->getMessage());
        }

        return $results;
    }

    /**
     * Compresser une image simple (une seule taille)
     */
    public function compressSingleImage(UploadedFile $file, string $folder = 'images', int $maxWidth = null, int $maxHeight = null, int $quality = 85): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = $originalName . '_' . time() . '.webp';
        $path = $folder . '/' . $filename;
        
        try {
            $image = $this->imageManager->read($file->getRealPath());
            
            // Redimensionner si nécessaire
            $maxWidth = $maxWidth ?? self::MAX_IMAGE_WIDTH;
            $maxHeight = $maxHeight ?? self::MAX_IMAGE_HEIGHT;
            
            if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
                $image->scaleDown($maxWidth, $maxHeight);
            }
            
            // Encoder en WebP
            $encoded = $image->toWebp($quality);
            
            // Sauvegarder
            Storage::disk('public')->put($path, $encoded);
            
            return $path;
            
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la compression: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les informations d'une image
     */
    public function getImageInfo(string $path): array
    {
        if (!Storage::disk('public')->exists($path)) {
            throw new Exception('Fichier introuvable');
        }
        
        try {
            $fullPath = Storage::disk('public')->path($path);
            $image = $this->imageManager->read($fullPath);
            
            return [
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => Storage::disk('public')->size($path),
                'mime_type' => Storage::disk('public')->mimeType($path),
            ];
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la lecture des informations: ' . $e->getMessage());
        }
    }

    /**
     * Compresser une vidéo (nécessite FFmpeg - version basique)
     * Note: Pour une vraie compression vidéo, il faudrait installer FFmpeg
     */
    public function compressVideo(UploadedFile $file, string $folder = 'videos', string $profile = 'medium'): string
    {
        // Pour l'instant, on sauvegarde juste le fichier
        // Une vraie compression vidéo nécessiterait FFmpeg
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $originalName . '_compressed_' . time() . '.' . $extension;
        $path = $folder . '/' . $filename;
        
        // Sauvegarder le fichier (sans compression pour l'instant)
        $file->storeAs($folder, $filename, 'public');
        
        return $path;
    }

    /**
     * Nettoyer les anciens fichiers compressés
     */
    public function cleanOldFiles(string $folder, int $days = 30): int
    {
        $files = Storage::disk('public')->files($folder);
        $deletedCount = 0;
        $cutoffTime = now()->subDays($days)->timestamp;
        
        foreach ($files as $file) {
            $fileTime = Storage::disk('public')->lastModified($file);
            if ($fileTime < $cutoffTime) {
                Storage::disk('public')->delete($file);
                $deletedCount++;
            }
        }
        
        return $deletedCount;
    }

    /**
     * Calculer l'espace de stockage utilisé
     */
    public function getStorageUsage(string $folder = null): array
    {
        $folders = $folder ? [$folder] : ['images', 'videos', 'documents', 'photos'];
        $usage = [];
        $totalSize = 0;
        
        foreach ($folders as $f) {
            $files = Storage::disk('public')->files($f);
            $folderSize = 0;
            $fileCount = 0;
            
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    $folderSize += Storage::disk('public')->size($file);
                    $fileCount++;
                }
            }
            
            $usage[$f] = [
                'size' => $folderSize,
                'size_human' => $this->formatBytes($folderSize),
                'files_count' => $fileCount
            ];
            
            $totalSize += $folderSize;
        }
        
        $usage['total'] = [
            'size' => $totalSize,
            'size_human' => $this->formatBytes($totalSize),
            'folders' => count($folders)
        ];
        
        return $usage;
    }

    /**
     * Formater les bytes en format lisible
     */
    private function formatBytes(int $size, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}