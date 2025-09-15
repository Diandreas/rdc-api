<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Publication extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'preview_image_url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('publications')
            ->acceptsMimeTypes(['application/pdf']);
    }
}
