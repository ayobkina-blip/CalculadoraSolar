<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'plan_code' => ['required', 'string', 'in:premium_monthly,premium_yearly,free'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1200'],
        ]);

        $targetUser = User::query()->where('id_usuario', $id)->firstOrFail();
        $adminId = $request->user()->id_usuario;

        if ($validated['plan_code'] === SubscriptionPlan::CODE_FREE) {
            UserSubscription::query()
                ->where('usuario_fr', $targetUser->id_usuario)
                ->where('status', 'active')
                ->update([
                    'status' => 'cancelled',
                    'ends_at' => now(),
                    'notes' => $validated['notes'] ?? 'Cambio manual a plan FREE',
                    'updated_at' => now(),
                ]);

            return back()->with('success', "{$targetUser->nombre} ahora está en plan FREE.");
        }

        $plan = SubscriptionPlan::query()
            ->where('code', $validated['plan_code'])
            ->where('is_active', true)
            ->firstOrFail();

        $startsAt = !empty($validated['starts_at'])
            ? Carbon::parse($validated['starts_at'])->startOfDay()
            : now();

        $endsAt = !empty($validated['ends_at'])
            ? Carbon::parse($validated['ends_at'])->endOfDay()
            : $this->buildDefaultEndDate($plan->interval, $startsAt);

        if ($endsAt && $endsAt->lessThanOrEqualTo($startsAt)) {
            return back()->with('error', 'La fecha de fin debe ser posterior a la fecha de inicio.');
        }

        UserSubscription::query()
            ->where('usuario_fr', $targetUser->id_usuario)
            ->where('status', 'active')
            ->update([
                'status' => 'cancelled',
                'ends_at' => now(),
                'updated_at' => now(),
            ]);

        UserSubscription::query()->create([
            'usuario_fr' => $targetUser->id_usuario,
            'plan_fr' => $plan->id,
            'status' => 'active',
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'activated_by_fr' => $adminId,
            'source' => 'manual_admin',
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', "Plan {$plan->name} activado para {$targetUser->nombre}.");
    }

    public function cancel(Request $request, int $id): RedirectResponse
    {
        $targetUser = User::query()->where('id_usuario', $id)->firstOrFail();

        $affected = UserSubscription::query()
            ->where('usuario_fr', $targetUser->id_usuario)
            ->where('status', 'active')
            ->update([
                'status' => 'cancelled',
                'ends_at' => now(),
                'updated_at' => now(),
            ]);

        if ($affected === 0) {
            return back()->with('error', 'El usuario no tiene suscripciones activas para cancelar.');
        }

        return back()->with('success', "Suscripción premium cancelada para {$targetUser->nombre}.");
    }

    private function buildDefaultEndDate(string $interval, Carbon $startsAt): ?Carbon
    {
        return match ($interval) {
            'month' => $startsAt->copy()->addMonth(),
            'year' => $startsAt->copy()->addYear(),
            default => null,
        };
    }
}
