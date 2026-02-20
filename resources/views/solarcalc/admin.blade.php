<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Panel de Administración
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">SolarCalc · Gestión de sistemas y usuarios</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-8">

        {{-- ══════════════════════════════════════
             BLOQUE 1 — KPIs
        ══════════════════════════════════════ --}}
        @php
            $stats = [
                [
                    'label'   => 'Simulaciones totales',
                    'value'   => $todosLosPresupuestos->count(),
                    'color'   => 'blue',
                    'bg'      => 'bg-blue-50 dark:bg-blue-900/20',
                    'text'    => 'text-blue-600 dark:text-blue-400',
                    'icon'    => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                ],
                [
                    'label'   => 'Pendientes de revisión',
                    'value'   => $todosLosPresupuestos->where('estado', 'pendiente')->count(),
                    'color'   => 'amber',
                    'bg'      => 'bg-amber-50 dark:bg-amber-900/20',
                    'text'    => 'text-amber-600 dark:text-amber-400',
                    'icon'    => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'label'   => 'Aprobados',
                    'value'   => $todosLosPresupuestos->where('estado', 'aprobado')->count(),
                    'color'   => 'emerald',
                    'bg'      => 'bg-emerald-50 dark:bg-emerald-900/20',
                    'text'    => 'text-emerald-600 dark:text-emerald-400',
                    'icon'    => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'label'   => 'Usuarios registrados',
                    'value'   => $usuarios->count(),
                    'color'   => 'red',
                    'bg'      => 'bg-red-50 dark:bg-red-900/20',
                    'text'    => 'text-red-600 dark:text-red-400',
                    'icon'    => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z',
                ],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            @foreach($stats as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 lg:p-6 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between gap-3 mb-3 sm:mb-4">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl {{ $stat['bg'] }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ $stat['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $stat['value'] }}
                    </p>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1 leading-tight">
                        {{ $stat['label'] }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- ══════════════════════════════════════
             BLOQUE 2 — AUDITORÍA DE SIMULACIONES
        ══════════════════════════════════════ --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">

            {{-- Cabecera del bloque --}}
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 sm:mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-red-600 rounded-full"></div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Auditoría de Simulaciones</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Todas las simulaciones del sistema</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.exportar.csv', request()->all()) }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Exportar CSV
                    </a>
                </div>

                {{-- Filtros --}}
                <form method="GET" action="{{ route('solar.admin') }}">
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 items-stretch sm:items-end">
                        <div class="flex-1 min-w-0 sm:min-w-[200px]">
                            <label for="admin-buscar" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Buscar</label>
                            <input type="text"
                                   id="admin-buscar"
                                   name="buscar"
                                   value="{{ request('buscar') }}"
                                   placeholder="Ubicación, usuario, email..."
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                        </div>

                        <div class="sm:min-w-[150px]">
                            <label for="admin-estado" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Estado</label>
                            <select id="admin-estado" name="estado"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobado"  {{ request('estado') == 'aprobado'  ? 'selected' : '' }}>Aprobado</option>
                                <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>

                        <div class="sm:min-w-[170px]">
                            <label for="admin-orden" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Ordenar por</label>
                            <select id="admin-orden" name="orden"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                                <option value="fecha_desc"    {{ request('orden') == 'fecha_desc'    ? 'selected' : '' }}>Más recientes</option>
                                <option value="fecha_asc"     {{ request('orden') == 'fecha_asc'     ? 'selected' : '' }}>Más antiguos</option>
                                <option value="potencia_desc" {{ request('orden') == 'potencia_desc' ? 'selected' : '' }}>Mayor potencia</option>
                                <option value="ahorro_desc"   {{ request('orden') == 'ahorro_desc'   ? 'selected' : '' }}>Mayor ahorro</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-sm font-semibold hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Filtrar
                            </button>
                            @if(request()->hasAny(['buscar', 'estado', 'orden']))
                                <a href="{{ route('solar.admin') }}"
                                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:border-red-400 hover:text-red-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- VISTA CARDS MÓVIL (< sm) --}}
            <div class="sm:hidden divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($todosLosPresupuestos as $item)
                    @php
                        $statusConfig = [
                            'aprobado'  => ['badge' => 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50', 'label' => 'Aprobado'],
                            'pendiente' => ['badge' => 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/50',   'label' => 'Pendiente'],
                            'rechazado' => ['badge' => 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800/50',        'label' => 'Rechazado'],
                        ][$item->estado ?? 'pendiente'];
                    @endphp
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300">
                                        {{ strtoupper(substr($item->usuario->nombre ?? $item->usuario->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $item->usuario->nombre ?? $item->usuario->name ?? 'Invitado' }}
                                    </p>
                                    <p class="text-xs text-red-500 dark:text-red-400 font-mono">#{{ $item->id_resultado }}</p>
                                </div>
                            </div>
                            <span class="flex-shrink-0 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase border {{ $statusConfig['badge'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Potencia instalación</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</p>
                            </div>
                            <form action="{{ route('admin.cambiarEstado', $item->id_resultado) }}" method="POST">
                                @csrf
                                <select name="estado" onchange="this.form.submit()"
                                        class="text-xs font-semibold py-2 pl-3 pr-8 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 transition cursor-pointer">
                                    <option value="pendiente" {{ ($item->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Revisar</option>
                                    <option value="aprobado"  {{ ($item->estado ?? '') == 'aprobado'  ? 'selected' : '' }}>Aprobar</option>
                                    <option value="rechazado" {{ ($item->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Denegar</option>
                                </select>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center px-4">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Sin resultados</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">No hay simulaciones con los filtros aplicados.</p>
                    </div>
                @endforelse
            </div>

            {{-- VISTA TABLA DESKTOP (sm+) --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/40">
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Operador</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Potencia</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-center">Estado</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($todosLosPresupuestos as $item)
                            @php
                                $sc = [
                                    'aprobado'  => ['badge' => 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50', 'icon' => 'M5 13l4 4L19 7',                           'label' => 'Aprobado'],
                                    'pendiente' => ['badge' => 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/50',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Pendiente'],
                                    'rechazado' => ['badge' => 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800/50',        'icon' => 'M6 18L18 6M6 6l12 12',                          'label' => 'Rechazado'],
                                ][$item->estado ?? 'pendiente'];
                            @endphp
                            <tr class="hover:bg-amber-50/20 dark:hover:bg-amber-950/10 transition-colors duration-150 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0 group-hover:bg-white dark:group-hover:bg-gray-600 transition-colors">
                                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300">
                                                {{ strtoupper(substr($item->usuario->nombre ?? $item->usuario->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $item->usuario->nombre ?? $item->usuario->name ?? 'Invitado' }}
                                            </p>
                                            <p class="text-xs text-red-500 dark:text-red-400 font-mono">#{{ $item->id_resultado }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Potencia instalación</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase border {{ $sc['badge'] }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $sc['icon'] }}"/>
                                        </svg>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.cambiarEstado', $item->id_resultado) }}" method="POST" class="flex justify-end">
                                        @csrf
                                        <div class="relative inline-flex items-center">
                                            <select name="estado" onchange="this.form.submit()"
                                                    class="appearance-none text-xs font-semibold py-2 pl-4 pr-9 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 transition cursor-pointer shadow-sm">
                                                <option value="pendiente" {{ ($item->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Revisar</option>
                                                <option value="aprobado"  {{ ($item->estado ?? '') == 'aprobado'  ? 'selected' : '' }}>Aprobar</option>
                                                <option value="rechazado" {{ ($item->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Denegar</option>
                                            </select>
                                            <div class="absolute right-3 pointer-events-none text-gray-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Sin resultados</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">No hay simulaciones con los filtros aplicados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($todosLosPresupuestos->hasPages())
                <div class="px-4 sm:px-6 py-4 bg-gray-50/50 dark:bg-gray-700/20 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 order-2 sm:order-1">
                            Mostrando {{ $todosLosPresupuestos->firstItem() }}–{{ $todosLosPresupuestos->lastItem() }} de {{ $todosLosPresupuestos->total() }} resultados
                        </p>
                        <div class="order-1 sm:order-2">
                            {{ $todosLosPresupuestos->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════
             BLOQUE 3 — CONTROL DE USUARIOS
        ══════════════════════════════════════ --}}
        <div x-data="{ openModal: false, targetUser: '', targetId: '', targetAction: '' }"
             class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">

            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-red-600 rounded-full"></div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Control de Usuarios</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gestión de roles y accesos del sistema</p>
                    </div>
                </div>
            </div>

            {{-- CARDS MÓVIL usuarios (< sm) --}}
            <div class="sm:hidden divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($usuarios as $usuario)
                    <div class="p-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-white">
                                    {{ strtoupper(substr($usuario->nombre ?? $usuario->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $usuario->nombre ?? $usuario->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $usuario->email }}</p>
                                @if($usuario->rol == 1)
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-bold uppercase">Admin</span>
                                @endif
                            </div>
                        </div>

                        @if(auth()->id() !== ($usuario->id_usuario ?? $usuario->id))
                            <button type="button"
                                @click="openModal = true;
                                        targetUser = '{{ $usuario->nombre ?? $usuario->name }}';
                                        targetId = '{{ $usuario->id_usuario ?? $usuario->id }}';
                                        targetAction = '{{ $usuario->rol == 1 ? 'degradar' : 'promocionar' }}'"
                                class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                    {{ $usuario->rol == 1
                                        ? 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-red-400 hover:text-red-500'
                                        : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-emerald-400 hover:text-emerald-500' }}">
                                {{ $usuario->rol == 1 ? 'Degradar' : 'Promover' }}
                            </button>
                        @else
                            <span class="flex-shrink-0 flex items-center gap-1.5 text-[10px] font-bold uppercase text-emerald-500 tracking-wide">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Tú
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- TABLA DESKTOP usuarios (sm+) --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/40">
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Usuario</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rol actual</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($usuarios as $usuario)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-bold text-white">
                                                {{ strtoupper(substr($usuario->nombre ?? $usuario->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $usuario->nombre ?? $usuario->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $usuario->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($usuario->rol == 1)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            Administrador
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Usuario
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if(auth()->id() !== ($usuario->id_usuario ?? $usuario->id))
                                        <button type="button"
                                            @click="openModal = true;
                                                    targetUser = '{{ $usuario->nombre ?? $usuario->name }}';
                                                    targetId = '{{ $usuario->id_usuario ?? $usuario->id }}';
                                                    targetAction = '{{ $usuario->rol == 1 ? 'degradar' : 'promocionar' }}'"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                                {{ $usuario->rol == 1
                                                    ? 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20'
                                                    : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-emerald-400 hover:text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' }}">
                                            {{ $usuario->rol == 1 ? 'Degradar' : 'Promocionar' }}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="flex items-center justify-end gap-2 text-xs font-semibold text-emerald-500 uppercase tracking-wide">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Sesión activa
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ══════════════════════════════════════
                 MODAL DE CONFIRMACIÓN DE ROL
            ══════════════════════════════════════ --}}
            <template x-teleport="body">
                <div x-show="openModal"
                     class="fixed inset-0 z-[99] flex items-end sm:items-center justify-center p-4"
                     x-cloak>

                    {{-- Backdrop --}}
                    <div x-show="openModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="openModal = false"
                         class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm"></div>

                    {{-- Panel del modal --}}
                    <div x-show="openModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                         class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-2xl p-6 sm:p-8">

                        {{-- Botón cerrar --}}
                        <button @click="openModal = false"
                                class="absolute top-4 right-4 p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <div class="flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center mb-5">
                                <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Confirmar cambio de rol
                            </h3>

                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 leading-relaxed max-w-xs">
                                ¿Deseas
                                <span class="font-bold text-red-600 dark:text-red-400" x-text="targetAction"></span>
                                al usuario
                                <span class="font-bold text-gray-900 dark:text-white" x-text="targetUser"></span>?
                                Esta acción afecta inmediatamente sus permisos.
                            </p>

                            <div class="mt-6 flex flex-col w-full gap-3">
                                <form :action="'{{ url('admin/usuario') }}/' + targetId + '/rol'" method="POST">
                                    @csrf
                                    <input type="hidden" name="rol" :value="targetAction === 'promocionar' ? 1 : 0">
                                    <button type="submit"
                                            class="w-full py-3 px-6 rounded-xl bg-red-600 hover:bg-red-500 text-white text-sm font-semibold hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Confirmar acción
                                    </button>
                                </form>
                                <button @click="openModal = false"
                                        class="w-full py-3 px-6 rounded-xl border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>
</x-app-layout>