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
        // Renombra la columna 'correo_electronico' a 'email'
        Schema::table('usuarios', function (Blueprint $table) {
            $table->renameColumn('correo_electronico', 'email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Renombra la columna de vuelta, en caso de querer revertir la migración
        Schema::table('usuarios', function (Blueprint $table) {
            $table->renameColumn('email', 'correo_electronico');
        });
    }
};
