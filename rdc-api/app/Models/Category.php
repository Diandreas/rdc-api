<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'type',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relations
    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType(Builder $query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
