@extends('admin.layouts.app')

@section('title', 'Détail de la Photo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détail de la Photo</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.photos.edit', $photo) }}" class="bg-[#003DA5] hover:bg-[#002D7A] text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.photos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Photo principale -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-6">
            <div class="text-center">
                @if($photo->is_featured)
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 mb-4">
                        <i class="fas fa-star mr-1"></i>Photo mise en avant
                    </div>
                @endif
                
                @if($photo->image_url)
                    <div class="mb-6">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" 
                             class="max-w-full h-auto rounded-lg shadow-lg mx-auto" 
                             style="max-height: 600px;">
                    </div>
                @else
                    <div class="mb-6">
                        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-image text-6xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400">Aucune image disponible</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $photo->title }}
                </h2>
                
                @if($photo->description)
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                        {{ $photo->description }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Informations détaillées -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informations générales -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-[#003DA5]"></i>Informations générales
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->title }}</p>
                    </div>
                    
                    @if($photo->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->description }}</p>
                    </div>
                    @endif
                    
                    @if($photo->photographer)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photographe</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->photographer }}</p>
                    </div>
                    @endif
                    
                    @if($photo->location)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Localisation</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->location }}</p>
                    </div>
                    @endif
                    
                    @if($photo->event_type)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type d'événement</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->event_type }}</p>
                    </div>
                    @endif
                    
                    @if($photo->photo_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de la photo</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->photo_date->format('d/m/Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-cog mr-2 text-[#003DA5]"></i>Métadonnées
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <p class="mt-1">
                            @if($photo->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <i class="fas fa-star mr-1"></i>Mise en avant
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    <i class="fas fa-image mr-1"></i>Normal
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publication</label>
                        <p class="mt-1">
                            @if($photo->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-check mr-1"></i>Publiée
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <i class="fas fa-times mr-1"></i>Non publiée
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $photo->id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $photo->slug }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    @if($photo->published_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publié le</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $photo->published_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-chart-bar mr-2 text-[#003DA5]"></i>Statistiques
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $photo->views_count }}</div>
                    <div class="text-sm text-blue-600 dark:text-blue-400">Vues</div>
                </div>
                
                <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $photo->shares_count }}</div>
                    <div class="text-sm text-green-600 dark:text-green-400">Partages</div>
                </div>
                
                <div class="text-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $photo->tags->count() }}</div>
                    <div class="text-sm text-purple-600 dark:text-purple-400">Tags</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-tools mr-2 text-[#003DA5]"></i>Actions
            </h3>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.photos.edit', $photo) }}" class="bg-[#003DA5] hover:bg-[#002D7A] text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                
                <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
                
                <a href="{{ route('admin.photos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-list mr-2"></i>Voir toutes les photos
                </a>
                
                @if($photo->image_url)
                <a href="{{ $photo->image_url }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-external-link-alt mr-2"></i>Voir l'image
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
