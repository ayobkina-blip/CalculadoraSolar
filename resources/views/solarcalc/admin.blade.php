<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            {{ __('Gestión Administrativa de Simulaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700">
                
                {{-- Cabecera del Admin --}}
                <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Auditoría Global de Datos</h3>
                        <p class="text-sm text-gray-500">Valida qué cálculos afectan a las estadísticas públicas.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs uppercase tracking-widest text-gray-400 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                                <th class="px-8 py-4 font-black">Usuario</th>
                                <th class="px-8 py-4 font-black">Potencia</th>
                                <th class="px-8 py-4 font-black">Ahorro</th>
                                <th class="px-8 py-4 font-black text-center">Estado para Global</th>
                                <th class="px-8 py-4 font-black text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($todosLosPresupuestos as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->usuario->name ?? 'Usuario #'.$item->usuario_fr }}</span>
                                        <span class="text-[10px] font-mono text-gray-400">Ref: #{{ $item->id_resultado }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-300 font-medium">
                                    {{ number_format($item->potencia_instalacion_kwp, 2) }} kWp
                                </td>
                                <td class="px-8 py-4 text-sm font-bold text-green-600">
                                    {{ number_format($item->ahorro_estimado_eur, 2) }} €
                                </td>
                                <td class="px-8 py-4 text-center">
                                    @php
                                        $badgeColor = [
                                            'verificado' => 'bg-green-100 text-green-700 border-green-200',
                                            'pendiente' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'rechazado' => 'bg-red-100 text-red-700 border-red-200'
                                        ][$item->estado ?? 'pendiente'];
                                    @endphp
                                    <span class="px-3 py-1 border rounded-full text-[10px] font-black uppercase tracking-tighter {{ $badgeColor }}">
                                        {{ $item->estado ?? 'pendiente' }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <form action="{{ route('admin.cambiarEstado', $item->id_resultado) }}" method="POST">
                                        @csrf
                                        <select name="nuevo_estado" onchange="this.form.submit()" class="text-[11px] font-bold rounded-lg border-gray-200 dark:bg-gray-900 dark:text-white focus:ring-red-500 py-1 shadow-sm">
                                            <option value="pendiente" {{ ($item->estado ?? '') == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                                            <option value="verificado" {{ ($item->estado ?? '') == 'verificado' ? 'selected' : '' }}>✅ Verificar</option>
                                            <option value="rechazado" {{ ($item->estado ?? '') == 'rechazado' ? 'selected' : '' }}>❌ Rechazar</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer informativo igual al original --}}
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900/80 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <span class="text-[10px] text-gray-400 font-mono italic">Registros totales en sistema: {{ $todosLosPresupuestos->count() }}</span>
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest text-red-500">Modo Auditor</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>