<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeechResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'location' => $this->location,
            'event_type' => $this->event_type,
            'speech_date' => $this->speech_date?->format('Y-m-d'),
            'speech_time' => $this->speech_time?->format('H:i'),
            'audio_url' => $this->audio_url,
            'video_url' => $this->video_url,
            'youtube_id' => $this->youtube_id,
            'duration' => $this->duration,
            'formatted_duration' => $this->formatted_duration,
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'views_count' => $this->views_count,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            
            // Médias
            'thumbnail' => $this->getFirstMediaUrl('thumbnails'),
            'thumbnail_thumb' => $this->getFirstMediaUrl('thumbnails', 'thumb'),
            'documents' => $this->getMedia('documents')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->name,
                    'url' => $media->getUrl(),
                    'mime_type' => $media->mime_type,
                    'size' => $media->human_readable_size
                ];
            })
        ];
    }
}
