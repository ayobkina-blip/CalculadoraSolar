<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $table = 'resultados';
    protected $primaryKey = 'id_resultado';

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
    'roi_años',
    'usuario_fr',
    'estadistica_fr'
];
}
