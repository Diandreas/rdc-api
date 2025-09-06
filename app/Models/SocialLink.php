<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'act_type',
        'act_number',
        'signature_date',
        'signature_location',
        'document_url',
        'is_featured',
        'is_active',
        'show_in_app',
        'sort_order'
    ];

    protected $casts = [
        'signature_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'show_in_app' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible(Builder $query)
    {
        return $query->where('show_in_app', true);
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order')->orderBy('platform');
    }

    public function scopeByPlatform(Builder $query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    // Accessors
    public function getFormattedUrlAttribute()
    {
        // S'assurer que l'URL commence par http/https
        if (!preg_match('/^https?:\/\//', $this->url)) {
            return 'https://' . $this->url;
        }
        return $this->url;
    }
}
