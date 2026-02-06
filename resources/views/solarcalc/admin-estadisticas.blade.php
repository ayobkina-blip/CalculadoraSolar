<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            {{ __('Panel de Estadísticas Administrativas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- KPIS PRINCIPALES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Usuarios</p>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalUsuarios }}</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Presupuestos</p>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalPresupuestos }}</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Producción Total</p>
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-slate-900 dark:text-white">
                        {{ number_format($totalKwh / 1000, 1) }} <span class="text-sm font-normal text-slate-400">MWh</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ahorro Total</p>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-green-600">
                        {{ number_format($ahorroTotal, 0) }} <span class="text-sm font-normal text-slate-400">€</span>
                    </p>
                </div>
            </div>

            {{-- GRÁFICOS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Presupuestos por Estado --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider mb-6">Distribución por Estado</h3>
                    <div class="h-64">
                        <canvas id="estadoChart"></canvas>
                    </div>
                </div>

                {{-- Actividad Reciente --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider mb-6">Actividad (Últimos 30 días)</h3>
                    <div class="h-64">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- TOP USUARIOS --}}
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider mb-6">Top 5 Usuarios Más Activos</h3>
                <div class="space-y-4">
                    @forelse($topUsuarios as $index => $usuario)
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-black">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $usuario->nombre }}</p>
                                <p class="text-xs text-slate-400">{{ $usuario->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-amber-600">{{ $usuario->resultados_count }}</p>
                            <p class="text-xs text-slate-400">simulaciones</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-8">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>

            {{-- MÉTRICAS ADICIONALES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ahorro Promedio</p>
                    <p class="text-2xl font-black text-green-600">
                        {{ number_format($ahorroPromedio ?? 0, 2) }} <span class="text-sm font-normal text-slate-400">€/año</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">CO2 Evitado</p>
                    <p class="text-2xl font-black text-emerald-600">
                        {{ number_format(($totalKwh * 0.25) / 1000, 2) }} <span class="text-sm font-normal text-slate-400">Tons</span>
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Promedio por Usuario</p>
                    <p class="text-2xl font-black text-blue-600">
                        {{ $totalUsuarios > 0 ? number_format($totalPresupuestos / $totalUsuarios, 1) : 0 }} <span class="text-sm font-normal text-slate-400">simulaciones</span>
                    </p>
                </div>
            </div>

        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de estados
            const estadoCtx = document.getElementById('estadoChart');
            const estadoData = @json($porEstado);
            new Chart(estadoCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(estadoData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
                    datasets: [{
                        data: Object.values(estadoData),
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.8)', // pendiente
                            'rgba(16, 185, 129, 0.8)', // aprobado
                            'rgba(244, 63, 94, 0.8)'   // rechazado
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Gráfico de actividad
            const activityCtx = document.getElementById('activityChart');
            const activityData = @json($presupuestosPorDia);
            const labels = activityData.map(item => {
                const date = new Date(item.fecha);
                return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
            });
            const values = activityData.map(item => item.total);
            
            new Chart(activityCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Simulaciones',
                        data: values,
                        backgroundColor: 'rgba(245, 158, 11, 0.6)',
                        borderColor: '#f59e0b',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
