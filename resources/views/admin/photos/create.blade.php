@extends('admin.layouts.app')

@section('title', 'Nouvelle Photo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nouvelle Photo</h1>
        <a href="{{ route('admin.photos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Titre de la photo">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Description de la photo">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Image <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Onglets pour choisir le mode -->
                        <div class="mb-4">
                            <div class="flex space-x-1 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                                <button type="button" id="tab-url" class="flex-1 py-2 px-3 text-sm font-medium rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">
                                    URL
                                </button>
                                <button type="button" id="tab-upload" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    Télécharger
                                </button>
                            </div>
                        </div>

                        <!-- URL de l'image -->
                        <div id="url-section">
                            <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="https://example.com/image.jpg">
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléchargement de fichier -->
                        <div id="upload-section" class="hidden">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                                <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden">
                                <label for="image_file" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        Cliquez pour sélectionner une image ou glissez-déposez ici
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        Formats acceptés: JPEG, PNG, JPG, GIF, WebP (max 10MB)
                                    </p>
                                </label>
                            </div>
                            @error('image_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Date de l'événement -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de l'événement
                        </label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Localisation
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
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
                            <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Mettre à la une
                            </label>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Créer la photo
                        </button>
                        
                        <a href="{{ route('admin.photos.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
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
    const tabUrl = document.getElementById('tab-url');
    const tabUpload = document.getElementById('tab-upload');
    const urlSection = document.getElementById('url-section');
    const uploadSection = document.getElementById('upload-section');
    const imageUrlInput = document.getElementById('image_url');
    const imageFileInput = document.getElementById('image_file');

    // Gestion des onglets
    tabUrl.addEventListener('click', function() {
        tabUrl.classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-white', 'shadow-sm');
        tabUrl.classList.remove('text-gray-500', 'dark:text-gray-400');
        tabUpload.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-white', 'shadow-sm');
        tabUpload.classList.add('text-gray-500', 'dark:text-gray-400');
        
        urlSection.classList.remove('hidden');
        uploadSection.classList.add('hidden');
        
        imageUrlInput.required = true;
        imageFileInput.required = false;
    });

    tabUpload.addEventListener('click', function() {
        tabUpload.classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-white', 'shadow-sm');
        tabUpload.classList.remove('text-gray-500', 'dark:text-gray-400');
        tabUrl.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-white', 'shadow-sm');
        tabUrl.classList.add('text-gray-500', 'dark:text-gray-400');
        
        uploadSection.classList.remove('hidden');
        urlSection.classList.add('hidden');
        
        imageFileInput.required = true;
        imageUrlInput.required = false;
    });

    // Gestion du drag & drop
    const uploadArea = uploadSection.querySelector('.border-dashed');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageFileInput.files = files;
            // Déclencher l'événement change pour afficher le nom du fichier
            imageFileInput.dispatchEvent(new Event('change'));
        }
    });

    // Afficher le nom du fichier sélectionné
    imageFileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            const label = uploadArea.querySelector('label');
            label.innerHTML = `
                <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    Fichier sélectionné: ${fileName}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500">
                    Cliquez pour changer de fichier
                </p>
            `;
        }
    });
});
</script>
@endsection
