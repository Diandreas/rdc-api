@extends('admin.layouts.app')

@section('title', 'Modifier la Photo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier la Photo</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.photos.show', $photo) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('admin.photos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('admin.photos.update', $photo) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $photo->title) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror"
                        placeholder="Titre de la photo..."
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"
                        placeholder="Description de la photo..."
                    >{{ old('description', $photo->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                        <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $photo->image_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://example.com/image.jpg">
                        @error('image_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        @if($photo->image_url)
                            <div class="mt-2">
                                <img src="{{ $photo->image_url }}" alt="Image actuelle" class="w-32 h-20 object-cover rounded">
                            </div>
                        @endif
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

                <!-- Date de l'événement -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date de l'événement
                    </label>
                    <input 
                        type="date" 
                        id="event_date" 
                        name="event_date" 
                        value="{{ old('event_date', $photo->photo_date ? $photo->photo_date->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('event_date') border-red-500 @enderror"
                    >
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Localisation -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Localisation
                    </label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="{{ old('location', $photo->location) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('location') border-red-500 @enderror"
                        placeholder="Lieu où la photo a été prise..."
                    >
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photographe -->
                <div>
                    <label for="photographer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Photographe
                    </label>
                    <input 
                        type="text" 
                        id="photographer" 
                        name="photographer" 
                        value="{{ old('photographer', $photo->photographer) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('photographer') border-red-500 @enderror"
                        placeholder="Nom du photographe..."
                    >
                    @error('photographer')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type d'événement -->
                <div>
                    <label for="event_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type d'événement
                    </label>
                    <input 
                        type="text" 
                        id="event_type" 
                        name="event_type" 
                        value="{{ old('event_type', $photo->event_type) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('event_type') border-red-500 @enderror"
                        placeholder="Type d'événement (cérémonie, réunion, etc.)..."
                    >
                    @error('event_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mise en avant -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="is_featured" 
                        name="is_featured" 
                        value="1"
                        {{ old('is_featured', $photo->is_featured) ? 'checked' : '' }}
                        class="h-4 w-4 text-[#003DA5] focus:ring-[#003DA5] border-gray-300 dark:border-gray-600 rounded"
                    >
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant cette photo
                    </label>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.photos.show', $photo) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Annuler
                    </a>
                    <button type="submit" class="bg-[#003DA5] hover:bg-[#002D7A] text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour la description
    const descriptionTextarea = document.getElementById('description');
    const maxLength = 500;
    
    // Créer le compteur
    const counter = document.createElement('div');
    counter.className = 'text-sm text-gray-500 dark:text-gray-400 mt-1';
    descriptionTextarea.parentNode.appendChild(counter);
    
    function updateCounter() {
        const length = descriptionTextarea.value.length;
        counter.textContent = `${length}/${maxLength} caractères`;
        
        if (length > maxLength * 0.9) {
            counter.className = 'text-sm text-yellow-600 dark:text-yellow-400 mt-1';
        } else if (length > maxLength) {
            counter.className = 'text-sm text-red-600 dark:text-red-400 mt-1';
        } else {
            counter.className = 'text-sm text-gray-500 dark:text-gray-400 mt-1';
        }
    }
    
    descriptionTextarea.addEventListener('input', updateCounter);
    updateCounter();
    
    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (descriptionTextarea.value.length > maxLength) {
            e.preventDefault();
            alert('La description ne peut pas dépasser 500 caractères.');
            descriptionTextarea.focus();
        }
        
        if (!confirm('Êtes-vous sûr de vouloir modifier cette photo ?')) {
            e.preventDefault();
        }
    });
    
    // Aperçu de l'image en temps réel
    const imageUrlInput = document.getElementById('image_url');
    const previewContainer = document.createElement('div');
    previewContainer.className = 'mt-2';
    imageUrlInput.parentNode.appendChild(previewContainer);
    
    function updateImagePreview() {
        const url = imageUrlInput.value;
        if (url && url.match(/\.(jpeg|jpg|gif|png|webp)$/)) {
            previewContainer.innerHTML = `<img src="${url}" alt="Aperçu" class="w-32 h-32 object-cover rounded-lg border" onerror="this.style.display='none'">`;
        } else {
            previewContainer.innerHTML = '';
        }
    }
    
    imageUrlInput.addEventListener('input', updateImagePreview);

    // Gestion des onglets pour l'upload
    const tabUrl = document.getElementById('tab-url');
    const tabUpload = document.getElementById('tab-upload');
    const urlSection = document.getElementById('url-section');
    const uploadSection = document.getElementById('upload-section');
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
