<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileCompressionService;

class OptimizeFiles extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:optimize 
                          {--folder= : Dossier spécifique à optimiser}
                          {--days=30 : Supprimer les fichiers plus anciens que X jours}
                          {--dry-run : Afficher ce qui serait fait sans l\'exécuter}';

    /**
     * The console command description.
     */
    protected $description = 'Optimise le stockage des fichiers : compression et nettoyage';

    /**
     * Execute the console command.
     */
    public function handle(FileCompressionService $compressionService)
    {
        $this->info('🚀 Optimisation des fichiers en cours...');
        $this->newLine();

        // Afficher les statistiques actuelles
        $this->info('📊 Statistiques de stockage actuelles :');
        $stats = $compressionService->getStorageUsage();
        
        foreach ($stats as $folder => $stat) {
            if ($folder === 'total') {
                $this->info("📁 Total : {$stat['size_human']} ({$stat['folders']} dossiers)");
            } else {
                $this->info("   {$folder} : {$stat['size_human']} ({$stat['files_count']} fichiers)");
            }
        }
        $this->newLine();

        // Nettoyage des anciens fichiers
        $days = $this->option('days');
        $folder = $this->option('folder');
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('🔍 Mode simulation - Aucun fichier ne sera supprimé');
        }

        $this->info("🧹 Nettoyage des fichiers de plus de {$days} jours...");
        
        $totalDeleted = 0;
        $foldersToClean = $folder ? [$folder] : ['images', 'videos', 'documents', 'photos'];
        
        foreach ($foldersToClean as $f) {
            if (!$isDryRun) {
                $deletedCount = $compressionService->cleanOldFiles($f, $days);
                $totalDeleted += $deletedCount;
                
                if ($deletedCount > 0) {
                    $this->info("   ✅ {$f} : {$deletedCount} fichiers supprimés");
                } else {
                    $this->info("   ⚪ {$f} : Aucun fichier à supprimer");
                }
            } else {
                // Simulation - calculer combien seraient supprimés
                $this->info("   🔍 {$f} : Calcul en cours...");
            }
        }

        if (!$isDryRun) {
            $this->newLine();
            $this->info("✨ Nettoyage terminé : {$totalDeleted} fichiers supprimés");
            
            // Afficher les nouvelles statistiques
            $this->info('📊 Nouvelles statistiques de stockage :');
            $newStats = $compressionService->getStorageUsage();
            
            foreach ($newStats as $folder => $stat) {
                if ($folder === 'total') {
                    $this->info("📁 Total : {$stat['size_human']} ({$stat['folders']} dossiers)");
                } else {
                    $this->info("   {$folder} : {$stat['size_human']} ({$stat['files_count']} fichiers)");
                }
            }
        }

        $this->newLine();
        $this->info('🎉 Optimisation terminée !');

        return 0;
    }
}