@extends('admin.layouts.app')

@section('title', 'Nouvelle Publication')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nouvelle Publication</h1>
        <a href="{{ route('admin.publications.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.publications.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror"
                       placeholder="Entrez le titre de la publication"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"
                          placeholder="Entrez une description pour la publication (optionnel)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL du PDF -->
            <div>
                <label for="pdf_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    URL du PDF <span class="text-red-500">*</span>
                </label>
                <input type="url"
                       id="pdf_url"
                       name="pdf_url"
                       value="{{ old('pdf_url') }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('pdf_url') border-red-500 @enderror"
                       placeholder="https://example.com/document.pdf"
                       required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Entrez l'URL complète du fichier PDF (ex: https://example.com/document.pdf)
                </p>
                @error('pdf_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.publications.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Créer la publication
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfUrlInput = document.getElementById('pdf_url');

    pdfUrlInput.addEventListener('input', function(e) {
        const url = e.target.value;

        if (url && !url.toLowerCase().endsWith('.pdf')) {
            // Ajouter une classe pour indiquer que l'URL pourrait ne pas être un PDF
            pdfUrlInput.classList.add('border-yellow-400');
            pdfUrlInput.classList.remove('border-green-400');
        } else if (url && url.toLowerCase().endsWith('.pdf')) {
            // URL semble être un PDF
            pdfUrlInput.classList.add('border-green-400');
            pdfUrlInput.classList.remove('border-yellow-400');
        } else {
            // Vide ou invalide
            pdfUrlInput.classList.remove('border-yellow-400', 'border-green-400');
        }
    });
});
</script>
@endsection