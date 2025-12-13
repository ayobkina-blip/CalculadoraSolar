<?php

namespace App\Http\Controllers;

use App\Models\Usuario; // Importamos el modelo
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios.
     */
    public function index()
    {
        // 1. Obtener todos los usuarios de la base de datos
        // Usa el método all() del modelo Usuario
        $usuarios = Usuario::all(); 

        // 2. Cargar la vista y pasarle la variable $usuarios
        return view('usuarios.usuarios', [
            'lista_usuarios' => $usuarios
        ]);
    }
}