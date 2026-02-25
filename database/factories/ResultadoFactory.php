<?php

namespace Database\Factories;

use App\Models\Resultado;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resultado>
 */
class ResultadoFactory extends Factory
{
    protected $model = Resultado::class;

    public function definition(): array
    {
        return [
            'ubicacion' => fake()->city(),
            'latitud' => fake()->latitude(),
            'longitud' => fake()->longitude(),
            'consumo_anual' => fake()->numberBetween(1200, 12000),
            'superficie_disponible' => fake()->randomFloat(2, 10, 200),
            'orientacion' => fake()->randomElement([-90, -45, 0, 45, 90]),
            'inclinacion' => fake()->numberBetween(0, 90),
            'ahorro_estimado_eur' => fake()->randomFloat(2, 300, 5000),
            'paneles_sugeridos' => fake()->numberBetween(4, 40),
            'potencia_instalacion_kwp' => fake()->randomFloat(2, 1.8, 18),
            'produccion_anual_kwh' => fake()->randomFloat(2, 800, 20000),
            'roi_anyos' => fake()->randomFloat(1, 2, 12),
            'usuario_fr' => User::factory(),
            'estado' => fake()->randomElement(['pendiente', 'aprobado', 'rechazado']),
        ];
    }
}
