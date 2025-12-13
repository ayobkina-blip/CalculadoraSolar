<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id('id_estadistica'); // INT NOT NULL AUTO_INCREMENT
            $table->date('fecha_generada')->nullable();
            $table->integer('total_resultados')->nullable();
            $table->integer('ahorro_media')->nullable();
            $table->string('ubicacion_frecuente', 20)->nullable();
            $table->integer('radiacion_a_medida')->nullable();
            $table->timestamps(); // Recomendado
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estadisticas');
    }
};