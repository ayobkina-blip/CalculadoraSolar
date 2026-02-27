<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Mi Perfil
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gestiona tu información personal y preferencias</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 md:py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8">
                
                {{-- COLUMNA IZQUIERDA: TARJETA DE IDENTIDAD --}}
                <div class="md:col-span-4 lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl md:rounded-[2.5rem] border-t-4 border-blue-900 border-x border-b border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm overflow-hidden relative group">
                        {{-- Decoración sutil --}}
                        <div class="absolute -top-20 -right-20 sm:-top-24 sm:-right-24 w-40 h-40 sm:w-48 sm:h-48 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            {{-- Avatar dinámico --}}
                            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-2xl sm:rounded-3xl flex items-center justify-center text-slate-400 text-2xl sm:text-3xl font-black mb-4 sm:mb-5 border border-white dark:border-slate-700 shadow-xl overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                                @endif
                            </div>
                            
                            <h4 class="text-base sm:text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ Auth::user()->nombre }}</h4>
                            <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/50">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                Cuenta Activa
                            </span>
                        </div>
                        
                        <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-slate-100 dark:border-slate-800 space-y-5 sm:space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Cálculos Totales</span>
                                    <span class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white leading-tight">{{ $totalSimulaciones ?? '0' }}</span>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-50 dark:bg-slate-800 rounded-xl sm:rounded-2xl flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Ahorro Medio</span>
                                    <span class="text-xl sm:text-2xl font-black text-amber-500 leading-tight">{{ number_format($ahorroMedio ?? 0, 0) }}€</span>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-50 dark:bg-amber-900/20 rounded-xl sm:rounded-2xl flex items-center justify-center text-amber-500">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 sm:mt-8">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-3 sm:py-4 bg-slate-900 dark:bg-white dark:text-slate-900 text-white text-xs sm:text-[10px] font-black uppercase tracking-wider sm:tracking-[0.2em] rounded-xl sm:rounded-2xl shadow-xl hover:scale-[1.02] active:scale-95 transition-all">
                                    Desconectar Sistema
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: CONFIGURACIÓN --}}
                <div class="md:col-span-8 lg:col-span-8 space-y-6 md:space-y-8">
                    
                    {{-- Información Básica --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl md:rounded-[2.5rem] p-6 sm:p-8 md:p-10 border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-slate-300 dark:hover:border-slate-700">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Seguridad --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl md:rounded-[2.5rem] p-6 sm:p-8 md:p-10 border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-slate-300 dark:hover:border-slate-700">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Gestión de Suscripción --}}
                    <section class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Mi suscripción</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gestiona tu plan activo.</p>

                        <div class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                            <p><span class="font-semibold text-gray-900 dark:text-white">Plan actual:</span> {{ $currentPlan->name }}</p>

                            @if($activeSubscription)
                                <p><span class="font-semibold text-gray-900 dark:text-white">Renovación:</span>
                                    {{ $activeSubscription->ends_at?->format('d/m/Y') ?? 'Sin fecha límite' }}
                                </p>
                                <p><span class="font-semibold text-gray-900 dark:text-white">Origen:</span>
                                    {{ $activeSubscription->source === 'self_service' ? 'Contratado por ti' : 'Asignado por administrador' }}
                                </p>
                            @endif
                        </div>

                        @if($isPremiumActive && $activeSubscription?->source === 'self_service')
                            <div x-data="{ confirming: false }" class="mt-5">
                                <button type="button" @click="confirming = true"
                                        class="text-sm font-semibold text-red-600 dark:text-red-400 hover:underline">
                                    Cancelar suscripción
                                </button>
                                <div x-show="confirming" x-transition
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                                     @keydown.escape.window="confirming = false">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-sm w-full mx-4 shadow-xl">
                                        <p class="font-semibold text-gray-900 dark:text-white">¿Cancelar tu suscripción?</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Perderás acceso a las funciones premium inmediatamente.
                                        </p>
                                        <div class="flex gap-3 mt-5">
                                            <button @click="confirming = false"
                                                    class="flex-1 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Volver
                                            </button>
                                            <form method="POST" action="{{ route('subscription.cancel') }}" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white text-sm font-semibold transition">
                                                    Sí, cancelar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($isPremiumActive)
                            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                                Tu plan fue asignado por un administrador. Contacta con soporte para cancelarlo.
                            </p>
                        @else
                            <button type="button"
                                    @click="window.dispatchEvent(new CustomEvent('open-premium-modal', { detail: { reason: 'simulation_quota' } }))"
                                    class="mt-4 inline-flex items-center text-sm font-semibold text-amber-600 dark:text-amber-400 hover:underline">
                                Ver planes disponibles →
                            </button>
                        @endif
                    </section>

                    {{-- ZONA DE PELIGRO --}}
                    <div class="bg-rose-50/50 dark:bg-rose-950/10 rounded-2xl md:rounded-[2.5rem] border-2 border-dashed border-rose-200 dark:border-rose-900/30 overflow-hidden">
                        <div class="p-6 sm:p-8 md:p-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>