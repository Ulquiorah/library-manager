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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100)->unique();
            $table->timestamps();
        });

        // Importer les catégories déjà présentes dans la table livres
        if (Schema::hasTable('livres')) {
            $noms = DB::table('livres')
                ->whereNotNull('categorie')
                ->where('categorie', '!=', '')
                ->distinct()
                ->pluck('categorie');

            $now = now();
            $rows = $noms->map(fn ($nom) => [
                'nom' => $nom,
                'created_at' => $now,
                'updated_at' => $now,
            ])->all();

            if (!empty($rows)) {
                DB::table('categories')->insert($rows);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
