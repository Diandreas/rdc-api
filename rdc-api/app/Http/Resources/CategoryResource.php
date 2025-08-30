<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'color' => $this->color,
            'icon' => $this->icon,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Compteurs (si demandé)
            $this->mergeWhen($request->has('with_counts'), function () {
                return [
                    'speeches_count' => $this->speeches()->published()->count(),
                    'videos_count' => $this->videos()->published()->count(),
                    'news_count' => $this->news()->published()->count(),
                    'photos_count' => $this->photos()->published()->count(),
                ];
            })
        ];
    }
}