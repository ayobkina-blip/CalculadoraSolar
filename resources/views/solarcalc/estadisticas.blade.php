<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estadísticas de Energía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Radiación Media</p>
                    <p class="text-2xl font-bold mt-2 dark:text-white">1,650 kWh/m²</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Usuarios en Algemesí</p>
                    <p class="text-2xl font-bold mt-2 dark:text-white">124 perfiles</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">CO2 Evitado</p>
                    <p class="text-2xl font-bold mt-2 text-green-600">12.4 Toneladas</p>
                </div>
            </div>
            
            <div class="mt-8 bg-white dark:bg-gray-800 p-10 rounded-xl border border-gray-100 dark:border-gray-700 h-64 flex items-center justify-center italic text-gray-400">
                Visualización de curva de generación mensual (Simulación Chart.js)
            </div>
        </div>
    </div>
</x-app-layout>