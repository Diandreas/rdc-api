@extends('admin.layouts.app')

@section('title', 'Nouveau discours')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nouveau discours</h1>
            <p class="text-gray-600 dark:text-gray-400">Créez un nouveau discours du président</p>
        </div>
        <a href="{{ route('admin.speeches.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <!-- Formulaire -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form action="{{ route('admin.speeches.store') }}" method="POST" class="space-y-6 p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="lg:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Titre du discours <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('title') }}" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Extrait -->
                <div class="lg:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Extrait <span class="text-red-500">*</span>
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="3" 
                              class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                              placeholder="Résumé court du discours (max 500 caractères)"
                              required>{{ old('excerpt') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        <span id="excerpt-count">0</span>/500 caractères
                    </p>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="lg:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Contenu du discours <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="10" 
                              class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                              placeholder="Contenu complet du discours"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lieu -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Lieu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('location') }}" placeholder="Ex: Palais de la Renaissance, Bangui" required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type d'événement -->
                <div>
                    <label for="event_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Type d'événement <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="event_type" id="event_type" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('event_type') }}" placeholder="Ex: Investiture, Cérémonie, etc." required>
                    @error('event_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date du discours -->
                <div>
                    <label for="speech_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Date du discours <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="speech_date" id="speech_date" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('speech_date') }}" required>
                    @error('speech_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" 
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL Audio -->
                <div>
                    <label for="audio_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        URL Audio
                    </label>
                    <input type="url" name="audio_url" id="audio_url" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('audio_url') }}" placeholder="https://example.com/audio.mp3">
                    @error('audio_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL Vidéo -->
                <div>
                    <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        URL Vidéo
                    </label>
                    <input type="url" name="video_url" id="video_url" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=...">
                    @error('video_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Options -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant ce discours
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Les discours mis en avant apparaîtront en premier dans l'application mobile.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.speeches.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Créer le discours
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Compteur de caractères pour l'extrait
    document.getElementById('excerpt').addEventListener('input', function(e) {
        const count = e.target.value.length;
        document.getElementById('excerpt-count').textContent = count;
        
        if (count > 500) {
            document.getElementById('excerpt-count').classList.add('text-red-500');
        } else {
            document.getElementById('excerpt-count').classList.remove('text-red-500');
        }
    });

    // Initialiser le compteur
    document.addEventListener('DOMContentLoaded', function() {
        const excerpt = document.getElementById('excerpt');
        const count = excerpt.value.length;
        document.getElementById('excerpt-count').textContent = count;
    });
</script>
@endsection
