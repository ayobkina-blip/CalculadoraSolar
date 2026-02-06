<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            {{ __('Estadísticas de Energía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. GRID DE INDICADORES --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Radiación Media</p>
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold dark:text-white">
                        {{ $radiacion ?? '1650' }} <span class="text-sm font-normal text-gray-400">kWh/m²</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Comunidad Solar</p>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold dark:text-white">
                        {{ $usuarios ?? '0' }} <span class="text-sm font-normal text-gray-400">usuarios</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">CO2 Evitado</p>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-green-600">
                        {{ number_format($co2 ?? 0, 2) }} <span class="text-sm font-normal text-gray-400">Tons</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Simulaciones</p>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold dark:text-white">
                        {{ $totalPresupuestos ?? 0 }} <span class="text-sm font-normal text-gray-400">total</span>
                    </p>
                </div>
            </div>
            
            @if(isset($presupuestosPorDia) && $presupuestosPorDia->count() > 0)
            {{-- GRÁFICO DE ACTIVIDAD RECIENTE --}}
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl mb-6 md:mb-8">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 md:mb-6">Actividad de Simulaciones (Últimos 30 días)</h3>
                <div class="relative w-full" style="height: 250px; min-height: 200px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
            @endif
            
            {{-- 2. SECCIÓN DEL GRÁFICO --}}
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Producción Mensual Estimada (kWh)</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">Algemesí, Valencia</span>
                    </div>
                </div>
                
                <div class="relative w-full" style="height: 320px; min-height: 300px;">
                    <canvas id="solarChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('solarChart');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            
            // Datos de respaldo y lógica de carga
            const datosFalsos = [10, 15, 25, 45, 60, 80, 85, 70, 50, 30, 15, 10];
            const datosReales = @json($datosGrafico ?? []);
            const datosFinales = datosReales.length > 0 && datosReales.every(d => d > 0) ? datosReales : datosFalsos;
            
            // Configuración del gradiente
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
            gradient.addColorStop(0.5, 'rgba(245, 158, 11, 0.2)');
            gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Producción (kWh)',
                        data: datosFinales,
                        borderColor: '#f59e0b',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#d97706',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            left: 10,
                            right: 10
                        }
                    },
                    plugins: {
                        legend: { 
                            display: false 
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: { 
                                size: 13, 
                                weight: 'bold' 
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(2) + ' kWh';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { 
                                color: 'rgba(156, 163, 175, 0.1)',
                                drawBorder: false
                            },
                            ticks: { 
                                font: { size: 11 },
                                color: '#6b7280',
                                padding: 8
                            }
                        },
                        x: {
                            grid: { 
                                display: false,
                                drawBorder: false
                            },
                            ticks: { 
                                font: { size: 11, weight: '600' },
                                color: '#6b7280',
                                padding: 8
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
            
            // Ajustar gráfico al redimensionar ventana
            window.addEventListener('resize', function() {
                chart.resize();
            });
            
            @if(isset($presupuestosPorDia) && $presupuestosPorDia->count() > 0)
            // Gráfico de actividad
            const activityCanvas = document.getElementById('activityChart');
            if (activityCanvas) {
                const activityCtx = activityCanvas.getContext('2d');
                const activityData = @json($presupuestosPorDia);
                const labels = activityData.map(item => {
                    const date = new Date(item.fecha + 'T00:00:00');
                    return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
                });
                const values = activityData.map(item => item.total);
                
                const activityGradient = activityCtx.createLinearGradient(0, 0, 0, activityCanvas.height);
                activityGradient.addColorStop(0, 'rgba(245, 158, 11, 0.8)');
                activityGradient.addColorStop(1, 'rgba(245, 158, 11, 0.4)');
                
                new Chart(activityCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Simulaciones',
                            data: values,
                            backgroundColor: activityGradient,
                            borderColor: '#f59e0b',
                            borderWidth: 2,
                            borderRadius: 6,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(30, 41, 59, 0.95)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                cornerRadius: 6
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    stepSize: 1,
                                    font: { size: 11 },
                                    color: '#6b7280'
                                },
                                grid: {
                                    color: 'rgba(156, 163, 175, 0.1)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    font: { size: 10 },
                                    color: '#6b7280'
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });
            }
            @endif
        });
    </script>
    @endpush
</x-app-layout>