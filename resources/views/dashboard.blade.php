<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                {{ __('Panel de Control Energético') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- SECCIÓN 1: IMPACTO AMBIENTAL --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all hover:shadow-md">
                    <div>
                        <p
                            class="text-emerald-600 dark:text-emerald-400 text-xs font-black uppercase tracking-widest mb-1">
                            CO2 Evitado Total</p>
                        <p class="text-4xl font-black text-gray-900 dark:text-white">
                            <span id="count-co2">0</span> <span class="text-lg font-normal text-gray-400">Tons</span>
                        </p>
                    </div>
                    <div class="bg-emerald-500/10 p-4 rounded-xl text-emerald-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all hover:shadow-md">
                    <div>
                        <p class="text-blue-600 dark:text-blue-400 text-xs font-black uppercase tracking-widest mb-1">
                            Equivalencia Forestal</p>
                        <p class="text-4xl font-black text-gray-900 dark:text-white">
                            <span id="count-arboles">0</span> <span
                                class="text-lg font-normal text-gray-400">Árboles</span>
                        </p>
                    </div>
                    <div class="bg-blue-500/10 p-4 rounded-xl text-blue-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2: INDICADORES RÁPIDOS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                    class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-slate-700 flex items-center gap-4">
                    <div id="count-conteo-bg" class="p-3 bg-amber-500/10 rounded-lg text-amber-600 font-bold text-xl">
                        <span id="count-conteo">0</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Cálculos Realizados
                        </p>
                        <p class="text-sm font-bold dark:text-gray-200 italic">Historial guardado</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-slate-700 flex items-center gap-4">
                    <div class="p-3 bg-green-500/10 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ahorro Estimado</p>
                        <p class="text-xl font-bold text-green-600"><span id="count-ahorro">0</span>€</p>
                    </div>
                </div>

                <a href="{{ route('solar.calculadora') }}"
                    class="bg-amber-500 hover:bg-amber-600 p-5 rounded-xl shadow-lg transition-all flex items-center justify-center gap-3 text-white group">
                    <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-bold uppercase tracking-wider text-sm">Nueva Simulación</span>
                </a>
            </div>

            {{-- SECCIÓN 3: GRÁFICOS Y ANALÍTICA --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <h3
                            class="text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <div class="w-1.5 h-4 bg-amber-500 rounded-full"></div>
                            Curva de Producción Estimada
                        </h3>
                        <span
                            class="text-[10px] font-mono text-gray-400 bg-gray-50 dark:bg-gray-900/50 px-2 py-0.5 rounded border border-gray-100 dark:border-gray-700">kWh/Mes</span>
                    </div>

                    <div class="h-64">
                        <canvas id="dashChart"></canvas>
                    </div>

                    <div
                        class="mt-8 pt-6 border-t border-gray-50 dark:border-gray-700/50 flex justify-between items-center text-center">
                        <div class="flex-1 border-r border-gray-100 dark:border-gray-700">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Pico Máximo
                            </p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Julio</p>
                            <p class="text-[11px] font-mono text-amber-500 font-bold">{{ max($datosGrafico) }} <span
                                    class="text-[9px]">kWh</span></p>
                        </div>
                        <div class="flex-1 border-r border-gray-100 dark:border-gray-700">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Piso Mínimo
                            </p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Diciembre</p>
                            <p class="text-[11px] font-mono text-blue-500 font-bold">{{ min($datosGrafico) }} <span
                                    class="text-[9px]">kWh</span></p>
                        </div>
                        <div class="flex-1">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Media Mensual
                            </p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200 italic">Estimada</p>
                            <p class="text-[11px] font-mono text-emerald-500 font-bold">
                                {{ number_format(array_sum($datosGrafico) / 12, 1) }} <span
                                    class="text-[9px]">kWh</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-4 sm:p-6 flex flex-col h-full">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Inversión Reciente
                    </h3>

                    @if($ultimo)
                    <div class="relative flex-1" style="min-height: 200px;">
                        <canvas id="costChart"></canvas>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div
                            class="flex justify-between items-center bg-gray-50 dark:bg-gray-900/50 px-4 py-3 rounded-xl border border-gray-100 dark:border-gray-800">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Retorno</span>
                            <span class="text-sm font-black text-amber-600">{{ $ultimo->roi_anyos }} <span
                                    class="text-[10px] font-normal">Años</span></span>
                        </div>
                        <div
                            class="flex justify-between items-center bg-gray-50 dark:bg-gray-900/50 px-4 py-3 rounded-xl border border-gray-100 dark:border-gray-800">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Paneles</span>
                            <span class="text-sm font-black dark:text-white">{{ $ultimo->paneles_sugeridos }} <span
                                    class="text-[10px] font-normal">Unidades</span></span>
                        </div>
                    </div>
                    @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center space-y-4 py-6">
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-full">
                            <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200">¿Cuánto podrías ahorrar?</p>
                            <p class="text-xs text-gray-400 mt-1 max-w-[180px] mx-auto">Calcula el coste de tu
                                instalación y el tiempo de recuperación.</p>
                        </div>
                        <a href="{{ route('solar.calculadora') }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition-colors">
                            Empezar cálculo
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- SECCIÓN 4: LISTADO ÚLTIMOS RESULTADOS --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div
                    class="p-4 sm:p-6 border-b border-gray-50 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-900/20 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Últimas
                        Simulaciones</h3>
                    <a href="{{ route('solar.presupuestos') }}"
                        class="text-[10px] font-black text-amber-600 hover:underline uppercase tracking-tighter">Ver
                        todo el historial</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($presupuestos as $pre)
                    <div
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 font-bold">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <p class="text-xs font-bold dark:text-white uppercase tracking-tighter">Ref: #{{
                                    $pre->id_resultado }}</p>
                                <p class="text-[10px] text-gray-400 font-mono">{{ $pre->potencia_instalacion_kwp }} kWp
                                    Instalados</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('solar.resultados', ['id' => $pre->id_resultado]) }}"
                                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-amber-500 hover:text-white rounded-lg text-xs font-bold transition-colors">
                                Detalles
                            </a>
                            <a href="{{ route('solar.pdf', $pre->id_resultado) }}"
                                class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center text-gray-400 italic text-sm">Empieza realizando tu primer cálculo.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- 1. LÓGICA DE COUNTUP ---
            const countOptions = {
                duration: 2.5,
                useEasing: true,
                separator: '.',
                decimal: ',',
            };

            const anims = [
                new countUp.CountUp('count-co2', {{ $co2 }}, { ...countOptions, decimalPlaces: 1 }),
            new countUp.CountUp('count-arboles', {{ $arboles }}, countOptions),
            new countUp.CountUp('count-conteo', {{ $conteo }}, countOptions),
            new countUp.CountUp('count-ahorro', {{ $ahorroTotal }}, { ...countOptions, decimalPlaces: 2 })
            ];

        anims.forEach(anim => {
            if (!anim.error) anim.start();
        });

        // --- 2. COLORES DINÁMICOS ---
        const getThemeColors = () => {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                text: isDark ? '#f8fafc' : '#475569',
                grid: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                tooltip: isDark ? '#334155' : '#1e293b',
                donutSystem: isDark ? '#1e293b' : '#f1f5f9'
            };
        };

        let colors = getThemeColors();

        // --- 3. GRÁFICO DE BARRAS ---
        const ctx1 = document.getElementById('dashChart').getContext('2d');
        const gradient = ctx1.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, '#f59e0b');
        gradient.addColorStop(1, 'rgba(251, 191, 36, 0.1)');

        const dashChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Producción',
                    data: @json($datosGrafico),
                    backgroundColor: gradient,
                    borderColor: '#d97706',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: colors.tooltip }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: colors.grid, drawBorder: false },
                        ticks: { color: colors.text, font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: colors.text, font: { size: 10, weight: '600' } }
                    }
                }
            }
        });

        // --- 4. GRÁFICO DE DONA ---
        let costChart;
        @if ($ultimo)
            const ctx2 = document.getElementById('costChart').getContext('2d');
        costChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Paneles', 'Sistema'],
                datasets: [{
                    data: @json($repartoCostes),
                    backgroundColor: ['#f59e0b', colors.donutSystem],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: colors.text,
                            usePointStyle: true,
                            font: { size: 10, weight: 'bold' }
                        }
                    }
                }
            }
        });
        @endif

        // --- 5. OBSERVADOR PARA CAMBIO DE TEMA ---
        const observer = new MutationObserver(() => {
            const newColors = getThemeColors();
            dashChart.options.scales.y.grid.color = newColors.grid;
            dashChart.options.scales.y.ticks.color = newColors.text;
            dashChart.options.scales.x.ticks.color = newColors.text;
            dashChart.update();

            if (costChart) {
                costChart.data.datasets[0].backgroundColor[1] = newColors.donutSystem;
                costChart.options.plugins.legend.labels.color = newColors.text;
                costChart.update();
            }
        });

        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
    @endpush
</x-app-layout>