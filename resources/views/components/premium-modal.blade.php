<div x-data="{
    open: @js($showPremiumModal ?? false),
    reason: @js($premiumModalReason ?? null),
    init() {
        this.$watch('open', (value) => {
            document.body.style.overflow = value ? 'hidden' : '';
        });
        
        window.addEventListener('open-premium-modal', (event) => {
            this.reason = event.detail.reason;
            this.open = true;
        });
    }
}" 
x-show="open" 
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="fixed inset-0 z-50 overflow-y-auto"
style="display: none;">
    
    {{-- OVERLAY --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         @click.self="open = false"
         style="background: rgba(0,0,0,0.65); backdrop-filter: blur(4px);">

        {{-- PANEL --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white dark:bg-gray-900 shadow-2xl ring-1 ring-black/10 dark:ring-white/10">

            {{-- CABECERA CON GRADIENTE --}}
            <div class="relative overflow-hidden rounded-t-3xl bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600 px-6 pt-6 pb-8">
                {{-- Decoración de fondo --}}
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/30"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-full bg-white/20"></div>
                </div>

                {{-- Botón cerrar --}}
                <button @click="open = false"
                        class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-6 h-6 rounded-lg bg-white/25 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest text-white/80">SolarCalc Premium</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                        Desbloquea el potencial<br>completo de tu instalación
                    </h2>
                    <p class="mt-1.5 text-sm text-white/75">Simulaciones ilimitadas, informes PDF, estadísticas y mucho más.</p>
                </div>

                {{-- Banner de razón bloqueada --}}
                @php
                    $reasonMessages = [
                        'pdf_export' => 'Necesitas Premium para descargar informes PDF.',
                        'result_compare' => 'El comparador de simulaciones es exclusivo Premium.',
                        'csv_export' => 'La exportación CSV está disponible solo para usuarios Premium.',
                        'simulation_quota' => 'Has alcanzado tu límite de simulaciones. Actualiza a Premium para continuar.',
                    ];
                @endphp
                @if($premiumModalReason && isset($reasonMessages[$premiumModalReason]))
                    <div class="relative mt-4 flex items-start gap-2.5 rounded-xl bg-black/20 px-4 py-3">
                        <svg class="w-4 h-4 text-white/90 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <p class="text-sm text-white/90 font-medium">{{ $reasonMessages[$premiumModalReason] }}</p>
                    </div>
                @endif
            </div>

            {{-- CUERPO --}}
            <div class="px-5 sm:px-6 py-6 space-y-5">

                {{-- TARJETAS DE PLANES --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Plan Mensual --}}
                    <div class="relative rounded-2xl border border-gray-200 dark:border-gray-700 p-5 bg-gray-50 dark:bg-gray-800/60 hover:border-amber-400 dark:hover:border-amber-500 transition-colors group">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Plan Mensual</p>
                        <div class="mt-2 flex items-end gap-1">
                            <span class="text-4xl font-black text-gray-900 dark:text-white">{{ number_format(($monthlyPlan?->price_cents ?? 0) / 100, 2, ',', '.') }}€</span>
                            <span class="text-sm text-gray-400 mb-1.5">/mes</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sin compromiso. Cancela cuando quieras.</p>

                        @if(!$isPremiumActive)
                            <a href="{{ route('subscription.checkout', 'premium_monthly') }}"
                               class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold transition group-hover:shadow-md group-hover:shadow-amber-500/30">
                                Contratar
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-400 text-sm font-semibold cursor-not-allowed">
                                Plan activo ✓
                            </div>
                        @endif
                    </div>

                    {{-- Plan Anual (destacado) --}}
                    <div class="relative rounded-2xl border-2 border-emerald-400 dark:border-emerald-500 p-5 bg-emerald-50 dark:bg-emerald-900/20 shadow-lg shadow-emerald-500/10">
                        {{-- Badge recomendado --}}
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500 text-white text-[10px] font-black uppercase tracking-wider shadow-md">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Recomendado
                            </span>
                        </div>

                        <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mt-1">Plan Anual</p>
                        <div class="mt-2 flex items-end gap-1">
                            <span class="text-4xl font-black text-gray-900 dark:text-white">{{ number_format(($yearlyPlan?->price_cents ?? 0) / 100, 2, ',', '.') }}€</span>
                            <span class="text-sm text-gray-400 mb-1.5">/año</span>
                        </div>

                        @php
                            $mensualEquiv = ($yearlyPlan?->price_cents ?? 0) / 12 / 100;
                            $ahorro = (($monthlyPlan?->price_cents ?? 0) * 12 - ($yearlyPlan?->price_cents ?? 0)) / 100;
                        @endphp
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-1 font-semibold">
                            {{ number_format($mensualEquiv, 2, ',', '.') }}€/mes · Ahorras {{ number_format($ahorro, 2, ',', '.') }}€
                        </p>

                        @if(!$isPremiumActive)
                            <a href="{{ route('subscription.checkout', 'premium_yearly') }}"
                               class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold transition shadow-md shadow-emerald-500/30 hover:shadow-emerald-500/50">
                                Contratar anual
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <div class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl bg-emerald-200 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm font-semibold cursor-not-allowed">
                                Plan activo ✓
                            </div>
                        @endif
                    </div>
                </div>

                {{-- FEATURES incluidas --}}
                <div class="rounded-2xl bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700/60 px-5 py-4">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Todo incluido en Premium</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach([
                            ['icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'label' => 'Descarga de informes PDF'],
                            ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'label' => 'Estadísticas avanzadas'],
                            ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label' => 'Comparador de simulaciones'],
                            ['icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Exportación CSV'],
                            ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Simulaciones ilimitadas'],
                            ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Soporte prioritario'],
                        ] as $feature)
                            <div class="flex items-center gap-2.5">
                                <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ESTADO ACTUAL DEL USUARIO --}}
                <div class="flex items-center justify-between rounded-xl px-4 py-3 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white text-xs">{{ $currentPlan->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $remainingSimulations === null ? 'Simulaciones ilimitadas' : $remainingSimulations . ' simulaciones restantes' }}
                            </p>
                        </div>
                    </div>
                    @if($isPremiumActive)
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700">
                            Premium ✓
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                            Free
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
