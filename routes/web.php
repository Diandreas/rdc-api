<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SpeechController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\BiographyController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FileController;

// Route d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route pour changer de langue (accessible partout)
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');

// Routes pour servir les fichiers
Route::get('/files/{type}/{filename}', [FileController::class, 'serve'])->name('file.serve');

// Route de test temporaire (à supprimer après résolution)
Route::get('/test-language', function() {
    return 'Language system working! Route: ' . route('language.switch');
})->name('test.language');

// Routes d'authentification admin
Route::prefix('admin')->group(function () {
    // Routes publiques
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    // Routes protégées par authentification
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Discours
        Route::resource('speeches', SpeechController::class)->names('admin.speeches');
        
        // Actualités
        Route::resource('news', NewsController::class)->names('admin.news');
        
        // Citations
        Route::resource('quotes', QuoteController::class)->names('admin.quotes');
        
        // Photos
        Route::resource('photos', PhotoController::class)->names('admin.photos');
        
        // Vidéos
        Route::resource('videos', VideoController::class)->names('admin.videos');
        
        // Catégories
        Route::resource('categories', CategoryController::class)->names('admin.categories');
        
        
        // Actes du chef de l'état
        Route::resource('social-links', SocialLinkController::class)->names('admin.social-links');
        
        // Biographie
        Route::resource('biographies', BiographyController::class)->names('admin.biographies');
        
        // Statistiques de vues
        Route::get('statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
        Route::get('statistics/export', [StatisticsController::class, 'exportCsv'])->name('admin.statistics.export');
    });
});

