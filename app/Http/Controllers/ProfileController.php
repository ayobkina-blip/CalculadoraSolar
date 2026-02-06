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
     * Permite actualizar solo nombre, solo email, solo avatar, o cualquier combinación.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        
        // 1. Procesar avatar si se subió (automático)
        if ($request->hasFile('avatar')) {
            try {
                // Borrar avatar antiguo si existe para ahorrar espacio
                if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                    \Storage::disk('public')->delete($user->avatar);
                }
                
                // Guardar nueva imagen
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            } catch (\Exception $e) {
                return Redirect::route('profile.edit')
                    ->withErrors(['avatar' => 'Error al guardar la imagen: ' . $e->getMessage()]);
            }
        }
        
        // 2. Actualizar nombre solo si se proporcionó
        if (isset($validated['name']) && !empty(trim($validated['name']))) {
            $user->nombre = trim($validated['name']);
        }
        
        // 3. Actualizar email solo si se proporcionó
        if (isset($validated['email']) && !empty(trim($validated['email']))) {
            $emailAnterior = $user->email;
            $user->email = strtolower(trim($validated['email']));
            
            // Si cambió el email, invalidar verificación
            if ($emailAnterior !== $user->email) {
                $user->email_verified_at = null;
            }
        }
        
        // 4. Guardar cambios
        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', 'Perfil actualizado correctamente');
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