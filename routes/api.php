<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    
    Route::get('categories', function () {
        try {
            $categories = \App\Models\Category::all();
            return response()->json([
                'success' => true,
                'data' => $categories,
                'count' => $categories->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('speeches', function () {
        try {
            $speeches = \App\Models\Speech::with(['category'])->get();
            return response()->json([
                'success' => true,
                'data' => $speeches,
                'count' => $speeches->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('news', function () {
        try {
            $news = \App\Models\News::with(['category'])->get();
            return response()->json([
                'success' => true,
                'data' => $news,
                'count' => $news->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
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
    
});
