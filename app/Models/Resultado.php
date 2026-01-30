<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    /**
     * CONFIGURACIÓN DE TABLA
     */
    protected $table = 'resultados';
    protected $primaryKey = 'id_resultado';

    /**
     * ASIGNACIÓN MASIVA
     * Definimos todos los parámetros técnicos que el motor de cálculo
     * inyectará en la base de datos tras una simulación.
     */
    protected $fillable = [
        'ahorro_estimado_eur', 
        'fuerza', 
        'ubicacion', 
        'consumo_anual', 
        'superficie_disponible',
        'orientacion',
        'inclinacion',
        'eficiencia_sistema',
        'latitud',
        'longitud',
        'paneles_sugeridos',
        'potencia_instalacion_kwp',
        'produccion_anual_kwh',
        'roi_anyos',
        'usuario_fr',
        'estadistica_fr',
        'estado',
    ];

    /**
     * CASTING DE ATRIBUTOS
     * Crucial para el Dashboard: Convertimos los strings de la DB en 
     * floats y enteros para poder operar con ellos en JavaScript y PHP.
     */
    protected $casts = [
        'ahorro_estimado_eur'      => 'float',
        'consumo_anual'            => 'float',
        'produccion_anual_kwh'     => 'float',
        'potencia_instalacion_kwp' => 'float',
        'roi_anyos'                => 'float',
        'paneles_sugeridos'        => 'integer',
        'latitud'                  => 'decimal:8',
        'longitud'                 => 'decimal:8',
        'created_at'               => 'datetime',
    ];

    /**
     * RELACIÓN: USUARIO
     * Cada resultado pertenece a un usuario específico.
     * Útil para: $resultado->usuario->name
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_fr', 'id_usuario');
    }

    /**
     * SCOPES (Consultas rápidas)
     * Permite filtrar resultados de alto rendimiento fácilmente.
     */
    public function scopeAltoAhorro($query)
    {
        return $query->where('ahorro_estimado_eur', '>', 1000);
    }

    /**
     * ACCESOR: FORMATO DE MONEDA
     * Permite usar $resultado->ahorro_formateado en las vistas.
     */
    public function getAhorroFormateadoAttribute(): string
    {
        return number_format($this->ahorro_estimado_eur, 2, ',', '.') . '€';
    }
}