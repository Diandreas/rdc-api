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
        Schema::table('social_links', function (Blueprint $table) {
            // Ajouter les nouvelles colonnes pour les actes
            $table->string('title')->default('')->after('id');
            $table->longText('content')->default('')->after('title');
            $table->string('act_type')->default('autre')->after('content');
            $table->string('act_number')->nullable()->after('act_type');
            $table->date('signature_date')->default('2024-01-01')->after('act_number');
            $table->string('signature_location')->default('')->after('signature_date');
            $table->string('document_url')->nullable()->after('signature_location');
            $table->boolean('is_featured')->default(false)->after('document_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_links', function (Blueprint $table) {
            // Supprimer les nouvelles colonnes
            $table->dropColumn([
                'title', 'content', 'act_type', 
                'act_number', 'signature_date', 'signature_location', 
                'document_url', 'is_featured'
            ]);
        });
    }
};
