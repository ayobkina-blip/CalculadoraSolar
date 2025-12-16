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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // INT NOT NULL AUTO_INCREMENT
            $table->string('nombre', 100);
            $table->string('correo_electronico', 100)->unique();
            $table->tinyInteger('rol')->default(0)->comment('1 para Admin/Editor, 0 para Usuario estándar');
            $table->string('contrasena_hash', 255);
            $table->rememberToken();
            // Laravel usa created_at y updated_at, aunque no estaban en tu SQL, son buena práctica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};