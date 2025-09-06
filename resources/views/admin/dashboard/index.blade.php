@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.dashboard') }}</h1>
            <p class="text-gray-600 dark:text-gray-400">{{ __('admin.welcome') }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">Dernière connexion</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.speeches') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['speeches'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.speeches.index') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                        {{ __('admin.view_all_speeches') }}
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.news') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['news'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.news.index') }}" class="font-medium text-green-600 dark:text-green-400 hover:text-green-500">
                        {{ __('admin.view_all_news') }}
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.quotes') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['quotes'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.quotes.index') }}" class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500">
                        {{ __('admin.view_all_quotes') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-camera text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.photos') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['photos'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.photos.index') }}" class="font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500">
                        {{ __('admin.view_all_photos') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-video text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.videos') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['videos'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.videos.index') }}" class="font-medium text-red-600 dark:text-red-400 hover:text-red-500">
                        {{ __('admin.view_all_videos') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-tags text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('admin.categories') }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['categories'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.categories.index') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                        {{ __('admin.view_all_categories') }}
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Contenu récent -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Discours récents -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.recent_speeches') }}</h3>
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
                                        {{ __('admin.featured') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-microphone text-2xl mb-2"></i>
                        <p>{{ __('admin.no_recent_speeches') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.speeches.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                    {{ __('admin.view_all_speeches') }}
                </a>
            </div>
        </div>

        <!-- Actualités récentes -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.recent_news') }}</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentNews as $news)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $news->title }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    {{ Str::limit($news->excerpt, 60) }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $news->published_at ? $news->published_at->format('d/m/Y') : $news->created_at->format('d/m/Y') }}
                                    @if($news->category)
                                        • {{ $news->category->name }}
                                    @endif
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if($news->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        {{ __('admin.featured') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-newspaper text-2xl mb-2"></i>
                        <p>{{ __('admin.no_recent_news') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500">
                    {{ __('admin.view_all_news') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.quick_actions') }}</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <a href="{{ route('admin.speeches.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                    <i class="fas fa-plus text-blue-600 dark:text-blue-400 mr-3"></i>
                    <span class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ __('admin.new_speech') }}</span>
                </a>
                
                <a href="{{ route('admin.news.create') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                    <i class="fas fa-plus text-green-600 dark:text-green-400 mr-3"></i>
                    <span class="text-sm font-medium text-green-900 dark:text-green-100">{{ __('admin.new_news') }}</span>
                </a>
                
                <a href="{{ route('admin.quotes.create') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors">
                    <i class="fas fa-plus text-purple-600 dark:text-purple-400 mr-3"></i>
                    <span class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ __('admin.new_quote') }}</span>
                </a>
                
                <a href="{{ route('admin.photos.create') }}" class="flex items-center p-4 bg-orange-50 dark:bg-orange-900 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-800 transition-colors">
                    <i class="fas fa-plus text-orange-600 dark:text-orange-400 mr-3"></i>
                    <span class="text-sm font-medium text-orange-900 dark:text-orange-100">{{ __('admin.new_photo') }}</span>
                </a>
                
                <a href="{{ route('admin.videos.create') }}" class="flex items-center p-4 bg-red-50 dark:bg-red-900 rounded-lg hover:bg-red-100 dark:hover:bg-red-800 transition-colors">
                    <i class="fas fa-plus text-red-600 dark:text-red-400 mr-3"></i>
                    <span class="text-sm font-medium text-red-900 dark:text-red-100">{{ __('admin.new_video') }}</span>
                </a>
                
                <a href="{{ route('admin.biographies.create') }}" class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-plus text-indigo-600 dark:text-indigo-400 mr-3"></i>
                    <span class="text-sm font-medium text-indigo-900 dark:text-indigo-100">{{ __('admin.new_biography') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
