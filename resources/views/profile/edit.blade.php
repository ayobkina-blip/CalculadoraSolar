<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('Configuración del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- COLUMNA: NAVEGACIÓN Y LOGOUT (MANTENIDA) --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center text-amber-600 text-2xl font-black mb-4">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h4 class="text-sm font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">{{ Auth::user()->name }}</h4>
                            <p class="text-[10px] text-gray-400 font-mono mt-1">ID USUARIO: #{{ Auth::user()->id_usuario ?? Auth::id() }}</p>
                        </div>
                        
                        <div class="mt-8 space-y-2">
                            <div class="flex items-center justify-between text-[10px] font-bold uppercase text-gray-400 px-2">
                                <span>Estado</span>
                                <span class="text-emerald-500 italic text-[9px]">En línea</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-[100%]"></div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="mt-8">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 dark:bg-red-900/10 text-red-600 hover:bg-red-600 hover:text-white rounded-xl text-xs font-black uppercase tracking-[0.2em] transition-all border border-red-100 dark:border-red-900/30 group">
                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Cerrar Sesión') }}
                            </button>
                        </form>
                    </div>

                    <div class="bg-[#1e293b] rounded-2xl p-6 text-white shadow-lg">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60 mb-4 text-amber-400">Resumen de Actividad</p>
                    <div class="space-y-4">
                        <div class="flex justify-between items-end border-b border-slate-700 pb-2">
                            <span class="text-xs font-medium italic">Simulaciones</span>
                            {{-- Número real --}}
                            <span class="text-xl font-black font-mono">{{ $totalSimulaciones }}</span>
                        </div>
                        <div class="flex justify-between items-end border-b border-slate-700 pb-2">
                            <span class="text-xs font-medium italic">Ahorro Medio</span>
                            {{-- Ahorro real formateado --}}
                            <span class="text-xl font-black font-mono">{{ number_format($ahorroMedio, 0) }}€</span>
                        </div>
                    </div>
                </div>
                </div>

                {{-- COLUMNA DE FORMULARIOS + NUEVA SECCIÓN --}}
                <div class="lg:col-span-3 space-y-8">
                    
                    {{-- 1. Información de Perfil (Mantenido) --}}
                    <div class="p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- 2. NUEVA SECCIÓN: ESTADO TÉCNICO DE LA CUENTA (FUNCIONAL) --}}
                    <div class="p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                        <header class="mb-6">
                            <h3 class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-[0.15em] flex items-center gap-2">
                                <div class="w-1.5 h-4 bg-blue-500 rounded-full"></div>
                                {{ __('Seguridad y Conexión de Usuario') }}
                            </h3>
                            <p class="mt-2 text-[11px] text-gray-400 font-medium italic">
                                {{ __("Detalles técnicos de tu acceso actual al sistema.") }}
                            </p>
                        </header>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20">
                                <div class="p-2 bg-white dark:bg-gray-800 rounded-lg text-blue-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase">IP de Conexión</p>
                                    <p class="text-xs font-mono font-bold text-gray-700 dark:text-gray-200">{{ request()->ip() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 rounded-xl bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20">
                                <div class="p-2 bg-white dark:bg-gray-800 rounded-lg text-emerald-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase">Estado Cuenta</p>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Verificada</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Seguridad/Contraseña (Mantenido) --}}
                    <div class="p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- 4. Borrar Cuenta (Mantenido) --}}
                    <div class="p-8 bg-red-50/30 dark:bg-red-950/10 border border-red-100 dark:border-red-900/20 rounded-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>