@extends('admin.layouts.app')

@section('title', 'Modifier l\'Acte du Chef de l\'État')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier l'Acte du Chef de l'État</h1>
        <a href="{{ route('admin.social-links.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Colonne principale -->
                <div class="space-y-6">
                    <!-- Plateforme -->
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Plateforme <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="platform" name="platform" value="{{ old('platform', $socialLink->platform) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Facebook, Twitter, Instagram, etc.">
                        @error('platform')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL <span class="text-red-500">*</span>
                        </label>
                        <input type="url" id="url" name="url" value="{{ old('url', $socialLink->url) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://facebook.com/username">
                        @error('url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icône -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Icône <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $socialLink->icon) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="fab fa-facebook">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Utilisez les classes Font Awesome (ex: fab fa-facebook, fab fa-twitter)
                        </p>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Couleur -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Couleur
                        </label>
                        <input type="color" id="color" name="color" value="{{ old('color', $socialLink->color ?? '#3B82F6') }}"
                               class="w-full h-10 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Description de l'acte...">{{ old('description', $socialLink->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Statut
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $socialLink->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Actif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="show_in_app" value="1" {{ old('show_in_app', $socialLink->show_in_app) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Afficher dans l'application</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ordre de tri -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ordre de tri
                        </label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $socialLink->sort_order ?? 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="0">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Plus le nombre est petit, plus l'acte apparaîtra en haut
                        </p>
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Aperçu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Aperçu
                        </label>
                        <div class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center space-x-3">
                                <div id="preview-icon" class="text-2xl" style="color: {{ old('color', $socialLink->color ?? '#3B82F6') }}">
                                    <i class="{{ old('icon', $socialLink->icon) }}"></i>
                                </div>
                                <div>
                                    <div id="preview-platform" class="font-medium text-gray-900 dark:text-white">
                                        {{ old('platform', $socialLink->platform) }}
                                    </div>
                                    <div id="preview-url" class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ old('url', $socialLink->url) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Mettre à jour l'acte
                        </button>
                        
                        <a href="{{ route('admin.social-links.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
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
    const platformInput = document.getElementById('platform');
    const iconInput = document.getElementById('icon');
    const colorInput = document.getElementById('color');
    const urlInput = document.getElementById('url');
    
    const previewPlatform = document.getElementById('preview-platform');
    const previewIcon = document.getElementById('preview-icon');
    const previewUrl = document.getElementById('preview-url');

    function updatePreview() {
        previewPlatform.textContent = platformInput.value || 'Plateforme';
        previewIcon.innerHTML = `<i class="${iconInput.value || 'fas fa-link'}"></i>`;
        previewIcon.style.color = colorInput.value;
        previewUrl.textContent = urlInput.value || 'URL';
    }

    // Mettre à jour l'aperçu en temps réel
    platformInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);
    urlInput.addEventListener('input', updatePreview);

    // Initialiser l'aperçu
    updatePreview();
});
</script>
@endsection
