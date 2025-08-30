<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Video extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'video_url',
        'youtube_id',
        'thumbnail_url',
        'duration',
        'quality',
        'location',
        'event_type',
        'recorded_date',
        'metadata',
        'is_featured',
        'is_published',
        'views_count',
        'shares_count',
        'published_at'
    ];

    protected $casts = [
        'recorded_date' => 'date',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'views_count' => 'integer',
        'shares_count' => 'integer',
        'published_at' => 'datetime'
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(320)
            ->height(180);

        $this->addMediaConversion('preview')
            ->width(1280)
            ->height(720);
    }

    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByQuality(Builder $query, string $quality)
    {
        return $query->where('quality', $quality);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return null;
        
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getYoutubeThumbnailAttribute()
    {
        if (!$this->youtube_id) return $this->thumbnail_url;
        
        return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
    }
}
