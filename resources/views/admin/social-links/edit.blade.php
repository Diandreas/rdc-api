@extends('admin.layouts.app')

@section('title', 'Modifier l\'Acte du Chef de l\'État')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier l'Acte du Chef de l'État</h1>
            <p class="text-gray-600 dark:text-gray-400">Modifiez les informations de l'acte</p>
        </div>
        <a href="{{ route('admin.social-links.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <!-- Formulaire -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="lg:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Titre de l'acte <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('title', $socialLink->title) }}" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                              placeholder="Description courte de l'acte"
                              required>{{ old('description', $socialLink->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="lg:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Contenu de l'acte <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="10" 
                              class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                              placeholder="Contenu complet de l'acte"
                              required>{{ old('content', $socialLink->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type d'acte -->
                <div>
                    <label for="act_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Type d'acte <span class="text-red-500">*</span>
                    </label>
                    <select name="act_type" id="act_type" 
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white" required>
                        <option value="">Sélectionnez un type d'acte</option>
                        <option value="decret" {{ old('act_type', $socialLink->act_type) == 'decret' ? 'selected' : '' }}>Décret</option>
                        <option value="arrete" {{ old('act_type', $socialLink->act_type) == 'arrete' ? 'selected' : '' }}>Arrêté</option>
                        <option value="ordonnance" {{ old('act_type', $socialLink->act_type) == 'ordonnance' ? 'selected' : '' }}>Ordonnance</option>
                        <option value="decision" {{ old('act_type', $socialLink->act_type) == 'decision' ? 'selected' : '' }}>Décision</option>
                        <option value="circulaire" {{ old('act_type', $socialLink->act_type) == 'circulaire' ? 'selected' : '' }}>Circulaire</option>
                        <option value="autre" {{ old('act_type', $socialLink->act_type) == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('act_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro de l'acte -->
                <div>
                    <label for="act_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Numéro de l'acte
                    </label>
                    <input type="text" name="act_number" id="act_number" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('act_number', $socialLink->act_number) }}" placeholder="Ex: 2024-001">
                    @error('act_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de signature -->
                <div>
                    <label for="signature_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Date de signature <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="signature_date" id="signature_date" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('signature_date', $socialLink->signature_date ? $socialLink->signature_date->format('Y-m-d') : '') }}" required>
                    @error('signature_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lieu de signature -->
                <div>
                    <label for="signature_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Lieu de signature <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="signature_location" id="signature_location" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('signature_location', $socialLink->signature_location) }}" placeholder="Ex: Palais de la Renaissance, Bangui" required>
                    @error('signature_location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL du document -->
                <div>
                    <label for="document_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        URL du document
                    </label>
                    <input type="url" name="document_url" id="document_url" 
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           value="{{ old('document_url', $socialLink->document_url) }}" placeholder="https://example.com/document.pdf">
                    @error('document_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Options -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('is_featured', $socialLink->is_featured) ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant cet acte
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Les actes mis en avant apparaîtront en premier dans l'application mobile.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.social-links.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Mettre à jour l'acte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection