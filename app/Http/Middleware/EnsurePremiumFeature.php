<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionAccessService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremiumFeature
{
    public function __construct(private readonly SubscriptionAccessService $subscriptionAccess)
    {
    }

    public function handle(Request $request, Closure $next, string $feature): Response|RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$this->subscriptionAccess->hasFeature($user, $feature)) {
            return redirect()
                ->back()
                ->with('show_premium_modal', true)
                ->with('premium_modal_reason', $feature)
                ->with('error', 'Esta función está disponible solo para cuentas Premium.');
        }

        return $next($request);
    }
}
