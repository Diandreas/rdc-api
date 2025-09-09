@extends('admin.layouts.app')

@section('title', 'Détails de l\'Actualité')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails de l'Actualité</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.news.edit', $news) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.news.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $news->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $news->created_at->format('d/m/Y H:i') }}</span>
                            @if($news->published_at)
                                <span class="text-green-600"><i class="fas fa-check mr-1"></i>Publié le {{ $news->published_at->format('d/m/Y H:i') }}</span>
                            @else
                                <span class="text-gray-500"><i class="fas fa-clock mr-1"></i>Brouillon</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if($news->featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-star mr-1"></i>À la une
                            </span>
                        @endif
                        @if($news->priority)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Priorité
                            </span>
                        @endif
                    </div>
                </div>

                @if($news->excerpt)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Extrait</h3>
                        <p class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            {{ $news->excerpt }}
                        </p>
                    </div>
                @endif

                @if($news->content)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Contenu</h3>
                        <div class="prose max-w-none text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Médias -->
            @if($news->getFirstMediaUrl('featured_images') || $news->video_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Médias</h3>
                    
                    @if($news->getFirstMediaUrl('featured_images'))
                        <div class="mb-4">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">Image</h4>
                            <div class="relative">
                                <img src="{{ $news->getFirstMediaUrl('featured_images') }}" alt="{{ $news->title }}" 
                                     class="w-full h-64 object-cover rounded-lg shadow-md">
                                <a href="{{ $news->getFirstMediaUrl('featured_images') }}" target="_blank" 
                                   class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm hover:bg-opacity-75">
                                    <i class="fas fa-external-link-alt mr-1"></i>Voir
                                </a>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $news->getFirstMediaUrl('featured_images') }}</p>
                        </div>
                    @endif

                    @if($news->video_url)
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">Vidéo</h4>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <a href="{{ $news->video_url }}" target="_blank" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-play mr-2"></i>Voir la vidéo
                                </a>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $news->video_url }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Informations latérales -->
        <div class="space-y-6">
            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations</h3>
                
                <div class="space-y-4">
                    @if($news->category)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1" 
                                  style="background-color: {{ $news->category->color }}20; color: {{ $news->category->color }};">
                                {{ $news->category->name }}
                            </span>
                        </div>
                    @endif

                    @if($news->location)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Localisation</label>
                            <p class="text-gray-900 dark:text-white">{{ $news->location }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        @if($news->published_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-check mr-1"></i>Publié
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                <i class="fas fa-clock mr-1"></i>Brouillon
                            </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="text-gray-900 dark:text-white">{{ $news->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($news->updated_at != $news->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $news->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.news.edit', $news) }}" 
                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="inline w-full" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.news.index') }}" 
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
                            <span class="text-gray-900 dark:text-white font-medium">{{ Str::limit($news->title, 30) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Catégorie:</span>
                            <span class="text-gray-900 dark:text-white">{{ $news->category ? $news->category->name : 'Aucune' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                            <span class="text-gray-900 dark:text-white">{{ $news->published_at ? 'Publié' : 'Brouillon' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
