@extends('admin.layouts.app')

@section('title', 'Gestion du stockage')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-hdd mr-3 text-primary-600"></i>
                    Gestion du stockage
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Surveillance et optimisation de l'espace de stockage des fichiers
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="refreshStats()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Actualiser
                </button>
            </div>
        </div>

        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            @foreach($stats as $folder => $stat)
                @if($folder !== 'total')
                    @php
                        $icons = [
                            'images' => ['icon' => 'fas fa-image', 'color' => 'bg-blue-500'],
                            'photos' => ['icon' => 'fas fa-camera', 'color' => 'bg-purple-500'],
                            'videos' => ['icon' => 'fas fa-video', 'color' => 'bg-red-500'],
                            'documents' => ['icon' => 'fas fa-file-alt', 'color' => 'bg-green-500']
                        ];
                        $config = $icons[$folder] ?? ['icon' => 'fas fa-folder', 'color' => 'bg-gray-500'];
                    @endphp
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 {{ $config['color'] }} rounded-md flex items-center justify-center">
                                        <i class="{{ $config['icon'] }} text-white text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate capitalize">{{ $folder }}</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stat['size_human'] }}</dd>
                                        <dd class="text-xs text-gray-500">{{ $stat['files_count'] }} fichiers</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Espace total -->
        @if(isset($stats['total']))
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Espace total utilisé</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Total sur {{ $stats['total']['folders'] }} dossiers
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-primary-600">{{ $stats['total']['size_human'] }}</div>
                        <div class="text-sm text-gray-500">{{ number_format($stats['total']['size'] / 1024 / 1024, 2) }} MB</div>
                    </div>
                </div>
                
                <!-- Barre de progression (simulation) -->
                <div class="mt-4">
                    @php
                        $totalMB = $stats['total']['size'] / 1024 / 1024;
                        $maxMB = 1000; // Limite simulée de 1GB
                        $percentage = min(($totalMB / $maxMB) * 100, 100);
                        $colorClass = $percentage > 80 ? 'bg-red-500' : ($percentage > 60 ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $colorClass }} h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>0 MB</span>
                        <span>{{ number_format($totalMB, 0) }} MB utilisés</span>
                        <span>{{ $maxMB }} MB</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Nettoyage des fichiers -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-trash-alt mr-2 text-red-600"></i>
                        Nettoyage des fichiers
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Supprimer les anciens fichiers pour libérer de l'espace de stockage.
                    </p>
                    
                    <form method="POST" action="{{ route('admin.storage.cleanup') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces fichiers ?')">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="days" class="block text-sm font-medium text-gray-700">
                                    Supprimer les fichiers plus anciens que :
                                </label>
                                <select name="days" id="days" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    <option value="7">7 jours</option>
                                    <option value="30" selected>30 jours</option>
                                    <option value="60">60 jours</option>
                                    <option value="90">90 jours</option>
                                    <option value="180">6 mois</option>
                                    <option value="365">1 an</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="folder" class="block text-sm font-medium text-gray-700">
                                    Dossier (optionnel) :
                                </label>
                                <select name="folder" id="folder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    <option value="">Tous les dossiers</option>
                                    <option value="images">Images</option>
                                    <option value="photos">Photos</option>
                                    <option value="videos">Vidéos</option>
                                    <option value="documents">Documents</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-2"></i>
                                Nettoyer maintenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations système -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Informations système
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Compression d'images</span>
                            <span class="text-sm font-medium text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>Activée (WebP)
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Cache des images</span>
                            <span class="text-sm font-medium text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>Activé
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Compression vidéo</span>
                            <span class="text-sm font-medium text-yellow-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Basique
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Comptage des vues</span>
                            <span class="text-sm font-medium text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>Activé
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Commande Artisan</h4>
                        <code class="block text-xs bg-gray-100 p-2 rounded text-gray-800">
                            php artisan files:optimize --days=30
                        </code>
                        <p class="text-xs text-gray-500 mt-1">
                            Utilisez cette commande pour automatiser l'optimisation via un cron job.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshStats() {
    // Actualiser la page
    location.reload();
}

// Auto-refresh toutes les 30 secondes
setInterval(refreshStats, 30000);
</script>
@endsection