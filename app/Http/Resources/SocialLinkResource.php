<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinkResource extends JsonResource
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
            'platform' => $this->platform,
            'username' => $this->username,
            'url' => $this->url,
            'formatted_url' => $this->formatted_url,
            'icon' => $this->icon,
            'color' => $this->color,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'show_in_app' => $this->show_in_app,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
