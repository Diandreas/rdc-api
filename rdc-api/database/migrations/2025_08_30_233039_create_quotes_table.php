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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

