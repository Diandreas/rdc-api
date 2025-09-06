@extends('admin.layouts.app')

@section('title', 'Modifier la Section Biographique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier la Section Biographique</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.biographies.show', $biography) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('admin.biographies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.biographies.update', $biography) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $biography->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Titre de la section">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Extrait -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Extrait
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Court résumé de la section">{{ old('excerpt', $biography->excerpt) }}</textarea>
                        @error('excerpt')
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
                                  placeholder="Contenu de la section biographique">{{ old('content', $biography->content) }}</textarea>
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
                            <option value="early_life" {{ old('section', $biography->section) == 'early_life' ? 'selected' : '' }}>Enfance</option>
                            <option value="education" {{ old('section', $biography->section) == 'education' ? 'selected' : '' }}>Éducation</option>
                            <option value="career" {{ old('section', $biography->section) == 'career' ? 'selected' : '' }}>Carrière</option>
                            <option value="presidency" {{ old('section', $biography->section) == 'presidency' ? 'selected' : '' }}>Présidence</option>
                            <option value="achievements" {{ old('section', $biography->section) == 'achievements' ? 'selected' : '' }}>Réalisations</option>
                            <option value="personal" {{ old('section', $biography->section) == 'personal' ? 'selected' : '' }}>Vie personnelle</option>
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
                        <input type="number" id="order" name="order" value="{{ old('order', $biography->sort_order) }}" min="1"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="1">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Période -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Période</h3>
                        
                        <div>
                            <label for="period_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date de début
                            </label>
                            <input type="date" id="period_start" name="period_start" 
                                   value="{{ old('period_start', $biography->period_start ? $biography->period_start->format('Y-m-d') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('period_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="period_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date de fin
                            </label>
                            <input type="date" id="period_end" name="period_end" 
                                   value="{{ old('period_end', $biography->period_end ? $biography->period_end->format('Y-m-d') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('period_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Options</h3>
                        
                        <!-- Publié -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_published" name="is_published" value="1" 
                                   {{ old('is_published', $biography->is_published) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Publié
                            </label>
                        </div>
                    </div>

                    <!-- Informations actuelles -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Informations actuelles</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Créé le:</span>
                                <span class="text-gray-900 dark:text-white">{{ $biography->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($biography->updated_at != $biography->created_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Modifié le:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $biography->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                                <span class="text-gray-900 dark:text-white">{{ $biography->is_published ? 'Publié' : 'Brouillon' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        
                        <a href="{{ route('admin.biographies.show', $biography) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
