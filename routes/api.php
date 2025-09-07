<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SpeechController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\VideoController;

// Test simple
Route::get('test', function () {
    return response()->json(['message' => 'API fonctionne!']);
});

// Routes publiques pour l'app mobile
Route::prefix('v1')->group(function () {
    
    // Authentification
    Route::post('auth/login', function (\Illuminate\Http\Request $request) {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données de connexion invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiants incorrects'
                ], 401);
            }

            $user = \Illuminate\Support\Facades\Auth::user();
            
            if (!$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé'
                ], 403);
            }

            $token = $user->createToken('admin-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->getRoleNames()
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de connexion: ' . $e->getMessage()
            ], 500);
        }
    });
    
    // Test simple
    Route::get('app/welcome', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Bienvenue sur l\'application officielle du Président Faustin Archange Touadéra',
                'president_name' => 'Faustin Archange Touadéra',
                'app_version' => '1.0.0',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    });
    
    // Routes avec comptage des vues automatique
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('categories/type/{type}', [CategoryController::class, 'byType']);
    
    Route::get('speeches', [SpeechController::class, 'index']);
    Route::get('speeches/{id}', [SpeechController::class, 'show']);
    
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{id}', [NewsController::class, 'show']);
    
    Route::get('photos', [PhotoController::class, 'index']);
    Route::get('photos/{id}', [PhotoController::class, 'show']);
    
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/{id}', [VideoController::class, 'show']);
    
    Route::get('quotes', function () {
        try {
            $quotes = \App\Models\Quote::all();
            return response()->json([
                'success' => true,
                'data' => $quotes,
                'count' => $quotes->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('social-links', function () {
        try {
            $socialLinks = \App\Models\SocialLink::all();
            return response()->json([
                'success' => true,
                'data' => $socialLinks,
                'count' => $socialLinks->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    // Routes pour servir les fichiers et images
    Route::get('files/image/{folder}/{filename}', function ($folder, $filename) {
        try {
            $path = storage_path("app/public/{$folder}/{$filename}");
            
            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image non trouvée'
                ], 404);
            }
            
            // Vérifier que c'est bien une image
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de fichier non autorisé'
                ], 403);
            }
            
            $mimeType = mime_content_type($path);
            
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Cache-Control' => 'public, max-age=31536000', // Cache 1 an
                'Expires' => gmdate('D, d M Y H:i:s T', time() + 31536000)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement de l\'image: ' . $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('files/video/{folder}/{filename}', function ($folder, $filename) {
        try {
            $path = storage_path("app/public/{$folder}/{$filename}");
            
            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vidéo non trouvée'
                ], 404);
            }
            
            // Vérifier que c'est bien une vidéo
            $allowedExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de fichier non autorisé'
                ], 403);
            }
            
            $mimeType = mime_content_type($path);
            
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'public, max-age=31536000'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement de la vidéo: ' . $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('files/document/{folder}/{filename}', function ($folder, $filename) {
        try {
            $path = storage_path("app/public/{$folder}/{$filename}");
            
            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document non trouvé'
                ], 404);
            }
            
            // Vérifier que c'est bien un document autorisé
            $allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de fichier non autorisé'
                ], 403);
            }
            
            $mimeType = mime_content_type($path);
            
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=3600'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement du document: ' . $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('files/audio/{folder}/{filename}', function ($folder, $filename) {
        try {
            $path = storage_path("app/public/{$folder}/{$filename}");
            
            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier audio non trouvé'
                ], 404);
            }
            
            // Vérifier que c'est bien un fichier audio
            $allowedExtensions = ['mp3', 'wav', 'ogg', 'aac', 'm4a', 'flac', 'wma'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de fichier non autorisé'
                ], 403);
            }
            
            $mimeType = mime_content_type($path);
            
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'public, max-age=31536000'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement du fichier audio: ' . $e->getMessage()
            ], 500);
        }
    });
    
});
