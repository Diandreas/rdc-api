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
    
    // Redirection vers le système de fichiers unifié
    Route::get('files/{type}/{folder}/{filename}', function($type, $folder, $filename) {
        return redirect()->route('file.serve', ['type' => $folder, 'filename' => $filename]);
    });
    
});
