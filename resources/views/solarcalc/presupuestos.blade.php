<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            {{ __('Registro Histórico de Presupuestos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700">
                
                {{-- CABECERA DE SECCIÓN --}}
                <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Simulaciones Guardadas</h3>
                            <p class="text-sm text-gray-500">Listado completo de tus análisis fotovoltaicos.</p>
                        </div>
                        <a href="{{ route('solar.calculadora') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-700 transition shadow-md active:scale-95">
                            + Nueva Simulación
                        </a>
                    </div>
                    
                    {{-- FILTROS Y BÚSQUEDA --}}
                    <form method="GET" action="{{ route('solar.presupuestos') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Buscar por ubicación</label>
                            <input type="text" 
                                   name="buscar" 
                                   value="{{ request('buscar') }}" 
                                   placeholder="Ej: Valencia, Madrid..."
                                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none">
                        </div>
                        
                        <div class="min-w-[180px]">
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Ordenar por</label>
                            <select name="orden" 
                                    onchange="this.form.submit()"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none">
                                <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Más recientes</option>
                                <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Más antiguos</option>
                                <option value="potencia_desc" {{ request('orden') == 'potencia_desc' ? 'selected' : '' }}>Mayor potencia</option>
                                <option value="potencia_asc" {{ request('orden') == 'potencia_asc' ? 'selected' : '' }}>Menor potencia</option>
                                <option value="ahorro_desc" {{ request('orden') == 'ahorro_desc' ? 'selected' : '' }}>Mayor ahorro</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold uppercase transition">
                                Filtrar
                            </button>
                            @if(request()->hasAny(['buscar', 'orden']))
                                <a href="{{ route('solar.presupuestos') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold uppercase transition">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- TABLA DE RESULTADOS --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs uppercase tracking-widest text-gray-400 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                                <th class="px-8 py-4 font-black">ID Ref.</th>
                                <th class="px-8 py-4 font-black">Ubicación</th>
                                <th class="px-8 py-4 font-black">Potencia</th>
                                <th class="px-8 py-4 font-black">Ahorro Est.</th>
                                <th class="px-8 py-4 font-black">ROI</th>
                                <th class="px-8 py-4 font-black text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($presupuestos as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                    <td class="px-8 py-4 font-mono text-xs text-gray-400">#{{ $item->id_resultado }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $item->ubicacion }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-300">{{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</td>
                                    <td class="px-8 py-4 text-sm font-bold text-green-600">{{ number_format($item->ahorro_estimado_eur, 2) }} €/año</td>
                                    <td class="px-8 py-4 text-sm text-gray-500">{{ $item->roi_anyos }} años</td>
                                    <td class="px-8 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            {{-- Enlace a Detalles --}}
                                            <a href="{{ route('solar.resultados', ['id' => $item->id_resultado]) }}" 
                                               class="text-amber-600 hover:text-amber-700 font-bold uppercase tracking-tighter transition text-[11px]">
                                                Detalles
                                            </a>

                                            {{-- Botón PDF --}}
                                            <a href="{{ route('solar.pdf', $item->id_resultado) }}" 
                                               title="Descargar PDF"
                                               class="p-1.5 text-gray-500 hover:text-red-600 dark:hover:text-red-400 transition-colors bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1m1 0h1m-2 4h1m1 0h1m-2 4h1m1 0h1" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-12 text-center text-gray-400 italic">
                                        No se han encontrado simulaciones previas en tu historial.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                @if($presupuestos->hasPages())
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900/80 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Mostrando {{ $presupuestos->firstItem() }} - {{ $presupuestos->lastItem() }} de {{ $presupuestos->total() }} resultados
                        </div>
                        <div class="flex gap-2">
                            {{ $presupuestos->links() }}
                        </div>
                    </div>
                </div>
                @endif

                {{-- FOOTER INFORMATIVO --}}
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900/80 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-mono italic tracking-tight">
                            Total: {{ $presupuestos->total() }} simulaciones guardadas
                        </span>
                    </div>
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Historial Activo</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>