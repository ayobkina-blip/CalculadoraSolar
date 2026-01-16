<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/calculadora.css') }}">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Calculadora Solar') }}
                <span class="block text-sm font-normal text-slate-500 italic">Optimización Energética</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f1f5f9] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="solar-card overflow-hidden">
                <div class="h-2 w-full bg-gradient-to-r from-yellow-400 to-yellow-600"></div>
                
                <div class="p-8 md:p-12">
                    <form action="{{ route('solar.procesar') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="space-y-6">
                            <div class="group">
                                <label class="solar-label">Ubicación del Proyecto</label>
                                <div class="relative">
                                    <input type="text" name="direccion" value="Calle Benimodo 3, Algemesí" class="solar-input" readonly>
                                    <span class="absolute right-4 top-3 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="solar-label">Consumo Eléctrico (kWh/mes)</label>
                                    <input type="number" name="consumo" required placeholder="Ej: 350.50" class="solar-input" step="0.01">
                                </div>

                                <div class="group">
                                    <label class="solar-label">Área de Captación (m²)</label>
                                    <input type="number" name="superficie" required placeholder="Ej: 25.00" class="solar-input" step="0.01">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="solar-btn group">
                                <span>Iniciar Procesamiento</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-4">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-widest">
                    SolarCalc <span class="text-yellow-500">Engine</span> v1.0
                </p>
                <div class="flex space-x-2">
                    <div class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">System Online</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>