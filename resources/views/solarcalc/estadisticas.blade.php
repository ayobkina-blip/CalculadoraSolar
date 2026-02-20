<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Métricas de Energía
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">SolarCalc · Algemesí, Valencia</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-8">

        {{-- ══════════════════════════════════════
             BLOQUE 1 — KPIs
        ══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">

            {{-- Radiación Media --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-amber-500 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 px-2 py-1 rounded-lg uppercase tracking-wide">Solar</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $radiacion ?? '1650' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">kWh/m² · Radiación media</p>
            </div>

            {{-- Comunidad Solar --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-blue-500 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-lg uppercase tracking-wide">Red</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $usuarios ?? '0' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Usuarios · Comunidad solar</p>
            </div>

            {{-- CO2 Evitado --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-lg uppercase tracking-wide">Eco</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-emerald-600 dark:text-emerald-400">
                    {{ number_format($co2 ?? 0, 2) }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Toneladas · CO₂ evitado</p>
            </div>

            {{-- Simulaciones totales --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-purple-500 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 px-2 py-1 rounded-lg uppercase tracking-wide">Total</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $totalPresupuestos ?? 0 }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Simulaciones realizadas</p>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             BLOQUE 2 — GRÁFICO DE ACTIVIDAD (condicional)
        ══════════════════════════════════════ --}}
        @if(isset($presupuestosPorDia) && $presupuestosPorDia->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Actividad Reciente</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Simulaciones de los últimos 30 días</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-amber-400 opacity-80"></span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Simulaciones / día</span>
                </div>
            </div>
            <div class="p-4 sm:p-6">
                <div class="relative w-full" style="height: 220px; min-height: 180px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════
             BLOQUE 3 — PRODUCCIÓN MENSUAL (gráfico principal)
        ══════════════════════════════════════ --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Producción Mensual Estimada</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Energía fotovoltaica generada en kWh</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Algemesí, Valencia</span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                {{-- Resumen compacto sobre el gráfico --}}
                <div class="grid grid-cols-3 gap-3 mb-5 sm:mb-6">
                    <div class="text-center">
                        <p class="text-lg sm:text-2xl font-bold text-amber-500">Jul</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium mt-0.5">Mes pico</p>
                    </div>
                    <div class="text-center border-x border-gray-100 dark:border-gray-700">
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">1.650</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium mt-0.5">kWh/m² año</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg sm:text-2xl font-bold text-emerald-500">+22%</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium mt-0.5">vs. media nacional</p>
                    </div>
                </div>

                <div class="relative w-full" style="height: 280px; min-height: 220px;">
                    <canvas id="solarChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             BLOQUE 4 — DATOS CONTEXTUALES
        ══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Localización</p>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Algemesí, Valencia</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">39.18° N · 0.44° W</p>
                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Zona climática</p>
                    <p class="text-sm font-bold text-amber-500 mt-0.5">Mediterráneo Csa</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Rendimiento</p>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Eficiencia óptima</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Inclinación recomendada 30°–35°</p>
                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Orientación ideal</p>
                    <p class="text-sm font-bold text-blue-500 mt-0.5">Sur · Azimut 180°</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ahorro estimado</p>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Por instalación media</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sistema de 5 kWp estándar</p>
                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Ahorro anual típico</p>
                    <p class="text-sm font-bold text-emerald-500 mt-0.5">700 – 1.100 €/año</p>
                </div>
            </div>
        </div>

    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Detección de modo oscuro ──────────────────────────────
            const isDark = () => document.documentElement.classList.contains('dark');
            const gridColor  = () => isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            const tickColor  = () => isDark() ? '#9ca3af' : '#6b7280';
            const tooltipBg  = 'rgba(15, 23, 42, 0.95)';

            // ── Gráfico principal: Producción mensual ─────────────────
            const solarCanvas = document.getElementById('solarChart');
            if (solarCanvas) {
                const ctx = solarCanvas.getContext('2d');

                const fallback   = [42, 58, 95, 148, 190, 225, 235, 210, 165, 108, 58, 38];
                const datosReales = @json($datosGrafico ?? []);
                const datos = datosReales.length > 0 && datosReales.every(d => d > 0) ? datosReales : fallback;

                const grad = ctx.createLinearGradient(0, 0, 0, solarCanvas.offsetHeight || 280);
                grad.addColorStop(0,   'rgba(245, 158, 11, 0.35)');
                grad.addColorStop(0.6, 'rgba(245, 158, 11, 0.10)');
                grad.addColorStop(1,   'rgba(245, 158, 11, 0)');

                const solarChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [{
                            label: 'Producción (kWh)',
                            data: datos,
                            borderColor: '#f59e0b',
                            backgroundColor: grad,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: isDark() ? '#1f2937' : '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#d97706',
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 8, bottom: 4, left: 4, right: 4 } },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: tooltipBg,
                                titleColor: '#f9fafb',
                                bodyColor: '#e5e7eb',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false,
                                callbacks: {
                                    title: ctx => ctx[0].label,
                                    label: ctx => '⚡ ' + ctx.parsed.y.toFixed(1) + ' kWh estimados',
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor(), drawBorder: false },
                                ticks: { font: { size: 11 }, color: tickColor(), padding: 8 },
                                border: { display: false }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { font: { size: 11, weight: '600' }, color: tickColor(), padding: 8 },
                                border: { display: false }
                            }
                        },
                        interaction: { intersect: false, mode: 'index' }
                    }
                });

                window.addEventListener('resize', () => solarChart.resize());

                // Actualizar colores al cambiar tema
                const observer = new MutationObserver(() => {
                    solarChart.options.scales.y.grid.color = gridColor();
                    solarChart.options.scales.y.ticks.color = tickColor();
                    solarChart.options.scales.x.ticks.color = tickColor();
                    solarChart.update('none');
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }

            // ── Gráfico de actividad (barras) ─────────────────────────
            @if(isset($presupuestosPorDia) && $presupuestosPorDia->count() > 0)
            const activityCanvas = document.getElementById('activityChart');
            if (activityCanvas) {
                const actCtx = activityCanvas.getContext('2d');
                const rawData = @json($presupuestosPorDia);

                const labels = rawData.map(item => {
                    const d = new Date(item.fecha + 'T00:00:00');
                    return d.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
                });
                const values = rawData.map(item => item.total);

                const barGrad = actCtx.createLinearGradient(0, 0, 0, activityCanvas.offsetHeight || 220);
                barGrad.addColorStop(0, 'rgba(245, 158, 11, 0.85)');
                barGrad.addColorStop(1, 'rgba(245, 158, 11, 0.35)');

                const actChart = new Chart(actCtx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Simulaciones',
                            data: values,
                            backgroundColor: barGrad,
                            borderColor: '#f59e0b',
                            borderWidth: 1.5,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 8, bottom: 4 } },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: tooltipBg,
                                titleColor: '#f9fafb',
                                bodyColor: '#e5e7eb',
                                padding: 10,
                                cornerRadius: 10,
                                displayColors: false,
                                callbacks: {
                                    label: ctx => ctx.parsed.y + ' simulación' + (ctx.parsed.y !== 1 ? 'es' : ''),
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: 11 }, color: tickColor(), padding: 6 },
                                grid: { color: gridColor(), drawBorder: false },
                                border: { display: false }
                            },
                            x: {
                                ticks: { font: { size: 10 }, color: tickColor(), maxRotation: 45 },
                                grid: { display: false, drawBorder: false },
                                border: { display: false }
                            }
                        }
                    }
                });

                window.addEventListener('resize', () => actChart.resize());

                const obs2 = new MutationObserver(() => {
                    actChart.options.scales.y.grid.color = gridColor();
                    actChart.options.scales.y.ticks.color = tickColor();
                    actChart.options.scales.x.ticks.color = tickColor();
                    actChart.update('none');
                });
                obs2.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }
            @endif
        });
    </script>
    @endpush

</x-app-layout>