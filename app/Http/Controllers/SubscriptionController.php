<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function checkout(Request $request, string $planCode): View
    {
        $plan = SubscriptionPlan::query()
            ->where('code', $planCode)
            ->where('is_active', true)
            ->firstOrFail();

        if ($plan->code === SubscriptionPlan::CODE_FREE) {
            abort(404);
        }

        $user = $request->user();
        $currentSubscription = $user->activeSubscription()->first();

        if ($currentSubscription && $currentSubscription->plan->code === $plan->code) {
            return redirect()
                ->route('dashboard')
                ->with('info', 'Ya tienes este plan activo.');
        }

        return view('solarcalc.checkout', [
            'plan' => $plan,
            'currentSubscription' => $currentSubscription,
        ]);
    }

    public function subscribe(Request $request, string $planCode): RedirectResponse
    {
        $plan = SubscriptionPlan::query()
            ->where('code', $planCode)
            ->where('is_active', true)
            ->firstOrFail();

        if ($plan->code === SubscriptionPlan::CODE_FREE) {
            abort(404);
        }

        $validated = $request->validate([
            'card_number' => ['required', 'string', 'regex:/^[\d\s]{19}$/'],
            'card_name'   => ['required', 'string', 'min:3', 'max:80'],
            'card_expiry' => ['required', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'card_cvv'    => ['required', 'string', 'regex:/^\d{3,4}$/'],
        ], [
            'card_number.regex' => 'Introduce un número de tarjeta válido (16 dígitos).',
            'card_expiry.regex' => 'Formato de caducidad: MM/AA.',
            'card_cvv.regex'    => 'El CVV debe tener 3 o 4 dígitos.',
        ]);

        $user = $request->user();

        \DB::transaction(function () use ($user, $plan, $validated) {
            // Cancelar suscripción activa anterior si existe
            UserSubscription::query()
                ->where('usuario_fr', $user->id_usuario)
                ->where('status', 'active')
                ->update([
                    'status' => 'cancelled',
                    'ends_at' => now(),
                    'updated_at' => now(),
                ]);

            // Crear nueva suscripción
            UserSubscription::create([
                'usuario_fr'  => $user->id_usuario,
                'plan_fr'     => $plan->id,
                'status'      => 'active',
                'starts_at'   => now(),
                'ends_at'     => $plan->interval === 'month' ? now()->addMonth() : now()->addYear(),
                'source'      => 'self_service',
                'notes'       => 'Pago simulado — tarjeta terminada en ' . substr(str_replace(' ', '', $validated['card_number']), -4),
            ]);
        });

        // Limpiar datos del modal premium de la sesión
        session()->forget(['show_premium_modal', 'premium_modal_reason', 'premium_reason']);

        return redirect()
            ->route('dashboard')
            ->with('success', '🎉 ¡Plan activado! Ya tienes acceso completo a todas las funciones Premium.');
    }

    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $subscription = $user->activeSubscription()->first();
        
        if (!$subscription) {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'No tienes ninguna suscripción activa.');
        }

        if ($subscription->source !== 'self_service') {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'Tu suscripción fue asignada por un administrador. Contacta con soporte para cancelarla.');
        }

        $subscription->update([
            'status' => 'cancelled',
            'ends_at' => now(),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Tu suscripción ha sido cancelada.');
    }
}
