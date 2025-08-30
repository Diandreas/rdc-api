# API Laravel - Application Mobile FAT

## Commandes de création des fichiers

### 1. Installation et configuration initiale

```bash
# Créer le projet Laravel
composer create-project laravel/laravel fat-api

# Aller dans le dossier
cd fat-api

# Installer les packages nécessaires
composer require laravel/sanctum
composer require spatie/laravel-permission
composer require spatie/laravel-media-library
composer require intervention/image
composer require pusher/pusher-php-server
composer require onesignal/onesignal-php-api

# Publier les configurations
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"

# Créer les migrations
php artisan make:migration create_categories_table
php artisan make:migration create_tags_table
php artisan make:migration create_speeches_table
php artisan make:migration create_videos_table
php artisan make:migration create_news_table
php artisan make:migration create_photos_table
php artisan make:migration create_biographies_table
php artisan make:migration create_quotes_table
php artisan make:migration create_contact_messages_table
php artisan make:migration create_social_links_table
php artisan make:migration create_taggables_table

# Créer les modèles
php artisan make:model Category
php artisan make:model Tag
php artisan make:model Speech
php artisan make:model Video
php artisan make:model News
php artisan make:model Photo
php artisan make:model Biography
php artisan make:model Quote
php artisan make:model ContactMessage
php artisan make:model SocialLink

# Créer les contrôleurs
php artisan make:controller API/AuthController
php artisan make:controller API/Admin/SpeechController --resource
php artisan make:controller API/Admin/VideoController --resource
php artisan make:controller API/Admin/NewsController --resource
php artisan make:controller API/Admin/PhotoController --resource
php artisan make:controller API/Admin/BiographyController --resource
php artisan make:controller API/Admin/QuoteController --resource
php artisan make:controller API/Admin/ContactMessageController --resource
php artisan make:controller API/Admin/SocialLinkController --resource
php artisan make:controller API/Admin/CategoryController --resource
php artisan make:controller API/Admin/TagController --resource

# Contrôleurs publics pour l'app mobile
php artisan make:controller API/Public/ContentController
php artisan make:controller API/Public/ContactController

# Créer les Resources
php artisan make:resource SpeechResource
php artisan make:resource VideoResource
php artisan make:resource NewsResource
php artisan make:resource PhotoResource
php artisan make:resource BiographyResource
php artisan make:resource QuoteResource
php artisan make:resource CategoryResource
php artisan make:resource TagResource
php artisan make:resource ContactMessageResource
php artisan make:resource SocialLinkResource

# Créer les Form Requests
php artisan make:request StoreSpeechRequest
php artisan make:request UpdateSpeechRequest
php artisan make:request StoreVideoRequest
php artisan make:request UpdateVideoRequest
php artisan make:request StoreNewsRequest
php artisan make:request UpdateNewsRequest
php artisan make:request StorePhotoRequest
php artisan make:request UpdatePhotoRequest
php artisan make:request StoreBiographyRequest
php artisan make:request UpdateBiographyRequest
php artisan make:request StoreQuoteRequest
php artisan make:request UpdateQuoteRequest
php artisan make:request StoreContactMessageRequest
php artisan make:request StoreSocialLinkRequest
php artisan make:request UpdateSocialLinkRequest

# Créer les seeders
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
php artisan make:seeder SocialLinkSeeder
```

## Migrations

### 1. Categories Migration

```php
<?php
// database/migrations/create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#3B82F6');
            $table->string('icon')->nullable();
            $table->enum('type', ['speech', 'video', 'news', 'photo'])->default('speech');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
```

### 2. Tags Migration

```php
<?php
// database/migrations/create_tags_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#10B981');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
```

### 3. Speeches Migration

```php
<?php
// database/migrations/create_speeches_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('speeches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('location')->nullable();
            $table->string('event_type')->nullable();
            $table->date('speech_date');
            $table->time('speech_time')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('youtube_id')->nullable();
            $table->integer('duration')->nullable(); // en secondes
            $table->json('metadata')->nullable(); // données additionnelles
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index(['category_id', 'is_published']);
            $table->fullText(['title', 'content', 'excerpt']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('speeches');
    }
};
```

### 4. Videos Migration

```php
<?php
// database/migrations/create_videos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('video_url');
            $table->string('youtube_id')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration')->nullable(); // en secondes
            $table->string('quality')->default('HD'); // SD, HD, 4K
            $table->string('location')->nullable();
            $table->string('event_type')->nullable();
            $table->date('recorded_date');
            $table->json('metadata')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index(['category_id', 'is_published']);
            $table->fullText(['title', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
```

### 5. News Migration

```php
<?php
// database/migrations/create_news_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->enum('type', ['communique', 'news', 'announcement', 'press_release'])->default('news');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('send_notification')->default(false);
            $table->json('metadata')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index(['type', 'is_published']);
            $table->index(['priority', 'is_published']);
            $table->fullText(['title', 'content', 'excerpt']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
```

### 6. Photos Migration

```php
<?php
// database/migrations/create_photos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('photographer')->nullable();
            $table->string('location')->nullable();
            $table->string('event_type')->nullable();
            $table->date('photo_date');
            $table->json('metadata')->nullable(); // EXIF data, etc.
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index(['category_id', 'is_published']);
            $table->fullText(['title', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('photos');
    }
};
```

### 7. Biographies Migration

```php
<?php
// database/migrations/create_biographies_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biographies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->enum('section', ['early_life', 'education', 'career', 'presidency', 'achievements', 'personal']);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->json('timeline')->nullable(); // événements chronologiques
            $table->json('achievements')->nullable(); // réalisations
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
            $table->fullText(['title', 'content', 'excerpt']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('biographies');
    }
};
```

### 8. Quotes Migration

```php
<?php
// database/migrations/create_quotes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('context')->nullable(); // contexte de la citation
            $table->string('source')->nullable(); // discours, interview, etc.
            $table->date('quote_date')->nullable();
            $table->string('location')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('shares_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'is_featured']);
            $table->fullText(['content', 'context']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
```

### 9. Contact Messages Migration

```php
<?php
// database/migrations/create_contact_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('city')->nullable();
            $table->string('country')->default('République Centrafricaine');
            $table->enum('status', ['pending', 'read', 'replied', 'archived'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->text('admin_notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->json('metadata')->nullable(); // IP, user agent, etc.
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['priority', 'status']);
            $table->fullText(['name', 'subject', 'message']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_messages');
    }
};
```

### 10. Social Links Migration

```php
<?php
// database/migrations/create_social_links_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // facebook, twitter, youtube, instagram
            $table->string('username');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->string('color', 7)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_app')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['platform', 'username']);
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_links');
    }
};
```

### 11. Taggables Migration (Table pivot pour les tags)

```php
<?php
// database/migrations/create_taggables_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->timestamps();

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->index(['taggable_type', 'taggable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggables');
    }
};
```

## Modèles

### 1. Category Model

```php
<?php
// app/Models/Category.php
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
```

### 2. Tag Model

```php
<?php
// app/Models/Tag.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relations polymorphes
    public function speeches()
    {
        return $this->morphedByMany(Speech::class, 'taggable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'taggable');
    }

    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'taggable');
    }

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
```

### 3. Speech Model

```php
<?php
// app/Models/Speech.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Speech extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'location',
        'event_type',
        'speech_date',
        'speech_time',
        'audio_url',
        'video_url',
        'youtube_id',
        'duration',
        'metadata',
        'is_featured',
        'is_published',
        'views_count',
        'shares_count',
        'published_at'
    ];

    protected $casts = [
        'speech_date' => 'date',
        'speech_time' => 'datetime:H:i',
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

        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'application/msword']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('preview')
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

    public function scopeByYear(Builder $query, int $year)
    {
        return $query->whereYear('speech_date', $year);
    }

    public function scopeByLocation(Builder $query, string $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->whereFullText(['title', 'content', 'excerpt'], $search);
    }

    // Accessors
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return null;
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
```

### 4. Video Model

```php
<?php
// app/Models/Video.php
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
        return $query->whereFullText(['title', 'description'], $search);
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
```

### 5. News Model

```php
<?php
// app/Models/News.php
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
        'published_at'
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
        return $query->whereFullText(['title', 'content', 'excerpt'], $search);
    }
}
```

### 6. Photo Model

```php
<?php
// app/Models/Photo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Photo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'photographer',
        'location',
        'event_type',
        'photo_date',
        'metadata',
        'is_featured',
        'is_published',
        'views_count',
        'shares_count',
        'published_at'
    ];

    protected $casts = [
        'photo_date' => 'date',
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
        $this->addMediaCollection('images')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(1920)
            ->height(1440)
            ->nonQueued();
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

    public function scopeByYear(Builder $query, int $year)
    {
        return $query->whereYear('photo_date', $year);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->whereFullText(['title', 'description'], $search);
    }
}
```

### 7. Biography Model

```php
<?php
// app/Models/Biography.php
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
        return $query->whereFullText(['title', 'content', 'excerpt'], $search);
    }
}
```

### 8. Quote Model

```php
<?php
// app/Models/Quote.php
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
        return $query->whereFullText(['content', 'context'], $search);
    }

    // Accessors
    public function getShortContentAttribute()
    {
        return \Str::limit($this->content, 100);
    }
}
```

### 9. ContactMessage Model

```php
<?php
// app/Models/ContactMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'city',
        'country',
        'status',
        'priority',
        'admin_notes',
        'read_at',
        'replied_at',
        'metadata'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'metadata' => 'array'
    ];

    // Scopes
    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnread(Builder $query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeByStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority(Builder $query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->whereFullText(['name', 'subject', 'message'], $search);
    }

    // Mutateurs
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }
}
```

### 10. SocialLink Model

```php
<?php
// app/Models/SocialLink.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'username',
        'url',
        'icon',
        'color',
        'description',
        'is_active',
        'show_in_app',
        'sort_order'
    ];

    protected $casts = [
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
```

## Routes API

```php
<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Public\ContentController;
use App\Http\Controllers\API\Public\ContactController;

// Routes publiques pour l'app mobile
Route::prefix('v1')->group(function () {
    
    // Authentification
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);
    
    // Routes publiques
    Route::get('app/home', [ContentController::class, 'home']);
    Route::get('app/welcome', [ContentController::class, 'welcome']);
    
    // Discours
    Route::get('speeches', [ContentController::class, 'speeches']);
    Route::get('speeches/{speech:slug}', [ContentController::class, 'showSpeech']);
    Route::post('speeches/{speech}/view', [ContentController::class, 'incrementSpeechView']);
    Route::post('speeches/{speech}/share', [ContentController::class, 'incrementSpeechShare']);
    
    // Vidéos
    Route::get('videos', [ContentController::class, 'videos']);
    Route::get('videos/{video:slug}', [ContentController::class, 'showVideo']);
    Route::post('videos/{video}/view', [ContentController::class, 'incrementVideoView']);
    Route::post('videos/{video}/share', [ContentController::class, 'incrementVideoShare']);
    
    // Actualités
    Route::get('news', [ContentController::class, 'news']);
    Route::get('news/{news:slug}', [ContentController::class, 'showNews']);
    Route::post('news/{news}/view', [ContentController::class, 'incrementNewsView']);
    Route::post('news/{news}/share', [ContentController::class, 'incrementNewsShare']);
    
    // Galerie photos
    Route::get('photos', [ContentController::class, 'photos']);
    Route::get('photos/{photo:slug}', [ContentController::class, 'showPhoto']);
    Route::post('photos/{photo}/view', [ContentController::class, 'incrementPhotoView']);
    Route::post('photos/{photo}/share', [ContentController::class, 'incrementPhotoShare']);
    
    // Biographie
    Route::get('biography', [ContentController::class, 'biography']);
    Route::get('biography/{biography:slug}', [ContentController::class, 'showBiography']);
    
    // Citations
    Route::get('quotes', [ContentController::class, 'quotes']);
    Route::get('quotes/random', [ContentController::class, 'randomQuote']);
    Route::post('quotes/{quote}/share', [ContentController::class, 'incrementQuoteShare']);
    
    // Réseaux sociaux
    Route::get('social-links', [ContentController::class, 'socialLinks']);
    
    // Contact
    Route::post('contact', [ContactController::class, 'store']);
    
    // Catégories et tags
    Route::get('categories', [ContentController::class, 'categories']);
    Route::get('tags', [ContentController::class, 'tags']);
    
    // Recherche globale
    Route::get('search', [ContentController::class, 'search']);
    
    // Configuration de l'app
    Route::get('app/config', [ContentController::class, 'appConfig']);
});

// Routes protégées pour l'interface d'administration
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    
    // Authentification admin
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    
    // Dashboard
    Route::get('dashboard/stats', [ContentController::class, 'dashboardStats']);
    
    // Gestion des discours
    Route::apiResource('speeches', App\Http\Controllers\API\Admin\SpeechController::class);
    Route::post('speeches/{speech}/publish', [App\Http\Controllers\API\Admin\SpeechController::class, 'publish']);
    Route::post('speeches/{speech}/unpublish', [App\Http\Controllers\API\Admin\SpeechController::class, 'unpublish']);
    Route::post('speeches/{speech}/feature', [App\Http\Controllers\API\Admin\SpeechController::class, 'feature']);
    Route::post('speeches/{speech}/media', [App\Http\Controllers\API\Admin\SpeechController::class, 'uploadMedia']);
    
    // Gestion des vidéos
    Route::apiResource('videos', App\Http\Controllers\API\Admin\VideoController::class);
    Route::post('videos/{video}/publish', [App\Http\Controllers\API\Admin\VideoController::class, 'publish']);
    Route::post('videos/{video}/unpublish', [App\Http\Controllers\API\Admin\VideoController::class, 'unpublish']);
    Route::post('videos/{video}/feature', [App\Http\Controllers\API\Admin\VideoController::class, 'feature']);
    Route::post('videos/{video}/media', [App\Http\Controllers\API\Admin\VideoController::class, 'uploadMedia']);
    
    // Gestion des actualités
    Route::apiResource('news', App\Http\Controllers\API\Admin\NewsController::class);
    Route::post('news/{news}/publish', [App\Http\Controllers\API\Admin\NewsController::class, 'publish']);
    Route::post('news/{news}/unpublish', [App\Http\Controllers\API\Admin\NewsController::class, 'unpublish']);
    Route::post('news/{news}/feature', [App\Http\Controllers\API\Admin\NewsController::class, 'feature']);
    Route::post('news/{news}/media', [App\Http\Controllers\API\Admin\NewsController::class, 'uploadMedia']);
    
    // Gestion des photos
    Route::apiResource('photos', App\Http\Controllers\API\Admin\PhotoController::class);
    Route::post('photos/{photo}/publish', [App\Http\Controllers\API\Admin\PhotoController::class, 'publish']);
    Route::post('photos/{photo}/unpublish', [App\Http\Controllers\API\Admin\PhotoController::class, 'unpublish']);
    Route::post('photos/{photo}/feature', [App\Http\Controllers\API\Admin\PhotoController::class, 'feature']);
    Route::post('photos/{photo}/media', [App\Http\Controllers\API\Admin\PhotoController::class, 'uploadMedia']);
    
    // Gestion de la biographie
    Route::apiResource('biographies', App\Http\Controllers\API\Admin\BiographyController::class);
    Route::post('biographies/{biography}/publish', [App\Http\Controllers\API\Admin\BiographyController::class, 'publish']);
    Route::post('biographies/{biography}/unpublish', [App\Http\Controllers\API\Admin\BiographyController::class, 'unpublish']);
    Route::post('biographies/reorder', [App\Http\Controllers\API\Admin\BiographyController::class, 'reorder']);
    
    // Gestion des citations
    Route::apiResource('quotes', App\Http\Controllers\API\Admin\QuoteController::class);
    Route::post('quotes/{quote}/publish', [App\Http\Controllers\API\Admin\QuoteController::class, 'publish']);
    Route::post('quotes/{quote}/unpublish', [App\Http\Controllers\API\Admin\QuoteController::class, 'unpublish']);
    Route::post('quotes/{quote}/feature', [App\Http\Controllers\API\Admin\QuoteController::class, 'feature']);
    
    // Gestion des messages de contact
    Route::apiResource('contact-messages', App\Http\Controllers\API\Admin\ContactMessageController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    Route::post('contact-messages/{contactMessage}/read', [App\Http\Controllers\API\Admin\ContactMessageController::class, 'markAsRead']);
    Route::post('contact-messages/{contactMessage}/reply', [App\Http\Controllers\API\Admin\ContactMessageController::class, 'markAsReplied']);
    Route::post('contact-messages/bulk-action', [App\Http\Controllers\API\Admin\ContactMessageController::class, 'bulkAction']);
    
    // Gestion des réseaux sociaux
    Route::apiResource('social-links', App\Http\Controllers\API\Admin\SocialLinkController::class);
    Route::post('social-links/reorder', [App\Http\Controllers\API\Admin\SocialLinkController::class, 'reorder']);
    
    // Gestion des catégories
    Route::apiResource('categories', App\Http\Controllers\API\Admin\CategoryController::class);
    Route::post('categories/reorder', [App\Http\Controllers\API\Admin\CategoryController::class, 'reorder']);
    
    // Gestion des tags
    Route::apiResource('tags', App\Http\Controllers\API\Admin\TagController::class);
    
    // Upload de fichiers
    Route::post('upload/image', [App\Http\Controllers\API\Admin\MediaController::class, 'uploadImage']);
    Route::post('upload/video', [App\Http\Controllers\API\Admin\MediaController::class, 'uploadVideo']);
    Route::post('upload/audio', [App\Http\Controllers\API\Admin\MediaController::class, 'uploadAudio']);
    Route::post('upload/document', [App\Http\Controllers\API\Admin\MediaController::class, 'uploadDocument']);
    Route::delete('media/{media}', [App\Http\Controllers\API\Admin\MediaController::class, 'destroy']);
});
```

Cette architecture Laravel API fournit une base solide pour l'application mobile du Président. Elle inclut toutes les fonctionnalités demandées dans le cahier des charges avec une structure modulaire, sécurisée et évolutive.

**Points clés de cette architecture :**
- **Sécurité** : Laravel Sanctum pour l'authentification API
- **Gestion des médias** : Spatie Media Library pour les images/vidéos
- **Permissions** : Spatie Laravel Permission pour les rôles
- **Recherche** : Full-text search sur MySQL
- **Performance** : Index optimisés, eager loading
- **Flexibilité** : Système de tags polymorphe, métadonnées JSON
- **Administration** : Interface complète pour gérer tous les contenus

Voulez-vous que je continue avec les contrôleurs et les resources ?