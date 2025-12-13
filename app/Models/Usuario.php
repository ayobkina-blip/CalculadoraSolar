<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    // Indica que el modelo usa la tabla 'usuarios'
    protected $table = 'usuarios';

    // Indica que la clave primaria se llama 'id_usuario' y no 'id'
    protected $primaryKey = 'id_usuario';
}