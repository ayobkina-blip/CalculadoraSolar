<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema; // Añadimos esto para la comprobación

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
// app/Http/Controllers/ProfileController.php
public function edit(Request $request): View
{
    $user = $request->user();

    // Contamos las filas en la tabla 'resultados' donde 'usuario_fr' sea el ID del usuario
    $simulaciones = $user->presupuestos()->count();

    // Calculamos el promedio de la columna exacta: 'ahorro_estimado_eur'
    $ahorroMedio = $user->presupuestos()->avg('ahorro_estimado_eur') ?? 0;

    return view('profile.edit', [
        'user' => $user,
        'totalSimulaciones' => $simulaciones,
        'ahorroMedio' => $ahorroMedio,
    ]);
}

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // 1. Validamos los datos
        $data = $request->validated();

        // 2. Mapeo Manual: 
        // Si tu columna en la DB es 'nombre', le asignamos el valor de 'name' del form
        $user->nombre = $data['name']; 
        $user->email = $data['email'];

        // 3. Manejo del email_verified_at (Evita el error si no existe la columna)
        if ($user->isDirty('email')) {
            if (Schema::hasColumn('usuarios', 'email_verified_at')) {
                $user->email_verified_at = null;
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', '¡Configuración guardada con éxito!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}