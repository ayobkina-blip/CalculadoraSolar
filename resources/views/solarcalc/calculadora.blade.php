{{-- Mejoras: diseño unificado, buscador/mapa robusto con vanilla JS, accesibilidad, persistencia old(), responsive. --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Calculadora Fotovoltaica
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Introduce tu ubicación y parámetros para calcular tu instalación solar</p>
            </div>
        </div>
    </x-slot>

    @if(!$isPremiumActive)
    <div class="mb-6 rounded-2xl overflow-hidden border border-amber-200/70 dark:border-amber-700/40">
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 px-5 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-200">Plan Gratuito</p>
                        <p class="text-xs text-amber-700/80 dark:text-amber-300/80 mt-0.5">
                            Te quedan <span class="font-black text-amber-700 dark:text-amber-300">{{ $remainingSimulations }}</span> de 3 simulaciones gratuitas
                        </p>
                    </div>
                </div>
                <button type="button"
                        @click="window.dispatchEvent(new CustomEvent('open-premium-modal', { detail: { reason: 'simulation_quota' } }))"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold transition shadow-sm shadow-amber-500/20">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Ver Premium
                </button>
            </div>

            @php $usadas = 3 - ($remainingSimulations ?? 0); @endphp
            <div class="mt-3 flex items-center gap-2">
                <div class="flex-1 h-1.5 rounded-full bg-amber-200 dark:bg-amber-800/60 overflow-hidden">
                    <div class="h-full rounded-full bg-amber-500 transition-all"
                         style="width: {{ ($usadas / 3) * 100 }}%"></div>
                </div>
                <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 whitespace-nowrap">{{ $usadas }}/3 usadas</span>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-300 mb-1.5">Corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('solar.procesar') }}" method="POST">
        @csrf

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">
            <div class="lg:flex-[3] flex-1 min-w-0 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col min-h-[560px] lg:min-h-[720px]">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between gap-3 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-gray-700 dark:text-gray-300">Ubicación</p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5 font-medium">Selecciona tu zona de instalación</p>
                        </div>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Mapa activo
                    </span>
                </div>

                <div class="px-5 sm:px-6 pt-4 pb-3 shrink-0 border-b border-gray-100 dark:border-gray-700/50">
                    <div class="relative" id="search-wrapper">
                        <input type="text" id="buscador-direccion" autocomplete="off"
                               placeholder="Busca tu ciudad o dirección en España..."
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/60 px-4 py-3 pl-10 pr-10 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent focus:bg-white dark:focus:bg-gray-900 transition">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <svg id="search-spinner" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        <div id="search-dropdown"
                             class="hidden absolute z-[9999] w-full mt-1.5 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden"></div>
                    </div>

                    <div class="flex items-center justify-between mt-2 min-h-[20px]">
                        <p id="search-feedback" class="text-[11px] text-gray-400 dark:text-gray-500"></p>
                        <div id="coords-indicator" class="hidden items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span id="coords-text"></span>
                        </div>
                    </div>
                </div>

                <div class="map-container mx-5 sm:mx-6 my-4 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shrink-0 lg:flex-1">
                    <div id="main-map" style="width:100%;height:100%;"></div>
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 pointer-events-none">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-900/75 backdrop-blur-sm text-white text-[10px] font-medium whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
                            </svg>
                            Clic o arrastra el marcador para ajustar
                        </div>
                    </div>
                </div>

                <input type="hidden" name="latitud"   id="latitud"   value="{{ old('latitud',   '39.1867') }}">
                <input type="hidden" name="longitud"  id="longitud"  value="{{ old('longitud',  '-0.4367') }}">
                <input type="hidden" name="provincia" id="provincia" value="{{ old('provincia', 'valencia') }}">
            </div>

            <div class="w-full lg:w-[400px] xl:w-[420px] bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col"
                 x-data="{ consumo: {{ old('consumo', 350) }}, superficie: {{ old('superficie', 40) }} }">

                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-gray-700 dark:text-gray-300">Parámetros técnicos</p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5 font-medium">Ajusta los datos de tu instalación</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 px-5 sm:px-6 py-5 space-y-5 overflow-y-auto">
                    <div class="rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <label for="input-consumo" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Consumo mensual</label>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-black"
                                  x-text="consumo + ' kWh'"></span>
                        </div>
                        <input type="range" x-model="consumo" min="50" max="2500" step="10"
                               class="w-full h-2 rounded-lg cursor-pointer accent-amber-500 bg-gray-200 dark:bg-gray-700">
                        <div class="flex justify-between text-[10px] text-gray-400 dark:text-gray-500 mt-1.5 font-medium">
                            <span>50 kWh</span><span>2.500 kWh</span>
                        </div>
                        <input type="number" name="consumo" id="input-consumo" x-model="consumo" min="50" max="10000"
                               class="mt-3 w-full rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                    </div>

                    <div class="rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                </div>
                                <label for="input-superficie" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Superficie disponible</label>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-black"
                                  x-text="superficie + ' m²'"></span>
                        </div>
                        <input type="range" x-model="superficie" min="10" max="1000" step="5"
                               class="w-full h-2 rounded-lg cursor-pointer accent-blue-500 bg-gray-200 dark:bg-gray-700">
                        <div class="flex justify-between text-[10px] text-gray-400 dark:text-gray-500 mt-1.5 font-medium">
                            <span>10 m²</span><span>1.000 m²</span>
                        </div>
                        <input type="number" name="superficie" id="input-superficie" x-model="superficie" min="10" max="10000"
                               class="mt-3 w-full rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 p-4">
                            <div class="flex items-center gap-2 mb-2.5">
                                <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <label for="input-orientacion" class="text-xs font-semibold text-gray-700 dark:text-gray-300">Orientación</label>
                            </div>
                            <select name="orientacion" id="input-orientacion"
                                    class="w-full rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-2.5 py-2 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition cursor-pointer">
                                <option value="0"   {{ (string) old('orientacion', 0) === '0'   ? 'selected' : '' }}>⭐ Sur</option>
                                <option value="-45" {{ (string) old('orientacion') === '-45'    ? 'selected' : '' }}>Sureste</option>
                                <option value="45"  {{ (string) old('orientacion') === '45'     ? 'selected' : '' }}>Suroeste</option>
                                <option value="-90" {{ (string) old('orientacion') === '-90'    ? 'selected' : '' }}>Este</option>
                                <option value="90"  {{ (string) old('orientacion') === '90'     ? 'selected' : '' }}>Oeste</option>
                            </select>
                        </div>

                        <div class="rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 p-4">
                            <div class="flex items-center gap-2 mb-2.5">
                                <div class="w-6 h-6 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <label for="input-inclinacion" class="text-xs font-semibold text-gray-700 dark:text-gray-300">Inclinación</label>
                            </div>
                            <input type="number" name="inclinacion" id="input-inclinacion"
                                   value="{{ old('inclinacion', 30) }}" min="0" max="90"
                                   class="w-full rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-2.5 py-2 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <p class="text-[10px] text-gray-400 mt-1.5">0°–90° (rec: 30°)</p>
                        </div>
                    </div>
                </div>

                <div class="px-5 sm:px-6 pb-5 pt-4 border-t border-gray-100 dark:border-gray-700 shrink-0">
                    <button type="submit"
                            class="relative w-full overflow-hidden group inline-flex items-center justify-center gap-2.5 py-4 px-6 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-white font-bold text-sm shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        <svg class="w-5 h-5 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="relative">Iniciar Simulación</span>
                    </button>
                    <p class="text-center text-[11px] text-gray-400 dark:text-gray-500 mt-2.5 flex items-center justify-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Cálculos con datos oficiales de PVGIS (Comisión Europea)
                    </p>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
        <link href="https://unpkg.com/maplibre-gl@4.1.3/dist/maplibre-gl.css" rel="stylesheet">
        <script src="https://unpkg.com/maplibre-gl@4.1.3/dist/maplibre-gl.js"></script>
        <style>
            #main-map { position: absolute; inset: 0; width: 100%; height: 100%; }
            .map-container { position: relative; height: 420px; }
            @media (min-width: 1024px) { .map-container { height: 100%; min-height: 480px; } }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
            input[type=number] { -moz-appearance: textfield; }

            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance: none; height: 20px; width: 20px;
                border-radius: 50%; background: #f59e0b; border: 3px solid #fff;
                cursor: pointer; box-shadow: 0 2px 6px rgba(245,158,11,0.4);
            }
            input[type=range]::-moz-range-thumb {
                height: 20px; width: 20px; border-radius: 50%;
                background: #f59e0b; border: 3px solid #fff; cursor: pointer;
            }

            .maplibregl-ctrl-bottom-left,
            .maplibregl-ctrl-bottom-right { display: none !important; }
            .maplibregl-canvas { outline: none !important; }
        </style>
    @endpush

    @push('js')
        <script>
        (function () {

            function init() {
                const latInput    = document.getElementById('latitud');
                const lngInput    = document.getElementById('longitud');
                const provInput   = document.getElementById('provincia');
                const searchInput = document.getElementById('buscador-direccion');
                const dropdown    = document.getElementById('search-dropdown');
                const spinner     = document.getElementById('search-spinner');
                const coordsBox   = document.getElementById('coords-indicator');
                const coordsText  = document.getElementById('coords-text');
                const feedback    = document.getElementById('search-feedback');

                if (!latInput || !searchInput || !dropdown) return;

                const initLat = parseFloat(latInput.value)  || 39.1867;
                const initLon = parseFloat(lngInput.value)  || -0.4367;

                let map = null;
                let marker = null;
                try {
                    if (typeof maplibregl !== 'undefined') {
                        map = new maplibregl.Map({
                            container: 'main-map',
                            style: {
                                version: 8,
                                sources: {
                                    carto: {
                                        type: 'raster',
                                        tiles: ['https://a.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'],
                                        tileSize: 256,
                                        attribution: '© CartoDB'
                                    }
                                },
                                layers: [{ id: 'carto-layer', type: 'raster', source: 'carto' }]
                            },
                            center: [initLon, initLat],
                            zoom: 13,
                            trackResize: true
                        });

                        marker = new maplibregl.Marker({ draggable: true, color: '#f59e0b' })
                            .setLngLat([initLon, initLat])
                            .addTo(map);
                    } else {
                        console.warn('[SolarCalc] MapLibre no disponible.');
                    }
                } catch (err) {
                    console.warn('[SolarCalc] Error inicializando mapa:', err.message);
                    map = null;
                    marker = null;
                }

                function updateCoords(lng, lat) {
                    if (!Number.isFinite(lng) || !Number.isFinite(lat)) return;
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    if (coordsBox && coordsText) {
                        coordsText.textContent = lat.toFixed(4) + '°N  ·  ' + Math.abs(lng).toFixed(4) + '°O';
                        coordsBox.classList.remove('hidden');
                        coordsBox.classList.add('flex');
                    }
                }

                function setFeedback(message, error) {
                    if (!feedback) return;
                    feedback.textContent = message || '';
                    feedback.classList.toggle('text-red-500', !!error);
                    feedback.classList.toggle('dark:text-red-400', !!error);
                    feedback.classList.toggle('text-gray-500', !error);
                    feedback.classList.toggle('dark:text-gray-400', !error);
                }

                function setSpinner(on) {
                    if (spinner) spinner.classList.toggle('hidden', !on);
                }

                function escHtml(str) {
                    const d = document.createElement('div');
                    d.appendChild(document.createTextNode(str));
                    return d.innerHTML;
                }

                function showDropdown(results) {
                    dropdown.innerHTML = '';
                    if (!results || results.length === 0) {
                        const empty = document.createElement('div');
                        empty.className = 'px-4 py-3 text-sm text-gray-500 dark:text-gray-400';
                        empty.textContent = 'No se encontraron resultados para esa búsqueda.';
                        dropdown.appendChild(empty);
                        dropdown.classList.remove('hidden');
                        setFeedback('Sin coincidencias, prueba con otra dirección.');
                        return;
                    }

                    results.forEach(function (res) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 '
                            + 'hover:bg-amber-50 dark:hover:bg-gray-700 transition-colors duration-150 '
                            + 'flex items-start gap-3 border-b border-gray-100 dark:border-gray-700 last:border-0';

                        btn.innerHTML =
                            '<svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                            + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>'
                            + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                            + '<span class="flex-1 min-w-0 line-clamp-2 leading-snug">' + escHtml(res.display_name) + '</span>';

                        btn.addEventListener('click', function () { selectLocation(res); });
                        dropdown.appendChild(btn);
                    });

                    dropdown.classList.remove('hidden');
                    setFeedback('Selecciona una dirección de la lista.');
                }

                function hideDropdown() {
                    dropdown.classList.add('hidden');
                    dropdown.innerHTML = '';
                }

                function selectLocation(result) {
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);
                    if (isNaN(lat) || isNaN(lon)) return;

                    if (map) {
                        map.flyTo({ center: [lon, lat], zoom: 15, duration: 900 });
                    }
                    if (marker) {
                        marker.setLngLat([lon, lat]);
                    }
                    updateCoords(lon, lat);

                    const addr = result.address || {};
                    const prov = (
                        addr.county         ||
                        addr.state_district ||
                        addr.municipality   ||
                        addr.city           ||
                        addr.town           ||
                        addr.village        ||
                        addr.state          ||
                        (result.display_name
                            ? result.display_name.split(',').slice(-3, -1).join(',').trim()
                            : 'valencia')
                    ).toLowerCase().trim();
                    provInput.value = prov;

                    const shortName = [
                        addr.road || addr.pedestrian,
                        addr.city || addr.town || addr.village || addr.municipality,
                        addr.state
                    ].filter(Boolean).join(', ') || result.display_name;

                    searchInput.value = shortName;
                    hideDropdown();
                    setFeedback('Ubicación aplicada al formulario.');
                }

                if (map && marker) {
                    marker.on('dragend', function () {
                        const p = marker.getLngLat();
                        updateCoords(p.lng, p.lat);
                        setFeedback('Coordenadas actualizadas desde el marcador.');
                    });

                    map.on('click', function (e) {
                        marker.setLngLat(e.lngLat);
                        updateCoords(e.lngLat.lng, e.lngLat.lat);
                        setFeedback('Coordenadas actualizadas desde el mapa.');
                    });

                    map.on('load', function () { map.resize(); });
                    window.addEventListener('resize', function () { map.resize(); });
                }

                var debounce = null;
                var activeController = null;

                function fetchLocations(q) {
                    if (activeController) activeController.abort();
                    activeController = new AbortController();

                    var url = 'https://nominatim.openstreetmap.org/search'
                        + '?format=json'
                        + '&addressdetails=1'
                        + '&accept-language=es'
                        + '&limit=6'
                        + '&countrycodes=es'
                        + '&q=' + encodeURIComponent(q);

                    setSpinner(true);
                    setFeedback('Buscando direcciones...');

                    return fetch(url, {
                        headers: { 'Accept': 'application/json' },
                        signal: activeController.signal
                    })
                    .then(function (r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function (data) {
                        setSpinner(false);
                        showDropdown(data);
                    })
                    .catch(function (err) {
                        setSpinner(false);
                        if (err.name === 'AbortError') return;
                        hideDropdown();
                        setFeedback('No se pudo buscar ahora. Inténtalo de nuevo.', true);
                        console.warn('[SolarCalc] Nominatim:', err.message);
                    });
                }

                searchInput.addEventListener('input', function () {
                    var q = searchInput.value.trim();
                    clearTimeout(debounce);

                    if (q.length < 3) {
                        hideDropdown();
                        setSpinner(false);
                        setFeedback('Escribe al menos 3 caracteres para buscar.');
                        return;
                    }

                    debounce = setTimeout(function () {
                        fetchLocations(q);
                    }, 500);
                });

                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        var q = searchInput.value.trim();
                        if (q.length >= 3) fetchLocations(q);
                        return;
                    }
                    if (e.key === 'Escape') {
                        hideDropdown();
                        searchInput.blur();
                    }
                });

                document.addEventListener('click', function (e) {
                    var wrapper = document.getElementById('search-wrapper');
                    if (wrapper && !wrapper.contains(e.target)) hideDropdown();
                });

                if (latInput.value && latInput.value !== '39.1867') {
                    updateCoords(parseFloat(lngInput.value), parseFloat(latInput.value));
                    setFeedback('Se cargó tu última ubicación seleccionada.');
                } else {
                    setFeedback('Busca una dirección o haz clic en el mapa para fijar zona.');
                }
            }

            function tryInit() {
                if (typeof maplibregl !== 'undefined') {
                    init();
                } else {
                    console.warn('[SolarCalc] MapLibre no disponible, modo sin mapa.');
                    init();
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', tryInit);
            } else {
                tryInit();
            }

        })();
        </script>
    @endpush

</x-app-layout>
