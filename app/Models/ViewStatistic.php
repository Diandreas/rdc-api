<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ViewStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'date',
        'views'
    ];

    protected $casts = [
        'date' => 'date',
        'views' => 'integer'
    ];

    /**
     * Relation polymorphique vers le modèle visualisé
     */
    public function viewable()
    {
        return $this->morphTo();
    }

    /**
     * Incrémenter le nombre de vues pour un modèle donné à la date d'aujourd'hui
     */
    public static function incrementViews($model)
    {
        $today = Carbon::today();
        
        $stat = static::firstOrNew([
            'viewable_type' => get_class($model),
            'viewable_id' => $model->id,
            'date' => $today
        ]);
        
        $stat->views = ($stat->views ?? 0) + 1;
        $stat->save();
    }

    /**
     * Obtenir les statistiques pour un type de modèle donné
     */
    public static function getStatsForType($modelType, $startDate = null, $endDate = null)
    {
        $query = static::where('viewable_type', $modelType);
        
        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }
        
        return $query->with('viewable')
                    ->orderBy('date', 'desc')
                    ->get()
                    ->groupBy('viewable_id');
    }

    /**
     * Obtenir les statistiques totales par type de contenu
     */
    public static function getTotalStatsByType($startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }
        
        return $query->selectRaw('viewable_type, SUM(views_count) as total_views')
                    ->groupBy('viewable_type')
                    ->get()
                    ->keyBy('viewable_type');
    }

    /**
     * Obtenir les statistiques par jour pour un modèle donné
     */
    public static function getDailyStatsForModel($model, $days = 30)
    {
        $startDate = Carbon::today()->subDays($days);
        
        return static::where('viewable_type', get_class($model))
                    ->where('viewable_id', $model->id)
                    ->where('date', '>=', $startDate)
                    ->orderBy('date', 'desc')
                    ->get();
    }
}