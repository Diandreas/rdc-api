<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'source' => $this->source,
            'author' => $this->author,
            'type' => $this->type,
            'priority' => $this->priority,
            'send_notification' => $this->send_notification,
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
            'featured_image' => $this->getFirstMediaUrl('featured_images'),
            'featured_image_thumb' => $this->getFirstMediaUrl('featured_images', 'thumb'),
            'featured_image_medium' => $this->getFirstMediaUrl('featured_images', 'medium'),
            'attachments' => $this->getMedia('attachments')->map(function ($media) {
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