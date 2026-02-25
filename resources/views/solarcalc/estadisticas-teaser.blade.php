<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Métricas avanzadas
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Vista previa bloqueada para cuentas Free</p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        <section class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Desbloquea panel completo</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Con Premium tendrás estadísticas avanzadas, comparador entre simulaciones y exportación CSV.</p>

            <div class="mt-5 text-sm text-gray-700 dark:text-gray-300 space-y-2">
                <p><span class="font-semibold">Plan actual:</span> {{ $currentPlan->name }}</p>
                <p><span class="font-semibold">Simulaciones restantes:</span> {{ $remainingSimulations === null ? 'Ilimitadas' : $remainingSimulations }}</p>
            </div>

            <a href="{{ route('premium.index', ['reason' => 'advanced_stats']) }}" class="mt-6 inline-flex items-center justify-center px-5 py-3 rounded-xl bg-amber-600 hover:bg-amber-500 text-white text-sm font-semibold transition">
                Ver planes premium
            </a>
        </section>

        <section class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/40 to-white dark:via-gray-800/50 dark:to-gray-800"></div>
            <div class="blur-[2px]">
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-700/40 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-500">Producción total</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-slate-100 mt-2">126,440 kWh</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-700/40 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-500">CO2 evitado</p>
                        <p class="text-2xl font-black text-emerald-600 mt-2">31.6 t</p>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 dark:bg-slate-700/40 p-4 mt-4 h-40"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="px-4 py-2 rounded-lg text-xs font-bold uppercase bg-slate-900 text-white">Contenido Premium</span>
            </div>
        </section>
    </div>
</x-app-layout>
