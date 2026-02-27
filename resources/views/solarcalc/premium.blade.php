{{-- This view is deprecated - premium functionality now uses global modal --}}
{{-- Kept for backwards compatibility with compare method --}}
@if($comparisonResults->isNotEmpty())
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Resultado de comparación</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            <th class="py-2 pr-4">Simulación</th>
                            <th class="py-2 pr-4">Potencia</th>
                            <th class="py-2 pr-4">Ahorro</th>
                            <th class="py-2 pr-4">ROI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($comparisonResults as $result)
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-gray-900 dark:text-white">#{{ $result->id_resultado }} · {{ $result->ubicacion }}</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ number_format($result->potencia_instalacion_kwp, 2) }} kWp</td>
                                <td class="py-3 pr-4 text-emerald-600 dark:text-emerald-400">{{ number_format($result->ahorro_estimado_eur, 2) }} €</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ number_format($result->roi_anyos, 1) }} años</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
