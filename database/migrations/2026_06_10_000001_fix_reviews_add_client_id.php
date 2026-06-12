<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Corrige la table reviews :
     * - Supprime l'ancienne colonne user_id et la remplace par client_id
     * - Ajoute une contrainte unique (client_id, hotel_id) pour éviter les doublons
     */
    public function up(): void
    {
        // Recréer la table avec la bonne structure
        Schema::dropIfExists('reviews');

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('note')->unsigned(); // 1 à 5
            $table->text('commentaire')->nullable();
            $table->timestamps();

            // Un client ne peut laisser qu'un seul avis par hôtel
            $table->unique(['client_id', 'hotel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }
};
