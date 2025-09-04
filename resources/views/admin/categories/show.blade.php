@extends('admin.layouts.app')

@section('title', 'Détails de la Catégorie')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails de la Catégorie</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $category->name }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $category->created_at->format('d/m/Y H:i') }}</span>
                            <span><i class="fas fa-tag mr-1"></i>Slug: {{ $category->slug }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full" style="background-color: {{ $category->color }};"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $category->color }}</span>
                    </div>
                </div>

                @if($category->description)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $category->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Statistiques -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistiques</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-microphone text-blue-600 dark:text-blue-400 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Discours</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $category->speeches_count }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-newspaper text-green-600 dark:text-green-400 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">Actualités</p>
                                <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $category->news_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu associé -->
            @if($category->speeches_count > 0 || $category->news_count > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contenu associé</h3>
                    
                    @if($category->speeches_count > 0)
                        <div class="mb-4">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">
                                <i class="fas fa-microphone mr-2"></i>Discours ({{ $category->speeches_count }})
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Cette catégorie contient {{ $category->speeches_count }} discours.
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($category->news_count > 0)
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">
                                <i class="fas fa-newspaper mr-2"></i>Actualités ({{ $category->news_count }})
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Cette catégorie contient {{ $category->news_count }} actualités.
                                </p>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                        <p class="text-gray-900 dark:text-white">{{ $category->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                        <p class="text-gray-900 dark:text-white">{{ $category->slug }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Couleur</label>
                        <div class="flex items-center mt-1">
                            <div class="w-6 h-6 rounded-full mr-2" style="background-color: {{ $category->color }};"></div>
                            <span class="text-gray-900 dark:text-white">{{ $category->color }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="text-gray-900 dark:text-white">{{ $category->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($category->updated_at != $category->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $category->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    @if($category->speeches_count == 0 && $category->news_count == 0)
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline w-full" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-3">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Cette catégorie ne peut pas être supprimée car elle contient du contenu.
                            </p>
                        </div>
                    @endif
                    
                    <a href="{{ route('admin.categories.index') }}" 
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
                            <span class="text-gray-600 dark:text-gray-400">Nom:</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ $category->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Slug:</span>
                            <span class="text-gray-900 dark:text-white">{{ $category->slug }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Contenu:</span>
                            <span class="text-gray-900 dark:text-white">{{ $category->speeches_count + $category->news_count }} éléments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
