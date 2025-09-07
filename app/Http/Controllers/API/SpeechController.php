<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use App\Models\ViewStatistic;
use Illuminate\Http\Request;

class SpeechController extends Controller
{
    /**
     * Obtenir tous les discours
     */
    public function index()
    {
        try {
            $speeches = Speech::with(['category'])->get();
            
            // Incrémenter les vues pour tous les discours affichés
            foreach ($speeches as $speech) {
                ViewStatistic::incrementViews($speech);
            }
            
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
    }

    /**
     * Obtenir un discours spécifique
     */
    public function show($id)
    {
        try {
            $speech = Speech::with(['category'])->findOrFail($id);
            
            // Incrémenter les vues pour ce discours
            ViewStatistic::incrementViews($speech);
            
            return response()->json([
                'success' => true,
                'data' => $speech
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Discours non trouvé'
            ], 404);
        }
    }
}