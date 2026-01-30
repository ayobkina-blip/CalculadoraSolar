<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight flex items-center gap-3">
            <div class="p-2 bg-amber-500/10 rounded-lg">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" stroke-width="2"/>
                </svg>
            </div>
            {{ __('Centro de Identidad y Seguridad') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- COLUMNA IZQUIERDA: TARJETA DE IDENTIDAD --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-8 shadow-sm overflow-hidden relative group">
                        {{-- Decoración sutil --}}
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-3xl flex items-center justify-center text-slate-400 text-3xl font-black mb-5 border border-white dark:border-slate-700 shadow-xl">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h4 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ Auth::user()->name }}</h4>
                            <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/50">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                Cuenta Activa
                            </span>
                        </div>
                        
                        <div class="mt-10 pt-8 border-t border-slate-100 dark:border-slate-800 space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Calculos Totales</span>
                                    <span class="text-2xl font-black text-slate-900 dark:text-white leading-tight mt-1">{{ $totalSimulaciones ?? '0' }}</span>
                                </div>
                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ahorro Generado</span>
                                    <span class="text-2xl font-black text-amber-500 leading-tight mt-1">{{ number_format($ahorroMedio ?? 0, 0) }}€</span>
                                </div>
                                <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-slate-900 dark:bg-white dark:text-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:scale-[1.02] active:scale-95 transition-all">
                                    Desconectar Sistema
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: CONFIGURACIÓN --}}
                <div class="lg:col-span-8 space-y-8">
                    
                    {{-- Información Básica --}}
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-slate-300 dark:hover:border-slate-700">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Seguridad --}}
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-slate-300 dark:hover:border-slate-700">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- ZONA DE PELIGRO: Modal integrado --}}
                    <div class="bg-rose-50/50 dark:bg-rose-950/10 rounded-[2.5rem] border-2 border-dashed border-rose-200 dark:border-rose-900/30 overflow-hidden">
                        <div class="p-8 sm:p-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>