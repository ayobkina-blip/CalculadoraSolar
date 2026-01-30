<?php

namespace App\Http\Controllers;

use App\Models\User; // Usamos el modelo User configurado previamente
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios registrados en el sistema.
     * Optimizado para el Panel de Administración de SolarCalc.
     */
    public function index(): View
    {
        // 1. Obtenemos los usuarios con 'withCount' para saber 
        // cuántos resultados/presupuestos tiene cada uno sin recargar la DB.
        $usuarios = User::withCount('resultados')->get(); 

        // 2. Retornamos la vista con un nombre de variable descriptivo
        return view('usuarios.usuarios', [
            'usuarios' => $usuarios,
            'total_registros' => $usuarios->count()
        ]);
    }

    /**
     * Opcional: Podrías añadir un método para ver el perfil técnico 
     * detallado de un usuario específico.
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }
}