<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Biography extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'section',
        'period_start',
        'period_end',
        'timeline',
        'achievements',
        'sort_order',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'timeline' => 'array',
        'achievements' => 'array',
        'sort_order' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(400);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(800);
    }

    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeBySection(Builder $query, string $section)
    {
        return $query->where('section', $section);
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order')->orderBy('period_start');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }
}
