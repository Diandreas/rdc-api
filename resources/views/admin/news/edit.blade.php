@extends('admin.layouts.app')

@section('title', 'Modifier l\'Actualité')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier l'Actualité</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.news.show', $news) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('admin.news.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Titre de l'actualité">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Extrait -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Extrait <span class="text-red-500">*</span>
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Résumé court de l'actualité">{{ old('excerpt', $news->excerpt) }}</textarea>
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="excerpt-count">0</span>/200 caractères
                        </div>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contenu <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" name="content" rows="12" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Contenu détaillé de l'actualité">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL de l'image -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de l'image
                        </label>
                        <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $news->image_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://example.com/image.jpg">
                        @error('image_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Prévisualisation de l'image -->
                        <div id="image-preview" class="mt-3 {{ $news->image_url ? '' : 'hidden' }}">
                            <img id="preview-img" src="{{ $news->image_url }}" alt="Prévisualisation" class="max-w-full h-48 object-cover rounded-lg border">
                            <p class="text-sm text-gray-500 mt-1">Prévisualisation de l'image</p>
                        </div>
                    </div>

                    <!-- URL de la vidéo -->
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de la vidéo
                        </label>
                        <input type="url" id="video_url" name="video_url" value="{{ old('video_url', $news->video_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://youtube.com/watch?v=...">
                        @error('video_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Catégorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catégorie
                        </label>
                        <select id="category_id" name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Aucune catégorie</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date de publication -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de publication
                        </label>
                        <input type="datetime-local" id="published_at" name="published_at" 
                               value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Localisation
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location', $news->location) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Bangui, RCA">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Options</h3>
                        
                        <!-- Priorité -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Priorité <span class="text-red-500">*</span>
                            </label>
                            <select id="priority" name="priority" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Sélectionner une priorité</option>
                                <option value="low" {{ old('priority', $news->priority) == 'low' ? 'selected' : '' }}>Faible</option>
                                <option value="medium" {{ old('priority', $news->priority) == 'medium' ? 'selected' : '' }}>Normale</option>
                                <option value="high" {{ old('priority', $news->priority) == 'high' ? 'selected' : '' }}>Élevée</option>
                                <option value="urgent" {{ old('priority', $news->priority) == 'urgent' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- À la une -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Mettre à la une
                            </label>
                        </div>

                        <!-- Publier maintenant -->
                        <div class="flex items-center">
                            <input type="checkbox" id="publish_now" name="publish_now" value="1"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="publish_now" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Publier maintenant
                            </label>
                        </div>
                    </div>

                    <!-- Informations actuelles -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Informations actuelles</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Créé le:</span>
                                <span class="text-gray-900 dark:text-white">{{ $news->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($news->updated_at != $news->created_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Modifié le:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                                <span class="text-gray-900 dark:text-white">{{ $news->published_at ? 'Publié' : 'Brouillon' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        
                        <a href="{{ route('admin.news.show', $news) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerpt-count');
    const publishNowCheckbox = document.getElementById('publish_now');
    const publishedAtInput = document.getElementById('published_at');
    const imageUrlInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    // Compteur de caractères pour l'extrait
    function updateExcerptCount() {
        const count = excerptTextarea.value.length;
        excerptCount.textContent = count;
        
        if (count > 200) {
            excerptCount.classList.add('text-red-600');
            excerptCount.classList.remove('text-gray-500');
        } else {
            excerptCount.classList.remove('text-red-600');
            excerptCount.classList.add('text-gray-500');
        }
    }

    excerptTextarea.addEventListener('input', updateExcerptCount);
    updateExcerptCount();

    // Prévisualisation de l'image
    function updateImagePreview() {
        const url = imageUrlInput.value.trim();
        
        if (url && isValidUrl(url)) {
            previewImg.src = url;
            previewImg.onload = function() {
                imagePreview.classList.remove('hidden');
            };
            previewImg.onerror = function() {
                imagePreview.classList.add('hidden');
            };
        } else {
            imagePreview.classList.add('hidden');
        }
    }

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    imageUrlInput.addEventListener('input', updateImagePreview);
    imageUrlInput.addEventListener('blur', updateImagePreview);

    // Publier maintenant
    publishNowCheckbox.addEventListener('change', function() {
        if (this.checked) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            publishedAtInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        } else {
            publishedAtInput.value = '';
        }
    });
});
</script>
@endsection
