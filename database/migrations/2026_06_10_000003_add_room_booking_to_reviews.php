<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Enrichit la table reviews avec room_id et booking_id.
     * Utilise du SQL brut pour contourner les limitations MySQL sur les FK/index.
     */
    public function up(): void
    {
        // 1. Désactiver les vérifications FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 2. Supprimer d'abord la FK sur client_id et hotel_id (qui bloque l'index unique)
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_client_id_foreign');
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_hotel_id_foreign');

        // 3. Supprimer l'index unique
        DB::statement('ALTER TABLE reviews DROP INDEX reviews_client_id_hotel_id_unique');

        // 4. Recréer les FK
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_client_id_foreign FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE reviews MODIFY hotel_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_hotel_id_foreign FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE');

        // 5. Ajouter les nouvelles colonnes
        DB::statement('ALTER TABLE reviews ADD COLUMN room_id BIGINT UNSIGNED NULL AFTER hotel_id');
        DB::statement('ALTER TABLE reviews ADD COLUMN booking_id BIGINT UNSIGNED NULL AFTER room_id');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_room_id_foreign FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL');

        // 6. Réactiver
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_room_id_foreign');
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_booking_id_foreign');
        DB::statement('ALTER TABLE reviews DROP COLUMN room_id');
        DB::statement('ALTER TABLE reviews DROP COLUMN booking_id');
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_hotel_id_foreign');
        DB::statement('ALTER TABLE reviews MODIFY hotel_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_hotel_id_foreign FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE reviews DROP FOREIGN KEY reviews_client_id_foreign');
        DB::statement('ALTER TABLE reviews ADD UNIQUE KEY reviews_client_id_hotel_id_unique (client_id, hotel_id)');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_client_id_foreign FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
