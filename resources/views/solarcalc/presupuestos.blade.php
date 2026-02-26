{{-- Prioridades 1-5 aplicadas: cards móvil + tabla sm+, mejoras visuales de filtros/tabla, estado vacío unificado y paginación/footer --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            {{ __('Registro Histórico de Presupuestos') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border-t-4 border-amber-600 border-x border-b border-gray-200 dark:border-gray-700 shadow-xl overflow-hidden p-5 sm:p-6 lg:p-8">
                <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
                    <div>
                        <h3 class="text-[10px] font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest leading-none">Vigilancia de Presupuestos</h3>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 uppercase tracking-wider font-bold">Listado completo de tus análisis fotovoltaicos</p>
                    </div>
                    <a href="{{ route('solar.calculadora') }}"
                       class="inline-flex items-center gap-2 py-2.5 px-5 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <span>+</span>
                        <span>Nueva Simulación</span>
                    </a>
                </div>

                <div class="mb-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="rounded-2xl border-t-4 border-slate-400 border-x border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 p-4">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Estado de suscripción</p>
                        <div class="mt-2 flex items-center gap-2">
                            @if($currentPlan->code !== 'free')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-bold uppercase">Premium</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold uppercase">Free</span>
                            @endif
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $currentPlan->name }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                            Simulaciones restantes:
                            <span class="font-bold">{{ $remainingSimulations === null ? 'Ilimitadas' : $remainingSimulations }}</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border-t-4 border-amber-500 border-x border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                        <p class="text-[10px] font-black text-amber-500/70 dark:text-amber-500/40 uppercase tracking-widest mb-2">Herramientas premium</p>
                        @if($canCompare)
                            <form method="POST" action="{{ route('premium.compare') }}" class="space-y-2">
                                @csrf
                                <select name="resultados[]" multiple size="4" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    @foreach($presupuestos as $item)
                                        <option value="{{ $item->id_resultado }}">#{{ $item->id_resultado }} · {{ $item->ubicacion }} · {{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</option>
                                    @endforeach
                                </select>
                                <div class="flex gap-2">
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-amber-600 text-white text-xs font-semibold hover:bg-amber-500 transition-all">
                                        Comparar (2-3)
                                    </button>
                                    @if($canExportCsv)
                                        <a href="{{ route('premium.export.csv') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-800 dark:bg-slate-100 dark:text-slate-900 text-white text-xs font-semibold hover:opacity-90 transition-all">
                                            Exportar CSV
                                        </a>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="rounded-xl border border-dashed border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 p-3">
                                <p class="text-xs text-amber-700 dark:text-amber-300 font-semibold">Comparador y CSV bloqueados en plan Free.</p>
                                <a href="{{ route('premium.index', ['reason' => 'result_compare']) }}" class="inline-flex mt-2 px-3 py-2 rounded-lg bg-amber-600 text-white text-xs font-semibold hover:bg-amber-500 transition">Desbloquear Premium</a>
                            </div>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('solar.presupuestos') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-sm mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
                        <div class="sm:col-span-2">
                            <label for="buscar" class="sr-only">Buscar por ubicación</label>
                            <input id="buscar"
                                   type="text"
                                   name="buscar"
                                   value="{{ request('buscar') }}"
                                   placeholder="Ej: Valencia, Madrid..."
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label for="orden" class="sr-only">Ordenar por</label>
                            <select id="orden"
                                    name="orden"
                                    onchange="this.form.submit()"
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Más recientes</option>
                                <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Más antiguos</option>
                                <option value="potencia_desc" {{ request('orden') == 'potencia_desc' ? 'selected' : '' }}>Mayor potencia</option>
                                <option value="potencia_asc" {{ request('orden') == 'potencia_asc' ? 'selected' : '' }}>Menor potencia</option>
                                <option value="ahorro_desc" {{ request('orden') == 'ahorro_desc' ? 'selected' : '' }}>Mayor ahorro</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 sm:justify-end">
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-500 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500">
                                Filtrar
                            </button>
                            @if(request()->hasAny(['buscar', 'orden']))
                                <a href="{{ route('solar.presupuestos') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:border-red-400 hover:text-red-500 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-400">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="sm:hidden space-y-4">
                    @forelse($presupuestos as $item)
                        <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $item->ubicacion ?? 'Sin ubicación' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $item->created_at?->format('d/m/Y') ?? 'Sin fecha' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Potencia</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ number_format($item->potencia_instalacion_kwp, 2) }} kWp
                                    </p>
                                </div>
                                <div class="bg-amber-50 dark:bg-amber-950/30 rounded-xl p-3">
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mb-1">Ahorro est.</p>
                                    <p class="text-sm font-bold text-amber-600 dark:text-amber-400">
                                        {{ number_format($item->ahorro_estimado_eur, 0) }} €/año
                                    </p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3 col-span-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Retorno inversión</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $item->roi_anyos }} años
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('solar.resultados', ['id' => $item->id_resultado]) }}"
                                   class="flex-1 inline-flex items-center justify-center py-2.5 px-4 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:border-amber-500 hover:text-amber-500 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    Ver detalle
                                </a>
                                @if($canDownloadPdf)
                                    <a href="{{ route('solar.pdf', $item->id_resultado) }}"
                                       class="flex-1 inline-flex items-center justify-center py-2.5 px-4 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-500 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500">
                                        PDF
                                    </a>
                                @else
                                    <a href="{{ route('premium.index', ['reason' => 'pdf_export']) }}"
                                       class="flex-1 inline-flex items-center justify-center py-2.5 px-4 rounded-xl border border-amber-300 text-amber-700 dark:text-amber-300 text-sm font-semibold hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500">
                                        Premium PDF
                                    </a>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m8-10h2M2 12H4m14.95 6.95l1.414 1.414M5.636 5.636L4.222 4.222m14.142-0.001l-1.414 1.415M5.636 18.364l-1.414 1.414M12 7a5 5 0 100 10 5 5 0 000-10z" />
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-gray-900 dark:text-white mb-1">Sin simulaciones todavía</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Crea tu primera simulación solar y aparecerá aquí.</p>
                            <a href="{{ route('solar.calculadora') }}"
                               class="inline-flex items-center gap-2 py-2.5 px-6 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-500 transition-all duration-200 ease-in-out">
                                Ir a la Calculadora
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="hidden sm:block">
                    <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">ID Ref.</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Ubicación</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Potencia</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Ahorro Est.</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">ROI</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($presupuestos as $item)
                                        <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-950/10 transition-colors duration-150">
                                            <td class="px-4 py-4 text-sm font-mono text-gray-500 dark:text-gray-400">#{{ $item->id_resultado }}</td>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $item->ubicacion }}</td>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</td>
                                            <td class="px-4 py-4 text-sm font-semibold text-amber-600 dark:text-amber-400">{{ number_format($item->ahorro_estimado_eur, 2) }} €/año</td>
                                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $item->roi_anyos }} años</td>
                                            <td class="px-4 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('solar.resultados', ['id' => $item->id_resultado]) }}"
                                                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:border-amber-500 hover:text-amber-500 transition-all duration-200 ease-in-out">
                                                        Ver
                                                    </a>
                                                    @if($canDownloadPdf)
                                                        <a href="{{ route('solar.pdf', $item->id_resultado) }}"
                                                           class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-600 text-white text-xs font-semibold hover:bg-amber-500 hover:shadow-sm transition-all duration-200 ease-in-out">
                                                            PDF
                                                        </a>
                                                    @else
                                                        <a href="{{ route('premium.index', ['reason' => 'pdf_export']) }}"
                                                           class="inline-flex items-center px-3 py-1.5 rounded-lg border border-amber-300 text-amber-700 dark:text-amber-300 text-xs font-semibold hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-200 ease-in-out">
                                                            Premium PDF
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-4">
                                                <div class="text-center py-16">
                                                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m8-10h2M2 12H4m14.95 6.95l1.414 1.414M5.636 5.636L4.222 4.222m14.142-0.001l-1.414 1.415M5.636 18.364l-1.414 1.414M12 7a5 5 0 100 10 5 5 0 000-10z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-base font-semibold text-gray-900 dark:text-white mb-1">Sin simulaciones todavía</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Crea tu primera simulación solar y aparecerá aquí.</p>
                                                    <a href="{{ route('solar.calculadora') }}"
                                                       class="inline-flex items-center gap-2 py-2.5 px-6 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-500 transition-all duration-200 ease-in-out">
                                                        Ir a la Calculadora
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($presupuestos->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $presupuestos->links() }}
                    </div>
                @endif

                <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                    Total: {{ $presupuestos->total() }} simulaciones guardadas
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
