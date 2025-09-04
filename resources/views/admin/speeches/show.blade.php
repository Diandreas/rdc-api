@extends('admin.layouts.app')

@section('title', 'Détails du Discours')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails du Discours</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.speeches.edit', $speech) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.speeches.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
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
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $speech->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 mb-3">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $speech->speech_date ? $speech->speech_date->format('d/m/Y') : 'Date non définie' }}</span>
                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $speech->location }}</span>
                            @if($speech->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $speech->category->color }}20; color: {{ $speech->category->color }};">
                                    {{ $speech->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($speech->is_published)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-check mr-1"></i>Publié
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-clock mr-1"></i>Brouillon
                            </span>
                        @endif
                    </div>
                </div>

                @if($speech->excerpt)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Extrait</h3>
                        <p class="text-gray-700 dark:text-gray-300 italic">"{{ $speech->excerpt }}"</p>
                    </div>
                @endif

                @if($speech->content)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Contenu</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $speech->content !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Médias associés -->
            @if($speech->hasMedia())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-images mr-2"></i>Médias associés
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($speech->getMedia() as $media)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="aspect-w-16 aspect-h-9 mb-2">
                                    @if($media->mime_type && str_starts_with($media->mime_type, 'image/'))
                                        <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}" 
                                             class="w-full h-32 object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file text-3xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-900 dark:text-white font-medium truncate">{{ $media->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $media->mime_type }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Statistiques -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistiques</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-eye text-blue-600 dark:text-blue-400 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Vues</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $speech->views_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-download text-green-600 dark:text-green-400 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">Téléchargements</p>
                                <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $speech->downloads_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-heart text-purple-600 dark:text-purple-400 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-purple-800 dark:text-purple-200">Favoris</p>
                                <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $speech->favorites_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations latérales -->
        <div class="space-y-6">
            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                        <p class="text-gray-900 dark:text-white">{{ $speech->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <p class="text-gray-900 dark:text-white">{{ $speech->speech_date ? $speech->speech_date->format('d/m/Y') : 'Date non définie' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu</label>
                        <p class="text-gray-900 dark:text-white">{{ $speech->location }}</p>
                    </div>

                    @if($speech->category)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                            <div class="flex items-center mt-1">
                                <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $speech->category->color }};"></div>
                                <span class="text-gray-900 dark:text-white">{{ $speech->category->name }}</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <p class="text-gray-900 dark:text-white">
                            @if($speech->is_published)
                                <span class="text-green-600 dark:text-green-400">Publié</span>
                            @else
                                <span class="text-yellow-600 dark:text-yellow-400">Brouillon</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="text-gray-900 dark:text-white">{{ $speech->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($speech->updated_at != $speech->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $speech->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.speeches.edit', $speech) }}" 
                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    <form action="{{ route('admin.speeches.destroy', $speech) }}" method="POST" class="inline w-full" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce discours ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.speeches.index') }}" 
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
                            <span class="text-gray-900 dark:text-white font-medium truncate max-w-xs">{{ $speech->title }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Date:</span>
                            <span class="text-gray-900 dark:text-white">{{ $speech->speech_date ? $speech->speech_date->format('d/m/Y') : 'Date non définie' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Lieu:</span>
                            <span class="text-gray-900 dark:text-white truncate max-w-xs">{{ $speech->location }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                            <span class="text-gray-900 dark:text-white">
                                @if($speech->is_published)
                                    <span class="text-green-600 dark:text-green-400">Publié</span>
                                @else
                                    <span class="text-yellow-600 dark:text-yellow-400">Brouillon</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
