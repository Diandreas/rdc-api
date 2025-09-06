@extends('admin.layouts.app')

@section('title', 'Nouvelle Section Biographique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nouvelle Section Biographique</h1>
        <a href="{{ route('admin.biographies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.biographies.store') }}" method="POST">
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
                               placeholder="Titre de la section">
                        @error('title')
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
                                  placeholder="Contenu de la section biographique">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Section <span class="text-red-500">*</span>
                        </label>
                        <select id="section" name="section" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionner une section</option>
                            <option value="early_life" {{ old('section') == 'early_life' ? 'selected' : '' }}>Enfance</option>
                            <option value="education" {{ old('section') == 'education' ? 'selected' : '' }}>Éducation</option>
                            <option value="career" {{ old('section') == 'career' ? 'selected' : '' }}>Carrière</option>
                            <option value="presidency" {{ old('section') == 'presidency' ? 'selected' : '' }}>Présidence</option>
                            <option value="achievements" {{ old('section') == 'achievements' ? 'selected' : '' }}>Réalisations</option>
                            <option value="personal" {{ old('section') == 'personal' ? 'selected' : '' }}>Vie personnelle</option>
                        </select>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ordre -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ordre d'affichage
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', 1) }}" min="1"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="1">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Options</h3>
                        
                        <!-- Actif -->
                        <div class="flex items-center">
                            <input type="checkbox" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Actif
                            </label>
                        </div>
                    </div>

                    <!-- Aperçu -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Aperçu</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Titre:</span>
                                <span id="title-preview" class="text-gray-900 dark:text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Ordre:</span>
                                <span id="order-preview" class="text-gray-900 dark:text-white">1</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                                <span id="status-preview" class="text-gray-900 dark:text-white">Actif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Créer la section
                        </button>
                        
                        <a href="{{ route('admin.biographies.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
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
    const titleInput = document.getElementById('title');
    const orderInput = document.getElementById('order');
    const activeCheckbox = document.getElementById('active');
    const titlePreview = document.getElementById('title-preview');
    const orderPreview = document.getElementById('order-preview');
    const statusPreview = document.getElementById('status-preview');

    function updatePreview() {
        titlePreview.textContent = titleInput.value || '-';
        orderPreview.textContent = orderInput.value || '1';
        statusPreview.textContent = activeCheckbox.checked ? 'Actif' : 'Inactif';
    }

    titleInput.addEventListener('input', updatePreview);
    orderInput.addEventListener('input', updatePreview);
    activeCheckbox.addEventListener('change', updatePreview);
    updatePreview();
});
</script>
@endsection
