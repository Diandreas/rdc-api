<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\ViewStatistic;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Obtenir toutes les vidéos
     */
    public function index()
    {
        try {
            $videos = Video::latest()->get();
            
            // Incrémenter les vues pour toutes les vidéos affichées
            foreach ($videos as $video) {
                ViewStatistic::incrementViews($video);
            }
            
            return response()->json([
                'success' => true,
                'data' => $videos,
                'count' => $videos->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir une vidéo spécifique
     */
    public function show($id)
    {
        try {
            $video = Video::findOrFail($id);
            
            // Incrémenter les vues pour cette vidéo
            ViewStatistic::incrementViews($video);
            
            return response()->json([
                'success' => true,
                'data' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Vidéo non trouvée'
            ], 404);
        }
    }
}