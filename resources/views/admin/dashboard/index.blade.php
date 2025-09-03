@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
            <p class="text-gray-600 dark:text-gray-400">Bienvenue dans l'espace d'administration de l'application présidentielle</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">Dernière connexion</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-microphone text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Discours</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['speeches'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.speeches.index') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                        Voir tous les discours
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Actualités</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['news'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.news.index') }}" class="font-medium text-green-600 dark:text-green-400 hover:text-green-500">
                        Voir toutes les actualités
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-quote-right text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Citations</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['quotes'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.quotes.index') }}" class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500">
                        Voir toutes les citations
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Messages non lus</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['unread_messages'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.contact-messages.index') }}" class="font-medium text-red-600 dark:text-red-400 hover:text-red-500">
                        Voir tous les messages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu récent -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Messages récents -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Messages récents</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentMessages as $message)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $message->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    {{ $message->subject }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if(!$message->is_read)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Nouveau
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-2xl mb-2"></i>
                        <p>Aucun message récent</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                    Voir tous les messages
                </a>
            </div>
        </div>

        <!-- Discours récents -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Discours récents</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentSpeeches as $speech)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $speech->title }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    {{ $speech->location }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $speech->speech_date->format('d/m/Y') }}
                                    @if($speech->category)
                                        • {{ $speech->category->name }}
                                    @endif
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if($speech->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Mis en avant
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-microphone text-2xl mb-2"></i>
                        <p>Aucun discours récent</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.speeches.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                    Voir tous les discours
                </a>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Actions rapides</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.speeches.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                    <i class="fas fa-plus text-blue-600 dark:text-blue-400 mr-3"></i>
                    <span class="text-sm font-medium text-blue-900 dark:text-blue-100">Nouveau discours</span>
                </a>
                
                <a href="{{ route('admin.news.create') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                    <i class="fas fa-plus text-green-600 dark:text-green-400 mr-3"></i>
                    <span class="text-sm font-medium text-green-900 dark:text-green-100">Nouvelle actualité</span>
                </a>
                
                <a href="{{ route('admin.quotes.create') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors">
                    <i class="fas fa-plus text-purple-600 dark:text-purple-400 mr-3"></i>
                    <span class="text-sm font-medium text-purple-900 dark:text-purple-100">Nouvelle citation</span>
                </a>
                
                <a href="{{ route('admin.photos.create') }}" class="flex items-center p-4 bg-orange-50 dark:bg-orange-900 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-800 transition-colors">
                    <i class="fas fa-plus text-orange-600 dark:text-orange-400 mr-3"></i>
                    <span class="text-sm font-medium text-orange-900 dark:text-orange-100">Nouvelle photo</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
