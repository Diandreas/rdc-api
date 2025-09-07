@extends('admin.layouts.app')

@section('title', 'Statistiques des vues')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-chart-line mr-3 text-primary-600"></i>
                    Statistiques des vues
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Vue d'ensemble des statistiques de consultation des contenus
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <!-- Filtres de période -->
                <form method="GET" class="flex space-x-2">
                    <select name="period" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        <option value="7" {{ $period == 7 ? 'selected' : '' }}>7 derniers jours</option>
                        <option value="30" {{ $period == 30 ? 'selected' : '' }}>30 derniers jours</option>
                        <option value="90" {{ $period == 90 ? 'selected' : '' }}>90 derniers jours</option>
                        <option value="365" {{ $period == 365 ? 'selected' : '' }}>Dernière année</option>
                    </select>
                </form>
                
                <!-- Bouton d'export -->
                <a href="{{ route('admin.statistics.export', ['period' => $period]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-download mr-2"></i>
                    Exporter CSV
                </a>
            </div>
        </div>

        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            @foreach($totalStats as $type => $stat)
                @php
                    $icons = [
                        'App\\Models\\Category' => 'fas fa-folder',
                        'App\\Models\\Speech' => 'fas fa-microphone',
                        'App\\Models\\News' => 'fas fa-newspaper',
                        'App\\Models\\Photo' => 'fas fa-image',
                        'App\\Models\\Video' => 'fas fa-video'
                    ];
                    $labels = [
                        'App\\Models\\Category' => 'Catégories',
                        'App\\Models\\Speech' => 'Discours',
                        'App\\Models\\News' => 'Actualités',
                        'App\\Models\\Photo' => 'Photos',
                        'App\\Models\\Video' => 'Vidéos'
                    ];
                    $colors = [
                        'App\\Models\\Category' => 'bg-blue-500',
                        'App\\Models\\Speech' => 'bg-green-500',
                        'App\\Models\\News' => 'bg-yellow-500',
                        'App\\Models\\Photo' => 'bg-purple-500',
                        'App\\Models\\Video' => 'bg-red-500'
                    ];
                @endphp
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 {{ $colors[$type] ?? 'bg-gray-500' }} rounded-md flex items-center justify-center">
                                    <i class="{{ $icons[$type] ?? 'fas fa-file' }} text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $labels[$type] ?? class_basename($type) }}</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($stat->total_views) }} vues</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Graphique des vues quotidiennes -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-area mr-2 text-primary-600"></i>
                    Évolution quotidienne des vues
                </h3>
                <div class="mt-5">
                    <canvas id="dailyStatsChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Statistiques par catégorie -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-folder mr-2 text-primary-600"></i>
                        Vues par catégorie
                    </h3>
                    <div class="space-y-4">
                        @foreach($categoryStats->take(10) as $stat)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $stat['category']->color }}"></div>
                                    <span class="text-sm font-medium text-gray-900">{{ $stat['category']->name }}</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-500">
                                        {{ number_format($stat['total_views']) }} vues
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        D: {{ $stat['direct_views'] }} | 
                                        S: {{ $stat['speeches_views'] }} | 
                                        N: {{ $stat['news_views'] }} | 
                                        P: {{ $stat['photos_views'] }} | 
                                        V: {{ $stat['videos_views'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top contenu le plus vu -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-trophy mr-2 text-primary-600"></i>
                        Top 10 - Contenu le plus vu
                    </h3>
                    <div class="space-y-3">
                        @foreach($topContent as $index => $item)
                            @php
                                $typeIcons = [
                                    'Category' => 'fas fa-folder',
                                    'Speech' => 'fas fa-microphone',
                                    'News' => 'fas fa-newspaper',
                                    'Photo' => 'fas fa-image',
                                    'Video' => 'fas fa-video'
                                ];
                                $typeColors = [
                                    'Category' => 'text-blue-600',
                                    'Speech' => 'text-green-600',
                                    'News' => 'text-yellow-600',
                                    'Photo' => 'text-purple-600',
                                    'Video' => 'text-red-600'
                                ];
                            @endphp
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-medium text-gray-600">
                                        {{ $index + 1 }}
                                    </span>
                                    <i class="{{ $typeIcons[$item['type']] ?? 'fas fa-file' }} {{ $typeColors[$item['type']] ?? 'text-gray-600' }} text-sm"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($item['title'], 40) }}</p>
                                        <p class="text-xs text-gray-500">{{ $item['type'] }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($item['views']) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour le graphique -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour le graphique quotidien
    const dailyData = @json($dailyStats);
    
    // Générer les derniers jours
    const days = {{ $period }};
    const labels = [];
    const data = [];
    const today = new Date();
    
    for (let i = days - 1; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - i);
        const dateString = date.toISOString().split('T')[0];
        
        labels.push(date.toLocaleDateString('fr-FR', { 
            month: 'short', 
            day: 'numeric' 
        }));
        
        data.push(dailyData[dateString] ? dailyData[dateString].total_views : 0);
    }
    
    // Configuration du graphique
    const ctx = document.getElementById('dailyStatsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Vues quotidiennes',
                data: data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection