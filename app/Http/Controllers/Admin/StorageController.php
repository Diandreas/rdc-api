<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FileCompressionService;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    protected $compressionService;

    public function __construct(FileCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

    /**
     * Afficher la page de gestion du stockage
     */
    public function index()
    {
        try {
            $stats = $this->compressionService->getStorageUsage();
            
            return view('admin.storage.index', compact('stats'));
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors du chargement des statistiques: ' . $e->getMessage()]);
        }
    }

    /**
     * Nettoyer les anciens fichiers
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
            'folder' => 'nullable|string|in:images,videos,documents,photos'
        ]);

        try {
            $days = $request->get('days', 30);
            $folder = $request->get('folder');
            
            if ($folder) {
                $deletedCount = $this->compressionService->cleanOldFiles($folder, $days);
                $message = "Nettoyage terminé pour le dossier {$folder}. {$deletedCount} fichiers supprimés.";
            } else {
                $deletedCount = 0;
                foreach (['images', 'videos', 'documents', 'photos'] as $f) {
                    $deletedCount += $this->compressionService->cleanOldFiles($f, $days);
                }
                $message = "Nettoyage général terminé. {$deletedCount} fichiers supprimés.";
            }
            
            return redirect()->route('admin.storage.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors du nettoyage: ' . $e->getMessage()]);
        }
    }

    /**
     * Obtenir les statistiques via API
     */
    public function stats()
    {
        try {
            $stats = $this->compressionService->getStorageUsage();
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques'
            ], 500);
        }
    }
}