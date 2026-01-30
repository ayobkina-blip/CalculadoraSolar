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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Radiación Media</p>
                    <p class="text-3xl font-bold mt-2 dark:text-white text-center">
                        {{ $radiacion ?? '1650' }} <span class="text-sm font-normal text-gray-400">kWh/m²</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Comunidad Solar</p>
                    <p class="text-3xl font-bold mt-2 dark:text-white text-center">
                        {{ $usuarios ?? '0' }} <span class="text-sm font-normal text-gray-400">perfiles</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl transition-transform hover:scale-[1.02]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">CO2 Evitado</p>
                    <p class="text-3xl font-bold mt-2 text-green-600 text-center">
                        {{ $co2 ?? '0' }} <span class="text-sm font-normal text-gray-400">Tons</span>
                    </p>
                </div>
            </div>
            
            {{-- 2. SECCIÓN DEL GRÁFICO --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Producción Mensual Estimada (kWh)</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">Algemesí, Valencia</span>
                    </div>
                </div>
                
                <div class="h-80 w-full">
                    <canvas id="solarChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('solarChart').getContext('2d');
            
            // Datos de respaldo y lógica de carga
            const datosFalsos = [10, 15, 25, 45, 60, 80, 85, 70, 50, 30, 15, 10];
            const datosReales = @json($datosGrafico ?? []);
            
            // Configuración del gradiente
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
            gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Producción (kWh)',
                        data: datosReales.length > 0 ? datosReales : datosFalsos,
                        borderColor: '#f59e0b',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#f59e0b',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 12, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(156, 163, 175, 0.1)' },
                            ticks: { font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>