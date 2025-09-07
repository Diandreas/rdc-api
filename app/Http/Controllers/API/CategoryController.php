<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ViewStatistic;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Obtenir toutes les catégories
     */
    public function index()
    {
        try {
            $categories = Category::all();
            
            // Incrémenter les vues pour toutes les catégories affichées
            foreach ($categories as $category) {
                ViewStatistic::incrementViews($category);
            }
            
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
    }

    /**
     * Obtenir une catégorie spécifique
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            // Incrémenter les vues pour cette catégorie
            ViewStatistic::incrementViews($category);
            
            return response()->json([
                'success' => true,
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Catégorie non trouvée'
            ], 404);
        }
    }

    /**
     * Obtenir les catégories par type
     */
    public function byType($type)
    {
        try {
            $categories = Category::byType($type)->active()->get();
            
            // Incrémenter les vues pour toutes les catégories affichées
            foreach ($categories as $category) {
                ViewStatistic::incrementViews($category);
            }
            
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
    }
}