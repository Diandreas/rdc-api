<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\ViewStatistic;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Obtenir toutes les actualités
     */
    public function index()
    {
        try {
            $news = News::with(['category'])->latest('created_at')->get();
            
            // Incrémenter les vues pour toutes les actualités affichées
            foreach ($news as $article) {
                ViewStatistic::incrementViews($article);
            }
            
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
    }

    /**
     * Obtenir une actualité spécifique
     */
    public function show($id)
    {
        try {
            $article = News::with(['category'])->findOrFail($id);
            
            // Incrémenter les vues pour cette actualité
            ViewStatistic::incrementViews($article);
            
            return response()->json([
                'success' => true,
                'data' => $article
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Actualité non trouvée'
            ], 404);
        }
    }
}