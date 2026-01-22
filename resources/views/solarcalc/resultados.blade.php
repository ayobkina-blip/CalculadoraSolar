<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resultados del Análisis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- En resultados.blade.php --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-8 text-center">
                <h3 class="text-2xl font-light text-gray-600 dark:text-gray-400 mb-4">Potencia Óptima Estimada</h3>
                
                {{-- CORREGIDO: Usar variable dinámica en vez de "4.2" --}}
                <div class="text-6xl font-black text-yellow-500 mb-6">
                    {{ number_format($resultado->potencia_instalacion_kwp, 2) }} <span class="text-2xl">kWp</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-sm uppercase tracking-widest text-gray-500">Ahorro Anual</p>
                        {{-- CORREGIDO: Usar variable dinámica en vez de "920 €" --}}
                        <p class="text-3xl font-bold text-green-600">
                            {{ number_format($resultado->ahorro_estimado_eur, 2) }} €
                        </p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-sm uppercase tracking-widest text-gray-500">Amortización (ROI)</p>
                        {{-- CORREGIDO: Usar variable dinámica en vez de "5.4 años" --}}
                        <p class="text-3xl font-bold text-gray-800 dark:text-white">
                            {{ $resultado->roi_anyos }} años
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('solar.pdf', $resultado->id_resultado) }}" 
                    class="inline-flex items-center px-6 py-3 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition shadow-md active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Descargar Presupuesto en PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>