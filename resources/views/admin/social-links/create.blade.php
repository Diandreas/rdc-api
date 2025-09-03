@extends('admin.layouts.app')

@section('title', 'Nouveau Réseau Social')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nouveau Réseau Social</h1>
        <a href="{{ route('admin.social-links.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.social-links.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Colonne principale -->
                <div class="space-y-6">
                    <!-- Plateforme -->
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Plateforme <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="platform" name="platform" value="{{ old('platform') }}" required
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
                        <input type="url" id="url" name="url" value="{{ old('url') }}" required
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
                        <select id="icon" name="icon" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionner une icône</option>
                            <option value="fab fa-facebook" {{ old('icon') == 'fab fa-facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="fab fa-twitter" {{ old('icon') == 'fab fa-twitter' ? 'selected' : '' }}>Twitter</option>
                            <option value="fab fa-instagram" {{ old('icon') == 'fab fa-instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="fab fa-youtube" {{ old('icon') == 'fab fa-youtube' ? 'selected' : '' }}>YouTube</option>
                            <option value="fab fa-linkedin" {{ old('icon') == 'fab fa-linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="fab fa-tiktok" {{ old('icon') == 'fab fa-tiktok' ? 'selected' : '' }}>TikTok</option>
                            <option value="fab fa-telegram" {{ old('icon') == 'fab fa-telegram' ? 'selected' : '' }}>Telegram</option>
                            <option value="fab fa-whatsapp" {{ old('icon') == 'fab fa-whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="fas fa-globe" {{ old('icon') == 'fas fa-globe' ? 'selected' : '' }}>Site Web</option>
                        </select>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Aperçu de l'icône -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Aperçu de l'icône</h4>
                        <div class="flex items-center space-x-3">
                            <i id="icon-preview" class="text-3xl text-gray-400"></i>
                            <span id="icon-name" class="text-sm text-gray-600 dark:text-gray-400">Aucune icône sélectionnée</span>
                        </div>
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

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Créer le réseau social
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
    const iconSelect = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    const iconName = document.getElementById('icon-name');

    const iconNames = {
        'fab fa-facebook': 'Facebook',
        'fab fa-twitter': 'Twitter',
        'fab fa-instagram': 'Instagram',
        'fab fa-youtube': 'YouTube',
        'fab fa-linkedin': 'LinkedIn',
        'fab fa-tiktok': 'TikTok',
        'fab fa-telegram': 'Telegram',
        'fab fa-whatsapp': 'WhatsApp',
        'fas fa-globe': 'Site Web'
    };

    function updateIconPreview() {
        const selectedIcon = iconSelect.value;
        if (selectedIcon) {
            iconPreview.className = selectedIcon + ' text-3xl text-blue-600';
            iconName.textContent = iconNames[selectedIcon] || selectedIcon;
        } else {
            iconPreview.className = 'text-3xl text-gray-400';
            iconName.textContent = 'Aucune icône sélectionnée';
        }
    }

    iconSelect.addEventListener('change', updateIconPreview);
    updateIconPreview();
});
</script>
@endsection
