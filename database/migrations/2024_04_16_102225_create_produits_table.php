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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_restaurant')->constrained();
            $table->string('nom');
            $table->enum('categorie', ['entree', 'plats', 'desserts', 'boissons']);            
            $table->decimal('prix_HT');
            $table->decimal('taux_TVA');
            $table->decimal('prix_TTC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
