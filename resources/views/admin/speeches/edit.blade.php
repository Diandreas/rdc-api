@extends('admin.layouts.app')

@section('title', 'Modifier le Discours')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier le Discours</h1>
        <a href="{{ route('admin.speeches.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.speeches.update', $speech) }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" id="title" name="title" value="{{ old('title', $speech->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Titre du discours">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date et Lieu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="speech_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="speech_date" name="speech_date" value="{{ old('speech_date', $speech->speech_date ? $speech->speech_date->format('Y-m-d') : '') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('speech_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lieu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="location" name="location" value="{{ old('location', $speech->location) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Lieu du discours">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="event_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type d'événement <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="event_type" name="event_type" value="{{ old('event_type', $speech->event_type) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: Investiture, Cérémonie, Conférence, etc.">
                            @error('event_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Extrait -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Extrait
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Extrait ou résumé du discours">{{ old('excerpt', $speech->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contenu
                        </label>
                        <textarea id="content" name="content" rows="12"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Contenu complet du discours">{{ old('content', $speech->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URLs audio et vidéo -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="audio_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                URL Audio
                            </label>
                            <input type="url" id="audio_url" name="audio_url" value="{{ old('audio_url', $speech->audio_url) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="https://example.com/audio.mp3">
                            @error('audio_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                URL Vidéo
                            </label>
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url', $speech->video_url) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="https://example.com/video.mp4">
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Médias -->
                    <div>
                        <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Médias (images, documents)
                        </label>
                        <input type="file" id="media" name="media[]" multiple
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                               accept="image/*,.pdf,.doc,.docx">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Formats acceptés : images (JPG, PNG, GIF), documents (PDF, DOC, DOCX)
                        </p>
                        @error('media')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Médias existants -->
                    @if($speech->hasMedia())
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Médias existants</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($speech->getMedia() as $media)
                                    <div class="relative bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                                        @if($media->mime_type && str_starts_with($media->mime_type, 'image/'))
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}" 
                                                 class="w-full h-20 object-cover rounded">
                                        @else
                                            <div class="w-full h-20 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                <i class="fas fa-file text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate mt-1">{{ $media->name }}</p>
                                        <button type="button" onclick="deleteMedia({{ $media->id }})" 
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Colonne latérale -->
                <div class="space-y-6">
                    <!-- Catégorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catégorie
                        </label>
                        <select id="category_id" name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Aucune catégorie</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id', $speech->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="space-y-3">
                        <div>
                            <label for="is_published" class="flex items-center">
                                <input type="checkbox" id="is_published" name="is_published" value="1"
                                       {{ old('is_published', $speech->is_published) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Publier le discours</span>
                            </label>
                            @error('is_published')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="is_featured" class="flex items-center">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                       {{ old('is_featured', $speech->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Mettre en avant</span>
                            </label>
                            @error('is_featured')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Informations actuelles -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Informations actuelles</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Créé le:</span>
                                <span class="text-gray-900 dark:text-white">{{ $speech->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($speech->updated_at != $speech->created_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Modifié le:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $speech->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                                <span class="text-gray-900 dark:text-white">
                                    @if($speech->is_published)
                                        <span class="text-green-600 dark:text-green-400">Publié</span>
                                    @else
                                        <span class="text-yellow-600 dark:text-yellow-400">Brouillon</span>
                                    @endif
                                </span>
                            </div>
                            @if($speech->category)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Catégorie:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $speech->category->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        
                        <a href="{{ route('admin.speeches.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-block text-center">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function deleteMedia(mediaId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce média ?')) {
        fetch(`/admin/speeches/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression du média');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la suppression du média');
        });
    }
}
</script>
@endsection
