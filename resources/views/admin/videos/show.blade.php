@extends('admin.layouts.app')

@section('title', 'Détails de la Vidéo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails de la Vidéo</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.videos.edit', $video) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.videos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $video->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $video->created_at->format('d/m/Y H:i') }}</span>
                            @if($video->event_date)
                                <span><i class="fas fa-video mr-1"></i>Événement: {{ $video->event_date->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if($video->featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-star mr-1"></i>À la une
                            </span>
                        @endif
                    </div>
                </div>

                @if($video->description)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $video->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Vidéo -->
            @if($video->video_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vidéo</h3>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                        <a href="{{ $video->video_url }}" target="_blank" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            <i class="fas fa-play mr-2"></i>Voir la vidéo
                        </a>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $video->video_url }}</p>
                    </div>
                </div>
            @endif

            <!-- Miniature -->
            @if($video->thumbnail_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Miniature</h3>
                    <div class="relative">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" 
                             class="w-full h-64 object-cover rounded-lg shadow-md">
                        <a href="{{ $video->thumbnail_url }}" target="_blank" 
                           class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm hover:bg-opacity-75">
                            <i class="fas fa-external-link-alt mr-1"></i>Voir
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $video->thumbnail_url }}</p>
                </div>
            @endif
        </div>

        <!-- Informations latérales -->
        <div class="space-y-6">
            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations</h3>
                
                <div class="space-y-4">
                    @if($video->duration)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durée</label>
                            <p class="text-gray-900 dark:text-white">{{ $video->duration }}</p>
                        </div>
                    @endif

                    @if($video->location)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Localisation</label>
                            <p class="text-gray-900 dark:text-white">{{ $video->location }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        @if($video->featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-star mr-1"></i>À la une
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                <i class="fas fa-video mr-1"></i>Normal
                            </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="text-gray-900 dark:text-white">{{ $video->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($video->updated_at != $video->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $video->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.videos.edit', $video) }}" 
                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline w-full" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.videos.index') }}" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Aperçu public -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aperçu public</h3>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <i class="fas fa-eye mr-1"></i>Vue d'ensemble
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Titre:</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ Str::limit($video->title, 30) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Durée:</span>
                            <span class="text-gray-900 dark:text-white">{{ $video->duration ?: 'Non spécifiée' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                            <span class="text-gray-900 dark:text-white">{{ $video->featured ? 'À la une' : 'Normal' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
