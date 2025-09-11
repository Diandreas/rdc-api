<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'source',
        'author',
        'type',
        'priority',
        'send_notification',
        'metadata',
        'is_featured',
        'is_published',
        'views_count',
        'shares_count',
        'published_at',
        'image_url',
        'video_url',
        'location'
    ];

    protected $casts = [
        'metadata' => 'array',
        'send_notification' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'views_count' => 'integer',
        'shares_count' => 'integer',
        'published_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['featured_image_url'];

    // Accessor for the featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        return $this->image_url;
    }

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
        $this->addMediaCollection('featured_images')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('attachments')
            ->acceptsMimeTypes(['application/pdf', 'application/msword']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(300);

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600);
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

    public function scopeByType(Builder $query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority(Builder $query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUrgent(Builder $query)
    {
        return $query->where('priority', 'urgent');
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
