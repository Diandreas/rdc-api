@extends('admin.layouts.app')

@section('title', 'Détail de la Citation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détail de la Citation</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.quotes.edit', $quote) }}" class="bg-[#003DA5] hover:bg-[#002D7A] text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Citation principale -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-6">
            <div class="text-center">
                @if($quote->featured)
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 mb-4">
                        <i class="fas fa-star mr-1"></i>Citation mise en avant
                    </div>
                @endif
                
                <blockquote class="text-2xl font-medium text-gray-900 dark:text-white mb-6 leading-relaxed">
                    "{{ $quote->content }}"
                </blockquote>
                
                <div class="text-lg text-gray-600 dark:text-gray-400">
                    — {{ $quote->metadata['author'] ?? 'Auteur non spécifié' }}
                </div>
            </div>
        </div>

        <!-- Informations détaillées -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informations générales -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-[#003DA5]"></i>Informations générales
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auteur</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->metadata['author'] ?? 'Auteur non spécifié' }}</p>
                    </div>
                    
                    @if($quote->context)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contexte</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->context }}</p>
                    </div>
                    @endif
                    
                    @if($quote->quote_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->quote_date->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    
                    @if($quote->location)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Localisation</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->location }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-cog mr-2 text-[#003DA5]"></i>Métadonnées
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <p class="mt-1">
                            @if($quote->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <i class="fas fa-star mr-1"></i>Mise en avant
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    <i class="fas fa-quote-left mr-1"></i>Normal
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $quote->id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé le</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modifié le</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quote->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-tools mr-2 text-[#003DA5]"></i>Actions
            </h3>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.quotes.edit', $quote) }}" class="bg-[#003DA5] hover:bg-[#002D7A] text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                
                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette citation ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
                
                <a href="{{ route('admin.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-list mr-2"></i>Voir toutes les citations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
