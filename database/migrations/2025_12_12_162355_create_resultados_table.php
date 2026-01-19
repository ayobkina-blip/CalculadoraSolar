<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id('id_resultado');
            $table->string('ubicacion', 100)->nullable();
            $table->integer('consumo_anual')->nullable();
            
            // Campos técnicos para el cálculo real
            $table->decimal('superficie_disponible', 10, 2)->nullable();
            $table->integer('orientacion')->default(0);
            $table->integer('inclinacion')->default(30);
            
            // Resultados del cálculo
            $table->decimal('ahorro_estimado_eur', 10, 2)->nullable();
            $table->integer('paneles_sugeridos')->nullable();
            $table->float('potencia_instalacion_kwp')->nullable();
            $table->float('produccion_anual_kwh')->nullable();
            $table->decimal('roi_anyos', 5, 2)->nullable();
            
            $table->integer('radiacion_a_medida')->nullable();
            $table->integer('fuerza')->nullable();

            // Relaciones
            $table->bigInteger('usuario_fr')->unsigned()->nullable();
            $table->bigInteger('estadistica_fr')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('usuario_fr')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('estadistica_fr')->references('id_estadistica')->on('estadisticas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};