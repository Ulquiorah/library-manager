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
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livre_id')->constrained('livres')->onDelete('cascade');
            $table->dateTime('date_emprunt');
            $table->dateTime('date_retour_prevue');
            $table->dateTime('date_retour_reelle')->nullable();
            $table->enum('statut', ['en_cours', 'retourne', 'retard'])->default('en_cours');
            $table->timestamps();
            
            // Index pour les requetes communes
            $table->index('user_id');
            $table->index('livre_id');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};
