<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
