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

                <!-- URL de l'image -->
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        URL de l'image <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url', $photo->image_url) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('image_url') border-red-500 @enderror"
                        placeholder="https://example.com/image.jpg"
                        required
                    >
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    
                    <!-- Aperçu de l'image -->
                    @if($photo->image_url)
                    <div class="mt-2">
                        <img src="{{ $photo->image_url }}" alt="Aperçu" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                    @endif
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
});
</script>
@endsection
