<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PremiumController extends Controller
{
    public function index(Request $request, SubscriptionAccessService $subscriptionAccess): View
    {
        return view('solarcalc.premium', $this->buildViewData($request, $subscriptionAccess));
    }

    public function compare(Request $request, SubscriptionAccessService $subscriptionAccess): View
    {
        $validated = $request->validate([
            'resultados' => ['required', 'array', 'min:2', 'max:3'],
            'resultados.*' => ['required', 'integer', 'distinct'],
        ], [
            'resultados.required' => 'Selecciona al menos dos simulaciones para comparar.',
            'resultados.min' => 'Debes seleccionar al menos dos simulaciones.',
            'resultados.max' => 'Solo puedes comparar hasta tres simulaciones a la vez.',
            'resultados.*.distinct' => 'No se pueden repetir simulaciones en el comparador.',
        ]);

        $user = $request->user();
        $requestedIds = collect($validated['resultados'])->map(static fn ($id) => (int) $id)->values();

        $results = Resultado::query()
            ->where('usuario_fr', $user->id_usuario)
            ->whereIn('id_resultado', $requestedIds)
            ->get();

        if ($results->count() !== $requestedIds->count()) {
            abort(403, 'No puedes comparar simulaciones que no te pertenecen.');
        }

        $ordered = $results->sortBy(static function (Resultado $resultado) use ($requestedIds) {
            return $requestedIds->search($resultado->id_resultado);
        })->values();

        return view('solarcalc.premium', $this->buildViewData($request, $subscriptionAccess, $ordered));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $user = $request->user();
        $resultados = Resultado::query()
            ->where('usuario_fr', $user->id_usuario)
            ->latest()
            ->get();

        $filename = 'solarcalc_resultados_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($resultados): void {
            $file = fopen('php://output', 'w');

            if ($file === false) {
                return;
            }

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Fecha',
                'Ubicación',
                'Potencia (kWp)',
                'Producción anual (kWh)',
                'Ahorro anual (€)',
                'ROI (años)',
            ], ';');

            foreach ($resultados as $resultado) {
                fputcsv($file, [
                    $resultado->id_resultado,
                    $resultado->created_at?->format('d/m/Y H:i') ?? '-',
                    $resultado->ubicacion,
                    number_format((float) $resultado->potencia_instalacion_kwp, 2, '.', ''),
                    number_format((float) $resultado->produccion_anual_kwh, 2, '.', ''),
                    number_format((float) $resultado->ahorro_estimado_eur, 2, '.', ''),
                    number_format((float) $resultado->roi_anyos, 1, '.', ''),
                ], ';');
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildViewData(
        Request $request,
        SubscriptionAccessService $subscriptionAccess,
        ?Collection $comparisonResults = null
    ): array {
        $user = $request->user();
        $currentPlan = $subscriptionAccess->getCurrentPlan($user);

        $resultadosUsuario = Resultado::query()
            ->select([
                'id_resultado',
                'ubicacion',
                'potencia_instalacion_kwp',
                'ahorro_estimado_eur',
                'roi_anyos',
                'created_at',
            ])
            ->where('usuario_fr', $user->id_usuario)
            ->latest()
            ->take(60)
            ->get();

        $planCatalog = $subscriptionAccess->getPlanCatalog();

        return [
            'currentPlan' => $currentPlan,
            'planCatalog' => $planCatalog,
            'reason' => $request->query('reason', session('premium_reason')),
            'remainingSimulations' => $subscriptionAccess->remainingSimulations($user),
            'isPremiumActive' => $subscriptionAccess->isPremiumActive($user),
            'monthlyPlan' => $planCatalog->firstWhere('code', SubscriptionPlan::CODE_PREMIUM_MONTHLY),
            'yearlyPlan' => $planCatalog->firstWhere('code', SubscriptionPlan::CODE_PREMIUM_YEARLY),
            'userResultsForCompare' => $resultadosUsuario,
            'comparisonResults' => $comparisonResults ?? collect(),
        ];
    }
}
