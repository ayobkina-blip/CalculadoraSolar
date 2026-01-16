<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resultados del Análisis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-8 text-center">
                <h3 class="text-2xl font-light text-gray-600 dark:text-gray-400 mb-4">Potencia Óptima Estimada</h3>
                <div class="text-6xl font-black text-yellow-500 mb-6">4.2 <span class="text-2xl">kWp</span></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-sm uppercase tracking-widest text-gray-500">Ahorro Anual</p>
                        <p class="text-3xl font-bold text-green-600">920 €</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-sm uppercase tracking-widest text-gray-500">Amortización</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white">5.4 años</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>