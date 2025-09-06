@extends('admin.layouts.app')

@section('title', 'Modifier la Citation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier la Citation</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.quotes.show', $quote) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('admin.quotes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('admin.quotes.update', $quote) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Citation -->
                <div>
                    <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Citation <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="text" 
                        name="text" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('text') border-red-500 @enderror"
                        placeholder="Entrez la citation..."
                        required
                    >{{ old('text', $quote->content) }}</textarea>
                    @error('text')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Auteur -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Auteur <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="author" 
                        name="author" 
                        value="{{ old('author', $quote->metadata['author'] ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('author') border-red-500 @enderror"
                        placeholder="Nom de l'auteur..."
                        required
                    >
                    @error('author')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contexte -->
                <div>
                    <label for="context" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Contexte
                    </label>
                    <input 
                        type="text" 
                        id="context" 
                        name="context" 
                        value="{{ old('context', $quote->context) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('context') border-red-500 @enderror"
                        placeholder="Contexte de la citation (discours, interview, etc.)..."
                    >
                    @error('context')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de la citation -->
                <div>
                    <label for="quote_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date de la citation
                    </label>
                    <input 
                        type="date" 
                        id="quote_date" 
                        name="quote_date" 
                        value="{{ old('quote_date', $quote->quote_date ? $quote->quote_date->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('quote_date') border-red-500 @enderror"
                    >
                    @error('quote_date')
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
                        value="{{ old('location', $quote->location) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-[#003DA5] dark:bg-gray-700 dark:text-white @error('location') border-red-500 @enderror"
                        placeholder="Lieu où la citation a été prononcée..."
                    >
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mise en avant -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="featured" 
                        name="featured" 
                        value="1"
                        {{ old('featured', $quote->is_featured) ? 'checked' : '' }}
                        class="h-4 w-4 text-[#003DA5] focus:ring-[#003DA5] border-gray-300 dark:border-gray-600 rounded"
                    >
                    <label for="featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant cette citation
                    </label>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.quotes.show', $quote) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
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
    // Compteur de caractères pour la citation
    const textArea = document.getElementById('text');
    const maxLength = 1000;
    
    // Créer le compteur
    const counter = document.createElement('div');
    counter.className = 'text-sm text-gray-500 dark:text-gray-400 mt-1';
    textArea.parentNode.appendChild(counter);
    
    function updateCounter() {
        const length = textArea.value.length;
        counter.textContent = `${length}/${maxLength} caractères`;
        
        if (length > maxLength * 0.9) {
            counter.className = 'text-sm text-yellow-600 dark:text-yellow-400 mt-1';
        } else if (length > maxLength) {
            counter.className = 'text-sm text-red-600 dark:text-red-400 mt-1';
        } else {
            counter.className = 'text-sm text-gray-500 dark:text-gray-400 mt-1';
        }
    }
    
    textArea.addEventListener('input', updateCounter);
    updateCounter();
    
    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (textArea.value.length > maxLength) {
            e.preventDefault();
            alert('La citation ne peut pas dépasser 1000 caractères.');
            textArea.focus();
        }
    });
    
    // Confirmation avant soumission
    form.addEventListener('submit', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir modifier cette citation ?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
