<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute remember_token à la table clients.
     * Requis par Laravel Auth pour la fonctionnalité "Se souvenir de moi".
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->rememberToken()->after('telephone');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
