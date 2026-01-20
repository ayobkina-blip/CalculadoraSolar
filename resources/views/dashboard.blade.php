<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                {{-- Icono Principal Dashboard --}}
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                {{ __('Centro de Control Energético') }}
            </h2>
            <span class="text-xs font-mono text-gray-500 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">
                USER_ID: #{{ Auth::user()->id_usuario }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. Fila de Indicadores Rápidos con Iconos --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Card: Simulaciones --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Simulaciones</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $conteo }}</p>
                    </div>
                </div>

                {{-- Card: Ahorro --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ahorro Total</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($ahorroTotal, 2) }}€</p>
                    </div>
                </div>

                {{-- Card: Status --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sistema</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase">Online</span>
                        </div>
                    </div>
                </div>

                {{-- Botón: Nueva Simulación --}}
                <a href="{{ route('solar.calculadora') }}" class="bg-amber-500 hover:bg-amber-600 p-5 rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center justify-center gap-3 text-white group">
                    <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-xs font-bold uppercase tracking-widest">Nuevo Cálculo</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- 2. Gráfico con Icono --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Rendimiento Mensual
                        </h3>
                    </div>
                    <div class="p-6 h-72">
                        <canvas id="dashChart"></canvas>
                    </div>
                </div>

                {{-- 3. Historial con Iconos --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20">
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Últimos Análisis
                        </h3>
                    </div>
                    <div class="flex-grow divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($presupuestos as $pre)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition flex justify-between items-center group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 text-[10px] font-bold">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold dark:text-white uppercase tracking-tighter">REF-{{ $pre->id_resultado }}</p>
                                    <p class="text-[9px] text-gray-400 font-mono">{{ $pre->potencia_instalacion_kwp }} kWp</p>
                                </div>
                            </div>
                            <a href="{{ route('solar.resultados', ['id' => $pre->id_resultado]) }}" class="opacity-0 group-hover:opacity-100 transition-opacity p-2 text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                        @empty
                        <div class="p-10 text-center">
                            <p class="text-xs text-gray-400 italic">No hay datos registrados.</p>
                        </div>
                        @endforelse
                    </div>
                    <a href="{{ route('solar.presupuestos') }}" class="p-4 bg-gray-50 dark:bg-gray-900/50 text-center text-[10px] font-black text-gray-400 uppercase hover:text-amber-600 transition border-t border-gray-100 dark:border-gray-700">
                        Ver Historial Completo
                    </a>
                </div>
            </div>

        </div>
    </div>
    
    {{-- Mismo Script de Chart.js --}}
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('dashChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['E', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
                    datasets: [{
                        data: @json($datosGrafico),
                        backgroundColor: '#f59e0b',
                        borderRadius: 4,
                        hoverBackgroundColor: '#d97706'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { grid: { display: false }, border: { display: false } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>