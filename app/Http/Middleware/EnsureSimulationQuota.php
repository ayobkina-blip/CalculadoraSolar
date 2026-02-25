<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionAccessService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSimulationQuota
{
    public function __construct(private readonly SubscriptionAccessService $subscriptionAccess)
    {
    }

    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$this->subscriptionAccess->canCreateSimulation($user)) {
            return redirect()
                ->route('premium.index', ['reason' => 'simulation_quota'])
                ->with('premium_reason', 'simulation_quota')
                ->with('error', 'Has alcanzado el límite gratuito de 3 simulaciones.');
        }

        return $next($request);
    }
}
