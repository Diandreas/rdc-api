<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'context',
        'source',
        'quote_date',
        'location',
        'metadata',
        'is_featured',
        'is_published',
        'shares_count',
        'published_at'
    ];

    protected $casts = [
        'quote_date' => 'date',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'shares_count' => 'integer',
        'published_at' => 'datetime'
    ];

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

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('content', 'like', "%{$search}%")
              ->orWhere('context', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getShortContentAttribute()
    {
        return \Str::limit($this->content, 100);
    }

    public function getAuthorAttribute()
    {
        return $this->metadata['author'] ?? null;
    }

    public function getTextAttribute()
    {
        return $this->content;
    }

    public function getFeaturedAttribute()
    {
        return $this->is_featured;
    }
}
