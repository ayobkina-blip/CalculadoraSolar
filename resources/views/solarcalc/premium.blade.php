<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Planes Premium
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Desbloquea funciones avanzadas de SolarCalc</p>
            </div>
        </div>
    </x-slot>

    @php
        $reasonMessages = [
            'simulation_quota' => 'Has alcanzado el límite gratuito de 3 simulaciones. Actualiza para continuar.',
            'pdf_export' => 'La descarga e impresión de PDF requiere una cuenta Premium.',
            'advanced_stats' => 'Las métricas avanzadas están disponibles solo en Premium.',
            'result_compare' => 'El comparador de simulaciones es exclusivo para Premium.',
            'csv_export' => 'La exportación CSV es una función Premium.',
        ];

        $reasonText = $reasonMessages[$reason] ?? null;
        $formatPrice = fn ($plan) => number_format(($plan?->price_cents ?? 0) / 100, 2);
    @endphp

    <div class="space-y-6 sm:space-y-8">
        @if($reasonText)
            <div class="rounded-2xl border border-amber-300/70 dark:border-amber-700/50 bg-amber-50 dark:bg-amber-900/20 p-4 sm:p-5">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M3.055 11h17.89" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Acción bloqueada por plan</p>
                        <p class="text-sm text-amber-700/90 dark:text-amber-300/90 mt-1">{{ $reasonText }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 sm:gap-6">
            <article class="xl:col-span-1 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm">
                <p class="text-[11px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Tu estado actual</p>
                <div class="mt-3">
                    @if($currentPlan->code === 'admin_bypass')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800">Admin Bypass</span>
                    @elseif($isPremiumActive)
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">Premium Activo</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">Free</span>
                    @endif
                </div>

                <div class="mt-4 text-sm text-gray-600 dark:text-gray-300 space-y-2">
                    <p><span class="font-semibold text-gray-900 dark:text-white">Plan:</span> {{ $currentPlan->name }}</p>
                    <p>
                        <span class="font-semibold text-gray-900 dark:text-white">Simulaciones restantes:</span>
                        {{ $remainingSimulations === null ? 'Ilimitadas' : $remainingSimulations }}
                    </p>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PDF e impresión
                        </li>
                        <li class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Estadísticas avanzadas
                        </li>
                        <li class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Comparador de simulaciones
                        </li>
                        <li class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Exportación CSV personal
                        </li>
                    </ul>
                </div>
            </article>

            <div class="xl:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                <article class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Plan mensual</p>
                    <p class="mt-3 text-3xl font-black text-gray-900 dark:text-white">{{ $formatPrice($monthlyPlan) }}€<span class="text-sm font-semibold text-gray-500"> / mes</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ideal para empezar sin compromiso anual.</p>
                    <button type="button" class="mt-5 w-full py-2.5 px-4 rounded-xl bg-amber-600 text-white text-sm font-semibold opacity-80 cursor-not-allowed">
                        Activación manual por administrador
                    </button>
                </article>

                <article class="rounded-2xl border border-emerald-300/70 dark:border-emerald-700/50 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm relative overflow-hidden">
                    <span class="absolute top-3 right-3 px-2 py-1 rounded-md text-[10px] font-bold uppercase bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300">Ahorro anual</span>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Plan anual</p>
                    <p class="mt-3 text-3xl font-black text-gray-900 dark:text-white">{{ $formatPrice($yearlyPlan) }}€<span class="text-sm font-semibold text-gray-500"> / año</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pago anual recomendado para uso continuo.</p>
                    <button type="button" class="mt-5 w-full py-2.5 px-4 rounded-xl bg-emerald-600 text-white text-sm font-semibold opacity-80 cursor-not-allowed">
                        Activación manual por administrador
                    </button>
                </article>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Herramientas Premium</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Compara resultados y exporta tu histórico en CSV.</p>
                </div>
                @if($isPremiumActive)
                    <a href="{{ route('premium.export.csv') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white text-xs font-semibold hover:opacity-90 transition">
                        Exportar CSV
                    </a>
                @endif
            </div>

            @if($isPremiumActive)
                @if($userResultsForCompare->count() >= 2)
                    <form method="POST" action="{{ route('premium.compare') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="compare-results" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Selecciona 2-3 simulaciones</label>
                            <select id="compare-results" name="resultados[]" multiple size="6" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-800 dark:text-gray-100 p-3 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                @foreach($userResultsForCompare as $result)
                                    <option value="{{ $result->id_resultado }}" @selected(in_array((string) $result->id_resultado, array_map('strval', old('resultados', [])), true))>
                                        #{{ $result->id_resultado }} · {{ $result->ubicacion }} · {{ number_format($result->potencia_instalacion_kwp, 2) }} kWp
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Usa Ctrl/Cmd para selección múltiple.</p>
                            @error('resultados') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white text-sm font-semibold transition">
                            Comparar simulaciones
                        </button>
                    </form>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Necesitas al menos 2 simulaciones guardadas para usar el comparador.</p>
                @endif

                @if($comparisonResults->isNotEmpty())
                    <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-700 overflow-x-auto">
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
                @endif
            @else
                <div class="rounded-xl border border-dashed border-amber-300 dark:border-amber-700 bg-amber-50/60 dark:bg-amber-900/10 p-4">
                    <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Comparador y exportación bloqueados</p>
                    <p class="text-sm text-amber-700/90 dark:text-amber-300/90 mt-1">Activa Premium para comparar simulaciones y exportar tus resultados en CSV.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
