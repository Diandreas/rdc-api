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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};

