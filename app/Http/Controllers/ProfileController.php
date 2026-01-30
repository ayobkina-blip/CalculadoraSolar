<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de perfil con métricas de rendimiento.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Extraemos métricas del historial de cálculos del usuario
        // Usamos la relación presupuestos() definida en el Modelo User
        $simulaciones = $user->presupuestos()->count();

        // Calculamos el ahorro medio histórico del ingeniero/usuario
        $ahorroMedio = $user->presupuestos()->avg('ahorro_estimado_eur') ?? 0;

        return view('profile.edit', [
            'user' => $user,
            'totalSimulaciones' => $simulaciones,
            'ahorroMedio' => round($ahorroMedio, 2),
        ]);
    }

    /**
     * Actualiza la identidad del usuario en el sistema.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Validar y subir el avatar
        if ($request->hasFile('avatar')) {
            // Opcional: Borrar avatar antiguo para ahorrar espacio
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina permanentemente el registro y purga la sesión.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // 1. Cierre de sesión de seguridad
        Auth::logout();

        // 2. Eliminación física del registro (y cascada de presupuestos si está configurada)
        $user->delete();

        // 3. Destrucción de la sesión actual
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}