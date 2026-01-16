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
        'radiacion_a_medida',
        'usuario_fr',
        'estadistica_fr'
    ];
}
