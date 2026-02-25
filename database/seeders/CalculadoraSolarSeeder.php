<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Necesitas importar esto

class CalculadoraSolarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DESACTIVAR LA RESTRICCIÓN DE CLAVES FORÁNEAS TEMPORALMENTE
        Schema::disableForeignKeyConstraints();

        // 2. LIMPIAR TABLAS (DEBE HACERSE EN ORDEN INVERSO O EN CASCADA)
        // Usamos TRUNCATE si la tabla no tiene auto_increment (pero es más seguro usar DELETE)
        // Vamos a usar TRUNCATE, que era tu intención, después de deshabilitar.
        DB::table('resultados')->truncate();
        DB::table('estadisticas')->truncate();
        DB::table('usuarios')->truncate();
        

        // 3. REACTIVAR LA RESTRICCIÓN DE CLAVES FORÁNEAS
        Schema::enableForeignKeyConstraints();

        // 4. INSERCIÓN DE DATOS (POBLAR TABLAS)
        // ... (El resto de tu código INSERTs y ALTER TABLE AUTO_INCREMENT)

        // Inserción en `usuarios`
        DB::table('usuarios')->insert([
            ['id_usuario' => 1, 'nombre' => 'Ayob', 'correo_electronico' => 'ayob.ejemplo@email.com', 'rol' => 1, 'contrasena_hash' => 'password'],
            ['id_usuario' => 2, 'nombre' => 'Maria López', 'correo_electronico' => 'maria.lopez@ejemplo.com', 'rol' => 0, 'contrasena_hash' => 'password'],
            ['id_usuario' => 3, 'nombre' => 'Pedro García', 'correo_electronico' => 'pedro.garcia@ejemplo.com', 'rol' => 0, 'password'],
        ]);
        DB::statement('ALTER TABLE usuarios AUTO_INCREMENT = 4;');


        // Inserción en `estadisticas`
        DB::table('estadisticas')->insert([
            ['id_estadistica' => 101, 'fecha_generada' => '2025-12-01', 'total_resultados' => 580, 'ahorro_media' => 250, 'ubicacion_frecuente' => 'Algemesi', 'radiacion_a_medida' => 1450],
            ['id_estadistica' => 102, 'fecha_generada' => '2025-11-15', 'total_resultados' => 310, 'ahorro_media' => 210, 'ubicacion_frecuente' => 'Valencia', 'radiacion_a_medida' => 1600],
            ['id_estadistica' => 103, 'fecha_generada' => '2025-10-20', 'total_resultados' => 105, 'ahorro_media' => 180, 'ubicacion_frecuente' => 'Madrid', 'radiacion_a_medida' => 1200],
        ]);
        DB::statement('ALTER TABLE estadisticas AUTO_INCREMENT = 104;');


        // Inserción en `resultados`
        DB::table('resultados')->insert([
            ['id_resultado' => 1, 'ahorro_estimado_eur' => 350.50, 'fuerza' => 4, 'ubicacion' => 'Calle Benimodo 3, Algemesi', 'consumo_anual' => 4500, 'radiacion_a_medida' => 1450, 'usuario_fr' => 1, 'estadistica_fr' => 101],
            ['id_resultado' => 2, 'ahorro_estimado_eur' => 215.00, 'fuerza' => 3, 'ubicacion' => 'Calle de la Paz, Valencia', 'consumo_anual' => 3200, 'radiacion_a_medida' => 1600, 'usuario_fr' => 2, 'estadistica_fr' => 102],
            ['id_resultado' => 3, 'ahorro_estimado_eur' => 180.75, 'fuerza' => 2, 'ubicacion' => 'Plaza Mayor, Madrid', 'consumo_anual' => 2800, 'radiacion_a_medida' => 1200, 'usuario_fr' => 3, 'estadistica_fr' => 103],
            ['id_resultado' => 4, 'ahorro_estimado_eur' => 400.99, 'fuerza' => 5, 'ubicacion' => 'Calle Benimodo 3, Algemesi', 'consumo_anual' => 5100, 'radiacion_a_medida' => 1450, 'usuario_fr' => 1, 'estadistica_fr' => 101],
        ]);
        DB::statement('ALTER TABLE resultados AUTO_INCREMENT = 5;');

    }
}