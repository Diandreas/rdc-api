@extends('admin.layouts.app')

@section('title', 'Modifier la Vidéo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier la Vidéo</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.videos.show', $video) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('admin.videos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $video->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Titre de la vidéo">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Description de la vidéo">{{ old('description', $video->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL de la vidéo -->
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de la vidéo <span class="text-red-500">*</span>
                        </label>
                        <input type="url" id="video_url" name="video_url" value="{{ old('video_url', $video->video_url) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://youtube.com/watch?v=... ou https://vimeo.com/...">
                        @error('video_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL de la miniature -->
                    <div>
                        <label for="thumbnail_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de la miniature
                        </label>
                        <input type="url" id="thumbnail_url" name="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://example.com/thumbnail.jpg">
                        @if($video->thumbnail_url)
                            <div class="mt-2">
                                <img src="{{ $video->thumbnail_url }}" alt="Miniature actuelle" class="w-32 h-20 object-cover rounded">
                            </div>
                        @endif
                        @error('thumbnail_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Durée
                        </label>
                        <input type="text" id="duration" name="duration" value="{{ old('duration', $video->duration) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="00:05:30">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Date d'enregistrement -->
                    <div>
                        <label for="recorded_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date d'enregistrement <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="recorded_date" name="recorded_date" 
                               value="{{ old('recorded_date', $video->recorded_date ? $video->recorded_date->format('Y-m-d') : '') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('recorded_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Localisation
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location', $video->location) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Bangui, RCA">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Options</h3>
                        
                        <!-- À la une -->
                        <div class="flex items-center">
                            <input type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured', $video->featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Mettre à la une
                            </label>
                        </div>
                    </div>

                    <!-- Informations actuelles -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Informations actuelles</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Créé le:</span>
                                <span class="text-gray-900 dark:text-white">{{ $video->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($video->updated_at != $video->created_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Modifié le:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $video->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                                <span class="text-gray-900 dark:text-white">{{ $video->featured ? 'À la une' : 'Normal' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        
                        <a href="{{ route('admin.videos.show', $video) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
