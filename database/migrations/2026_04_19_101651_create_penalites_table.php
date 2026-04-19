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
        Schema::create('penalites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('emprunt_id')->constrained('emprunts')->onDelete('cascade');
            $table->decimal('montant', 8, 2);
            $table->string('raison');
            $table->dateTime('date_application');
            $table->boolean('payee')->default(false);
            $table->dateTime('date_paiement')->nullable();
            $table->timestamps();
            
            // Index pour les requetes communes
            $table->index('user_id');
            $table->index('payee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalites');
    }
};
