<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use App\Http\Requests\StoreSpeechRequest;
use App\Http\Requests\UpdateSpeechRequest;
use App\Http\Resources\SpeechResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Services\FcmService;

class SpeechController extends Controller
{
    /**
     * Liste des discours pour l'admin
     */
    public function index(Request $request): JsonResponse
    {
        $query = Speech::with(['category', 'tags']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title');
                break;
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'views':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }

        $speeches = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => SpeechResource::collection($speeches),
            'meta' => [
                'total' => $speeches->total(),
                'per_page' => $speeches->perPage(),
                'current_page' => $speeches->currentPage(),
                'last_page' => $speeches->lastPage()
            ]
        ]);
    }

    /**
     * Créer un nouveau discours
     */
    public function store(StoreSpeechRequest $request): JsonResponse
    {
        $speech = Speech::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'event_type' => $request->event_type,
            'speech_date' => $request->speech_date,
            'speech_time' => $request->speech_time,
            'audio_url' => $request->audio_url,
            'video_url' => $request->video_url,
            'youtube_id' => $request->youtube_id,
            'duration' => $request->duration,
            'metadata' => $request->metadata ?? [],
            'is_featured' => $request->is_featured ?? false,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->is_published ? now() : null,
        ]);

        // Associer les tags
        if ($request->has('tags')) {
            $speech->tags()->sync($request->tags);
        }

        $speech->load(['category', 'tags']);

        if ($speech->is_published) {
            app(FcmService::class)->sendToTopic(
                'speeches',
                'Nouveau discours',
                Str::limit($speech->title, 120),
                ['type' => 'speech', 'id' => $speech->id]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Discours créé avec succès',
            'data' => new SpeechResource($speech)
        ], 201);
    }

    /**
     * Afficher un discours
     */
    public function show(Speech $speech): JsonResponse
    {
        $speech->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Mettre à jour un discours
     */
    public function update(UpdateSpeechRequest $request, Speech $speech): JsonResponse
    {
        $speech->update([
            'title' => $request->title,
            'slug' => $request->has('title') ? Str::slug($request->title) : $speech->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'event_type' => $request->event_type,
            'speech_date' => $request->speech_date,
            'speech_time' => $request->speech_time,
            'audio_url' => $request->audio_url,
            'video_url' => $request->video_url,
            'youtube_id' => $request->youtube_id,
            'duration' => $request->duration,
            'metadata' => $request->metadata ?? $speech->metadata,
            'is_featured' => $request->is_featured ?? $speech->is_featured,
            'is_published' => $request->is_published ?? $speech->is_published,
            'published_at' => $request->is_published && !$speech->published_at ? now() : $speech->published_at,
        ]);

        // Mettre à jour les tags
        if ($request->has('tags')) {
            $speech->tags()->sync($request->tags);
        }

        $speech->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Discours mis à jour avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Supprimer un discours
     */
    public function destroy(Speech $speech): JsonResponse
    {
        $speech->tags()->detach();
        $speech->clearMediaCollection();
        $speech->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discours supprimé avec succès'
        ]);
    }

    /**
     * Publier un discours
     */
    public function publish(Speech $speech): JsonResponse
    {
        $speech->update([
            'is_published' => true,
            'published_at' => now()
        ]);

        app(FcmService::class)->sendToTopic(
            'speeches',
            'Nouveau discours',
            Str::limit($speech->title, 120),
            ['type' => 'speech', 'id' => $speech->id]
        );

        return response()->json([
            'success' => true,
            'message' => 'Discours publié avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Dépublier un discours
     */
    public function unpublish(Speech $speech): JsonResponse
    {
        $speech->update([
            'is_published' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discours dépublié avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }
}
