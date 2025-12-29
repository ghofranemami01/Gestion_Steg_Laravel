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
        Schema::create('abonnes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('num_cin')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_abonnement');
            $table->string('num_compteur_elec')->unique();
            $table->string('num_compteur_gaz')->unique();
            $table->text('adresse');
            $table->string('tel');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnes');
    }
};
