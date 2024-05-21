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
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('image');
            $table->string('etat');
            $table->unsignedBigInteger('id_famille_materiel');
            $table->foreign('id_famille_materiel')->references('id')->on('famille_materiels')
            ->onUpdate('restrict')
            ->onDelete('restrict');
            $table->unsignedBigInteger('id_casier');
            $table->foreign('id_casier')->references('id')->on('casiers')
            ->onUpdate('restrict')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiels');
    }
};
