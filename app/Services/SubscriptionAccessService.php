<?php

namespace App\Services;

use App\Models\Resultado;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Collection;

class SubscriptionAccessService
{
    public function getCurrentPlan(User $user): SubscriptionPlan
    {
        if ($user->isAdminBypass()) {
            return $this->getAdminVirtualPlan();
        }

        $subscription = $this->getCurrentSubscription($user);

        if ($subscription?->plan) {
            return $subscription->plan;
        }

        return $this->getFreePlan();
    }

    public function getCurrentSubscription(User $user): ?UserSubscription
    {
        if ($user->isAdminBypass()) {
            return null;
        }

        $now = now();

        // Keep subscription status coherent when it has expired.
        UserSubscription::query()
            ->where('usuario_fr', $user->id_usuario)
            ->where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<', $now)
            ->update(['status' => 'expired']);

        return UserSubscription::query()
            ->with('plan')
            ->where('usuario_fr', $user->id_usuario)
            ->where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->orderByDesc('ends_at')
            ->orderByDesc('id')
            ->first();
    }

    public function hasFeature(User $user, string $feature): bool
    {
        if ($user->isAdminBypass()) {
            return true;
        }

        return $this->getCurrentPlan($user)->hasFeature($feature);
    }

    public function remainingSimulations(User $user): ?int
    {
        if ($user->isAdminBypass()) {
            return null;
        }

        $plan = $this->getCurrentPlan($user);

        if ($plan->simulation_limit === null) {
            return null;
        }

        $used = Resultado::query()
            ->where('usuario_fr', $user->id_usuario)
            ->count();

        return max(0, $plan->simulation_limit - $used);
    }

    public function canCreateSimulation(User $user): bool
    {
        $remaining = $this->remainingSimulations($user);

        return $remaining === null || $remaining > 0;
    }

    public function isPremiumActive(User $user): bool
    {
        if ($user->isAdminBypass()) {
            return true;
        }

        return $this->getCurrentPlan($user)->code !== SubscriptionPlan::CODE_FREE;
    }

    public function getPlanCatalog(): Collection
    {
        return SubscriptionPlan::query()
            ->where('is_active', true)
            ->whereIn('code', [
                SubscriptionPlan::CODE_PREMIUM_MONTHLY,
                SubscriptionPlan::CODE_PREMIUM_YEARLY,
            ])
            ->orderByRaw("CASE code WHEN 'premium_monthly' THEN 1 WHEN 'premium_yearly' THEN 2 ELSE 3 END")
            ->get();
    }

    private function getFreePlan(): SubscriptionPlan
    {
        $freePlan = SubscriptionPlan::query()
            ->where('code', SubscriptionPlan::CODE_FREE)
            ->first();

        if ($freePlan) {
            return $freePlan;
        }

        return new SubscriptionPlan([
            'code' => SubscriptionPlan::CODE_FREE,
            'name' => 'Free',
            'price_cents' => 0,
            'currency' => 'EUR',
            'interval' => 'none',
            'simulation_limit' => 3,
            'features' => [],
            'is_active' => true,
        ]);
    }

    private function getAdminVirtualPlan(): SubscriptionPlan
    {
        return new SubscriptionPlan([
            'code' => 'admin_bypass',
            'name' => 'Admin Bypass',
            'price_cents' => 0,
            'currency' => 'EUR',
            'interval' => 'none',
            'simulation_limit' => null,
            'features' => [
                SubscriptionPlan::FEATURE_PDF_EXPORT,
                SubscriptionPlan::FEATURE_ADVANCED_STATS,
                SubscriptionPlan::FEATURE_RESULT_COMPARE,
                SubscriptionPlan::FEATURE_CSV_EXPORT,
            ],
            'is_active' => true,
        ]);
    }
}
