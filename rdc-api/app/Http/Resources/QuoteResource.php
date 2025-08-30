<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
            'content' => $this->content,
            'short_content' => $this->short_content,
            'context' => $this->context,
            'source' => $this->source,
            'quote_date' => $this->quote_date?->format('Y-m-d'),
            'location' => $this->location,
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}