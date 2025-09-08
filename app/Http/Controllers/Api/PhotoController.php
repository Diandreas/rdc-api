<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\ViewStatistic;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Obtenir toutes les photos
     */
    public function index()
    {
        try {
            $photos = Photo::latest()->get();
            
            // Incrémenter les vues pour toutes les photos affichées
            foreach ($photos as $photo) {
                ViewStatistic::incrementViews($photo);
            }
            
            return response()->json([
                'success' => true,
                'data' => $photos,
                'count' => $photos->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir une photo spécifique
     */
    public function show($id)
    {
        try {
            $photo = Photo::findOrFail($id);
            
            // Incrémenter les vues pour cette photo
            ViewStatistic::incrementViews($photo);
            
            return response()->json([
                'success' => true,
                'data' => $photo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Photo non trouvée'
            ], 404);
        }
    }
}