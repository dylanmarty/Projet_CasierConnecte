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
        Schema::disableForeignKeyConstraints();
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_emprunt');
            $table->timestamp('date_retour');
            $table->unsignedBigInteger('id_adherent');
            $table->foreign('id_adherent')->references('id')->on('adherents')
            ->onUpdate('restrict')
            ->onDelete('restrict');
            $table->unsignedBigInteger('id_materiel');
            $table->foreign('id_materiel')->references('id')->on('materiels')
            ->onUpdate('restrict')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunt');
    }
};