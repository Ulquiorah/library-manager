<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nettoyer d'éventuels doublons avant d'ajouter l'unicité
        DB::statement("
            DELETE p1 FROM penalites p1
            INNER JOIN penalites p2
            WHERE p1.id < p2.id
              AND p1.emprunt_id = p2.emprunt_id
        ");

        Schema::table('penalites', function (Blueprint $table) {
            $table->unique('emprunt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penalites', function (Blueprint $table) {
            $table->dropUnique(['emprunt_id']);
        });
    }
};
