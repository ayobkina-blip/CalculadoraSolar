<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight italic">
            {{ __('Registro Histórico de Presupuestos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 sm:rounded-xl overflow-hidden">
                
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Simulaciones Guardadas</h3>
                        <p class="text-sm text-gray-500">Listado de análisis fotovoltaicos realizados en Algemesí.</p>
                    </div>
                    <a href="{{ route('solar.calculadora') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition">
                        + Nueva Simulación
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs uppercase tracking-widest text-gray-400 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                                <th class="px-8 py-4 font-black">ID Ref.</th>
                                <th class="px-8 py-4 font-black">Ubicación</th>
                                <th class="px-8 py-4 font-black">Potencia</th>
                                <th class="px-8 py-4 font-black">Ahorro Est.</th>
                                <th class="px-8 py-4 font-black">Fecha</th>
                                <th class="px-8 py-4 font-black text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-8 py-4 font-mono text-xs text-gray-400">#SC-2025-001</td>
                                <td class="px-8 py-4 text-sm font-medium text-gray-900 dark:text-white">Calle Benimodo 3, Algemesí</td>
                                <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-300">4.5 kWp</td>
                                <td class="px-8 py-4 text-sm font-bold text-green-600">850 €/año</td>
                                <td class="px-8 py-4 text-sm text-gray-500">12 Dic 2025</td>
                                <td class="px-8 py-4 text-right text-xs">
                                    <a href="{{ route('solar.resultados') }}" class="text-yellow-600 hover:text-yellow-700 font-bold uppercase tracking-tighter">Detalles</a>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-8 py-4 font-mono text-xs text-gray-400">#SC-2025-042</td>
                                <td class="px-8 py-4 text-sm font-medium text-gray-900 dark:text-white">Polígono Industrial, Nave 4</td>
                                <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-300">12.0 kWp</td>
                                <td class="px-8 py-4 text-sm font-bold text-green-600">2.100 €/año</td>
                                <td class="px-8 py-4 text-sm text-gray-500">01 Ene 2026</td>
                                <td class="px-8 py-4 text-right text-xs">
                                    <a href="{{ route('solar.resultados') }}" class="text-yellow-600 hover:text-yellow-700 font-bold uppercase tracking-tighter">Detalles</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-4 bg-gray-50/50 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-400 italic">
                    Mostrando 2 registros encontrados para el usuario Ayob.
                </div>
            </div>

        </div>
    </div>
</x-app-layout>