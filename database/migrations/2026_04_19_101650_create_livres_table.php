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
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('auteur')->nullable();
            $table->string('isbn', 20)->nullable();
            $table->unique('isbn');
            $table->text('description')->nullable();
            $table->string('categorie')->nullable();
            $table->date('date_publication')->nullable();
            $table->integer('quantite')->default(1);
            $table->integer('quantite_disponible')->default(1);
            $table->string('photo')->nullable();
            $table->text('resume')->nullable();
            $table->string('editeur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};
