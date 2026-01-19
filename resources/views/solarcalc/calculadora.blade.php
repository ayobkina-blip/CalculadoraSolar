<x-app-layout>
    {{-- Eliminamos el link al CSS externo porque ahora todo es Tailwind puro --}}
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728L5.636 5.636"></path>
            </svg>
            {{ __('Calculadora de Rendimiento Fotovoltaico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700">
                
                <div class="p-8">
                    <form id="solarForm" action="{{ route('solar.procesar') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Campo Consumo --}}
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200 group-focus-within:text-amber-600 dark:group-focus-within:text-amber-400">
                                    Consumo Eléctrico Anual (kWh)
                                </label>
                                <div class="relative">
                                    <input type="number" name="consumo" required step="0.01" placeholder="4500"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-amber-500 dark:focus:border-amber-400 focus:ring-amber-500 dark:focus:ring-amber-400 rounded-lg shadow-sm transition-all duration-200 pl-4 pr-12 py-3 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none focus:-translate-y-0.5">
                                    <span class="absolute right-4 top-3 text-gray-400 text-sm font-mono">kWh</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Consulta tu factura para el dato exacto.</p>
                            </div>

                            {{-- Campo Superficie --}}
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200 group-focus-within:text-amber-600 dark:group-focus-within:text-amber-400">
                                    Superficie Disponible (m²)
                                </label>
                                <div class="relative">
                                    <input type="number" name="superficie" required step="0.1" placeholder="25"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-amber-500 dark:focus:border-amber-400 focus:ring-amber-500 dark:focus:ring-amber-400 rounded-lg shadow-sm transition-all duration-200 pl-4 pr-12 py-3 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none focus:-translate-y-0.5">
                                    <span class="absolute right-4 top-3 text-gray-400 text-sm font-mono">m²</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Área útil libre de sombras.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <details class="group/details">
                                <summary class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase cursor-pointer flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <svg class="w-4 h-4 transform group-open/details:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    Configuración Técnica Avanzada
                                </summary>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 bg-gray-50 dark:bg-gray-900/40 p-6 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                                    <div>
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Orientación</label>
                                        <select name="orientacion" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                                            <option value="0">Sur (Óptimo)</option>
                                            <option value="-45">Sureste</option>
                                            <option value="45">Suroeste</option>
                                            <option value="90">Este/Oeste</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Inclinación (°)</label>
                                        <input type="number" name="inclinacion" value="30" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                                    </div>
                                </div>
                            </details>
                        </div>

                        <button type="submit" id="btnSubmit" 
                            class="inline-flex justify-center items-center px-6 py-4 bg-amber-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-150 w-full group overflow-hidden relative shadow-lg shadow-amber-600/20 active:scale-[0.98]">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg id="btnIcon" class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7l6 5-6 5V7z"></path>
                                </svg>
                                <span id="btnText">Calcular Rendimiento</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900/80 border-t border-gray-200 dark:border-gray-700 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-mono italic">Engine Core v1.2.0 // PVGIS Integrated</span>
                        <span class="text-[9px] text-gray-500 uppercase tracking-tighter">Lat: 40.4168 / Lon: -3.7038 (Default)</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">System Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        document.getElementById('solarForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            text.innerText = 'Analizando Datos...';
            
            icon.innerHTML = '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>';
            icon.classList.add('animate-spin');
        });
    </script>
    @endpush
</x-app-layout>