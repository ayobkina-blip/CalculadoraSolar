<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSubscriptionController extends Controller
{
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id'   => ['required', 'integer', 'exists:subscription_plans,id'],
            'starts_at' => ['nullable', 'date'],
            'ends_at'   => ['nullable', 'date', 'after_or_equal:starts_at'],
            'notes'     => ['nullable', 'string', 'max:1000'],
        ]);

        $usuario = \App\Models\User::where('id_usuario', $id)->firstOrFail();
        $plan    = \App\Models\SubscriptionPlan::findOrFail($validated['plan_id']);
        $admin   = $request->user();

        \DB::transaction(function () use ($usuario, $plan, $admin, $validated) {
            // 1. Cancelar cualquier suscripción activa anterior
            $usuario->subscriptions()
                ->where('status', 'active')
                ->update([
                    'status'  => 'cancelled',
                    'ends_at' => now(),
                ]);

            // 2. Crear la nueva suscripción
            \App\Models\UserSubscription::create([
                'usuario_fr'      => $usuario->id_usuario,
                'plan_fr'         => $plan->id,
                'status'          => 'active',
                'starts_at'       => $validated['starts_at'] ?? now(),
                'ends_at'         => $validated['ends_at'] ?? (
                    $plan->interval === 'month' ? now()->addMonth() :
                    ($plan->interval === 'year'  ? now()->addYear()  : null)
                ),
                'activated_by_fr' => $admin->id_usuario,
                'source'          => 'manual_admin',
                'notes'           => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('solar.admin')
            ->with('success', "Plan {$plan->name} asignado correctamente a {$usuario->nombre}.");
    }

    public function cancel(Request $request, int $id): RedirectResponse
    {
        $usuario = \App\Models\User::where('id_usuario', $id)->firstOrFail();

        $canceladas = $usuario->subscriptions()
            ->where('status', 'active')
            ->update([
                'status'  => 'cancelled',
                'ends_at' => now(),
            ]);

        $mensaje = $canceladas > 0
            ? "Suscripción de {$usuario->nombre} cancelada correctamente."
            : "El usuario {$usuario->nombre} no tenía ninguna suscripción activa.";

        return redirect()
            ->route('solar.admin')
            ->with('success', $mensaje);
    }
}
