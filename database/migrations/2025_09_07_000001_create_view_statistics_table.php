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
        Schema::create('view_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('viewable_type'); // Type de modèle (Category, Speech, etc.)
            $table->unsignedBigInteger('viewable_id'); // ID du modèle
            $table->date('date'); // Date de la vue
            $table->unsignedInteger('views')->default(1); // Nombre de vues pour ce jour
            $table->timestamps();

            // Index composé pour optimiser les requêtes
            $table->index(['viewable_type', 'viewable_id', 'date']);
            $table->index(['viewable_type', 'date']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_statistics');
    }
};