@extends('admin.layouts.app')

@section('title', __('admin.new_video'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('admin.new_video') }}</h1>
        <a href="{{ route('admin.videos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('admin.back') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.title') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="{{ __('admin.video_title_placeholder') }}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.description') }}
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="{{ __('admin.video_description_placeholder') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vidéo - Interface avec onglets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.video_source') }} <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Onglets -->
                        <div class="border-b border-gray-200 dark:border-gray-600 mb-4">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" id="url-tab" class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400">
                                    {{ __('admin.video_url') }}
                                </button>
                                <button type="button" id="file-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                                    {{ __('admin.video_file') }}
                                </button>
                            </nav>
                        </div>

                        <!-- Contenu URL -->
                        <div id="url-content" class="tab-content">
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="{{ __('admin.video_url_placeholder') }}">
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contenu Fichier -->
                        <div id="file-content" class="tab-content hidden">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition duration-200">
                                <input type="file" id="video_file" name="video_file" accept="video/*" class="hidden">
                                <div class="space-y-2">
                                    <i class="fas fa-video text-4xl text-gray-400 dark:text-gray-500"></i>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <label for="video_file" class="cursor-pointer">
                                            <span class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">{{ __('admin.click_to_upload') }}</span>
                                            {{ __('admin.or_drag_drop') }}
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ __('admin.video_file_formats') }} ({{ __('admin.max_size') }}: 100MB)
                                    </p>
                                </div>
                            </div>
                            <div id="video-preview" class="mt-4 hidden">
                                <video controls class="w-full max-w-md mx-auto rounded-lg">
                                    <source src="" type="video/mp4">
                                    {{ __('admin.browser_not_support_video') }}
                                </video>
                            </div>
                            @error('video_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Miniature - Interface avec onglets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.thumbnail') }}
                        </label>
                        
                        <!-- Onglets -->
                        <div class="border-b border-gray-200 dark:border-gray-600 mb-4">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" id="thumb-url-tab" class="thumb-tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400">
                                    {{ __('admin.thumbnail_url') }}
                                </button>
                                <button type="button" id="thumb-file-tab" class="thumb-tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                                    {{ __('admin.thumbnail_file') }}
                                </button>
                            </nav>
                        </div>

                        <!-- Contenu URL -->
                        <div id="thumb-url-content" class="thumb-tab-content">
                            <input type="url" id="thumbnail_url" name="thumbnail_url" value="{{ old('thumbnail_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="{{ __('admin.thumbnail_url_placeholder') }}">
                            @error('thumbnail_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contenu Fichier -->
                        <div id="thumb-file-content" class="thumb-tab-content hidden">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition duration-200">
                                <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/*" class="hidden">
                                <div class="space-y-2">
                                    <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <label for="thumbnail_file" class="cursor-pointer">
                                            <span class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">{{ __('admin.click_to_upload') }}</span>
                                            {{ __('admin.or_drag_drop') }}
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ __('admin.image_file_formats') }} ({{ __('admin.max_size') }}: 10MB)
                                    </p>
                                </div>
                            </div>
                            <div id="thumbnail-preview" class="mt-4 hidden">
                                <img src="" alt="{{ __('admin.thumbnail_preview') }}" class="w-full max-w-md mx-auto rounded-lg">
                            </div>
                            @error('thumbnail_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.duration') }}
                        </label>
                        <input type="text" id="duration" name="duration" value="{{ old('duration') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="00:05:30">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Date d'enregistrement -->
                    <div>
                        <label for="recorded_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.recorded_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="recorded_date" name="recorded_date" value="{{ old('recorded_date') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('recorded_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('admin.location') }}
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="{{ __('admin.location_placeholder') }}">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.options') }}</h3>
                        
                        <!-- À la une -->
                        <div class="flex items-center">
                            <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('admin.featured') }}
                            </label>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>{{ __('admin.create_video') }}
                        </button>
                        
                        <a href="{{ route('admin.videos.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                            <i class="fas fa-times mr-2"></i>{{ __('admin.cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets vidéo
    const urlTab = document.getElementById('url-tab');
    const fileTab = document.getElementById('file-tab');
    const urlContent = document.getElementById('url-content');
    const fileContent = document.getElementById('file-content');
    const videoFile = document.getElementById('video_file');
    const videoPreview = document.getElementById('video-preview');

    // Gestion des onglets miniature
    const thumbUrlTab = document.getElementById('thumb-url-tab');
    const thumbFileTab = document.getElementById('thumb-file-tab');
    const thumbUrlContent = document.getElementById('thumb-url-content');
    const thumbFileContent = document.getElementById('thumb-file-content');
    const thumbnailFile = document.getElementById('thumbnail_file');
    const thumbnailPreview = document.getElementById('thumbnail-preview');

    // Fonction pour basculer les onglets vidéo
    function switchVideoTab(activeTab, activeContent, inactiveTab, inactiveContent) {
        activeTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        activeContent.classList.remove('hidden');
        
        inactiveTab.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        inactiveTab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        inactiveContent.classList.add('hidden');
    }

    // Fonction pour basculer les onglets miniature
    function switchThumbTab(activeTab, activeContent, inactiveTab, inactiveContent) {
        activeTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        activeContent.classList.remove('hidden');
        
        inactiveTab.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        inactiveTab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        inactiveContent.classList.add('hidden');
    }

    // Événements pour les onglets vidéo
    urlTab.addEventListener('click', () => {
        switchVideoTab(urlTab, urlContent, fileTab, fileContent);
    });

    fileTab.addEventListener('click', () => {
        switchVideoTab(fileTab, fileContent, urlTab, urlContent);
    });

    // Événements pour les onglets miniature
    thumbUrlTab.addEventListener('click', () => {
        switchThumbTab(thumbUrlTab, thumbUrlContent, thumbFileTab, thumbFileContent);
    });

    thumbFileTab.addEventListener('click', () => {
        switchThumbTab(thumbFileTab, thumbFileContent, thumbUrlTab, thumbUrlContent);
    });

    // Prévisualisation vidéo
    videoFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            const video = videoPreview.querySelector('video source');
            video.src = url;
            videoPreview.classList.remove('hidden');
        } else {
            videoPreview.classList.add('hidden');
        }
    });

    // Prévisualisation miniature
    thumbnailFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            const img = thumbnailPreview.querySelector('img');
            img.src = url;
            thumbnailPreview.classList.remove('hidden');
        } else {
            thumbnailPreview.classList.add('hidden');
        }
    });

    // Drag & Drop pour vidéo
    const videoDropZone = fileContent.querySelector('.border-dashed');
    videoDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    videoDropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    videoDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('video/')) {
            videoFile.files = files;
            videoFile.dispatchEvent(new Event('change'));
        }
    });

    // Drag & Drop pour miniature
    const thumbDropZone = thumbFileContent.querySelector('.border-dashed');
    thumbDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    thumbDropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
    });

    thumbDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            thumbnailFile.files = files;
            thumbnailFile.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection