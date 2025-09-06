@extends('admin.layouts.app')

@section('title', 'Détails de la Section Biographique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails de la Section Biographique</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.biographies.edit', $biography) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.biographies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $biography->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $biography->created_at->format('d/m/Y H:i') }}</span>
                            <span><i class="fas fa-sort mr-1"></i>Ordre: {{ $biography->sort_order }}</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if($biography->is_published)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-check mr-1"></i>Publié
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                <i class="fas fa-clock mr-1"></i>Brouillon
                            </span>
                        @endif
                    </div>
                </div>

                @if($biography->excerpt)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Extrait</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $biography->excerpt }}</p>
                    </div>
                @endif

                @if($biography->content)
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Contenu</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($biography->content)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Période -->
            @if($biography->period_start || $biography->period_end)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Période</h3>
                    <div class="flex items-center space-x-4">
                        @if($biography->period_start)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Début</label>
                                <p class="text-gray-900 dark:text-white">{{ $biography->period_start->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($biography->period_end)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fin</label>
                                <p class="text-gray-900 dark:text-white">{{ $biography->period_end->format('d/m/Y') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Réalisations -->
            @if($biography->achievements && count($biography->achievements) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Réalisations</h3>
                    <ul class="space-y-2">
                        @foreach($biography->achievements as $achievement)
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $achievement }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Chronologie -->
            @if($biography->timeline && count($biography->timeline) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Chronologie</h3>
                    <div class="space-y-4">
                        @foreach($biography->timeline as $event)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $event['date'] ?? 'Date non spécifiée' }}</span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $event['description'] ?? $event }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Informations latérales -->
        <div class="space-y-6">
            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                        <p class="text-gray-900 dark:text-white">
                            @switch($biography->section)
                                @case('early_life')
                                    Enfance
                                    @break
                                @case('education')
                                    Éducation
                                    @break
                                @case('career')
                                    Carrière
                                    @break
                                @case('presidency')
                                    Présidence
                                    @break
                                @case('achievements')
                                    Réalisations
                                    @break
                                @case('personal')
                                    Vie personnelle
                                    @break
                                @default
                                    {{ $biography->section }}
                            @endswitch
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ordre d'affichage</label>
                        <p class="text-gray-900 dark:text-white">{{ $biography->sort_order }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        @if($biography->is_published)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-check mr-1"></i>Publié
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                <i class="fas fa-clock mr-1"></i>Brouillon
                            </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="text-gray-900 dark:text-white">{{ $biography->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($biography->updated_at != $biography->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $biography->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif

                    @if($biography->published_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publié le</label>
                            <p class="text-gray-900 dark:text-white">{{ $biography->published_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.biographies.edit', $biography) }}" 
                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    
                    <form action="{{ route('admin.biographies.destroy', $biography) }}" method="POST" class="inline w-full" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette section biographique ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.biographies.index') }}" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Aperçu public -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aperçu public</h3>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <i class="fas fa-eye mr-1"></i>Vue d'ensemble
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Titre:</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ Str::limit($biography->title, 30) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Section:</span>
                            <span class="text-gray-900 dark:text-white">
                                @switch($biography->section)
                                    @case('early_life') Enfance @break
                                    @case('education') Éducation @break
                                    @case('career') Carrière @break
                                    @case('presidency') Présidence @break
                                    @case('achievements') Réalisations @break
                                    @case('personal') Vie personnelle @break
                                    @default {{ $biography->section }}
                                @endswitch
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                            <span class="text-gray-900 dark:text-white">{{ $biography->is_published ? 'Publié' : 'Brouillon' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
