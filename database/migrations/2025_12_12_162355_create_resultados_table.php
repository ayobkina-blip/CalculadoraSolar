<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id('id_resultado'); // INT NOT NULL AUTO_INCREMENT
            $table->decimal('ahorro_estimado_eur', 10, 2)->nullable();
            $table->integer('fuerza')->nullable();
            $table->string('ubicacion', 100)->nullable();
            $table->integer('consumo_anual')->nullable();
            $table->integer('radiacion_a_medida')->nullable();
            
            // Claves Foráneas
            // Laravel usa bigIncrements para IDs, por eso usamos bigInteger
            $table->bigInteger('usuario_fr')->unsigned()->nullable();
            $table->bigInteger('estadistica_fr')->unsigned()->nullable();
            
            $table->timestamps(); // Recomendado

            // Definición de las Constraints
            $table->foreign('usuario_fr', 'fk_resultados_usuarios')
                  ->references('id_usuario')->on('usuarios')
                  ->onDelete('SET NULL');
            
            $table->foreign('estadistica_fr', 'fk_resultados_estadisticas')
                  ->references('id_estadistica')->on('estadisticas')
                  ->onDelete('SET NULL');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};