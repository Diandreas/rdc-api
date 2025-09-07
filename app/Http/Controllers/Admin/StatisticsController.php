<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewStatistic;
use App\Models\Category;
use App\Models\Speech;
use App\Models\News;
use App\Models\Photo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Afficher la page des statistiques générales
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 30); // Par défaut 30 jours
        $startDate = Carbon::today()->subDays($period);
        $endDate = Carbon::today();

        // Statistiques générales par type de contenu
        $totalStats = ViewStatistic::getTotalStatsByType($startDate, $endDate);

        // Statistiques par catégorie
        $categoryStats = $this->getCategoryStats($startDate, $endDate);

        // Statistiques des derniers jours (pour le graphique)
        $dailyStats = $this->getDailyStats($startDate, $endDate);

        // Top 10 des contenus les plus vus
        $topContent = $this->getTopContent($startDate, $endDate);

        return view('admin.statistics.index', compact(
            'totalStats', 
            'categoryStats', 
            'dailyStats', 
            'topContent', 
            'period'
        ));
    }

    /**
     * Obtenir les statistiques par catégorie
     */
    private function getCategoryStats($startDate, $endDate)
    {
        $categories = Category::all();
        $categoryStats = [];

        foreach ($categories as $category) {
            // Compter les vues pour chaque type de contenu dans cette catégorie
            $speechesViews = ViewStatistic::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('viewable_type', 'App\\Models\\Speech')
                ->whereIn('viewable_id', $category->speeches->pluck('id'))
                ->sum('views_count');

            $newsViews = ViewStatistic::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('viewable_type', 'App\\Models\\News')
                ->whereIn('viewable_id', $category->news->pluck('id'))
                ->sum('views_count');

            $photosViews = ViewStatistic::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('viewable_type', 'App\\Models\\Photo')
                ->whereIn('viewable_id', $category->photos->pluck('id'))
                ->sum('views_count');

            $videosViews = ViewStatistic::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('viewable_type', 'App\\Models\\Video')
                ->whereIn('viewable_id', $category->videos->pluck('id'))
                ->sum('views_count');

            // Vues directes de la catégorie elle-même
            $categoryDirectViews = ViewStatistic::whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('viewable_type', 'App\\Models\\Category')
                ->where('viewable_id', $category->id)
                ->sum('views_count');

            $categoryStats[] = [
                'category' => $category,
                'total_views' => $speechesViews + $newsViews + $photosViews + $videosViews + $categoryDirectViews,
                'speeches_views' => $speechesViews,
                'news_views' => $newsViews,
                'photos_views' => $photosViews,
                'videos_views' => $videosViews,
                'direct_views' => $categoryDirectViews
            ];
        }

        // Trier par nombre total de vues
        usort($categoryStats, function($a, $b) {
            return $b['total_views'] <=> $a['total_views'];
        });

        return $categoryStats;
    }

    /**
     * Obtenir les statistiques quotidiennes
     */
    private function getDailyStats($startDate, $endDate)
    {
        return ViewStatistic::selectRaw('date, SUM(views_count) as total_views')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy(function($item) {
                return $item->date->format('Y-m-d');
            });
    }

    /**
     * Obtenir le top du contenu le plus vu
     */
    private function getTopContent($startDate, $endDate, $limit = 10)
    {
        $topItems = ViewStatistic::with('viewable')
            ->selectRaw('viewable_type, viewable_id, SUM(views_count) as total_views')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->groupBy('viewable_type', 'viewable_id')
            ->orderBy('total_views', 'desc')
            ->limit($limit)
            ->get();

        return $topItems->map(function($item) {
            $modelName = class_basename($item->viewable_type);
            $title = 'Contenu supprimé';
            
            if ($item->viewable) {
                switch ($modelName) {
                    case 'Category':
                        $title = $item->viewable->name;
                        break;
                    case 'Speech':
                    case 'News':
                    case 'Photo':
                    case 'Video':
                        $title = $item->viewable->title ?? 'Sans titre';
                        break;
                }
            }

            return [
                'type' => $modelName,
                'title' => $title,
                'views' => $item->total_views,
                'model' => $item->viewable
            ];
        });
    }

    /**
     * Exporter les statistiques en CSV
     */
    public function exportCsv(Request $request)
    {
        $period = $request->get('period', 30);
        $startDate = Carbon::today()->subDays($period);
        $endDate = Carbon::today();

        $categoryStats = $this->getCategoryStats($startDate, $endDate);

        $filename = 'statistiques_vues_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categoryStats) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Catégorie',
                'Vues totales',
                'Vues directes',
                'Vues discours',
                'Vues actualités',
                'Vues photos',
                'Vues vidéos'
            ]);

            // Données
            foreach ($categoryStats as $stat) {
                fputcsv($file, [
                    $stat['category']->name,
                    $stat['total_views'],
                    $stat['direct_views'],
                    $stat['speeches_views'],
                    $stat['news_views'],
                    $stat['photos_views'],
                    $stat['videos_views']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}