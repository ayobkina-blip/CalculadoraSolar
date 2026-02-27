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
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gestión global de simulaciones, usuarios y suscripciones</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-8">

        {{-- ══════════════════════════════════════
             BLOQUE 1 — KPIs
        ══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

            {{-- KPI: Simulaciones totales --}}
            <div class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $todosLosPresupuestos->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Simulaciones totales</p>
            </div>

            {{-- KPI: Pendientes --}}
            <div class="rounded-2xl bg-white dark:bg-gray-800 border border-amber-200 dark:border-amber-700/50 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-amber-600 dark:text-amber-400">{{ $todosLosPresupuestos->where('estado', 'pendiente')->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Pendientes de revisión</p>
            </div>

            {{-- KPI: Aprobados --}}
            <div class="rounded-2xl bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-700/50 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $todosLosPresupuestos->where('estado', 'aprobado')->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Aprobados</p>
            </div>

            {{-- KPI: Usuarios registrados --}}
            <div class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $usuarios->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Usuarios registrados</p>
            </div>

        </div>

        {{-- ══════════════════════════════════════
             BLOQUE 2 — AUDITORÍA DE SIMULACIONES
        ══════════════════════════════════════ --}}
        <div class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            {{-- Cabecera de sección --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Auditoría de Simulaciones</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Todas las simulaciones del sistema</p>
                </div>
                <a href="{{ route('admin.exportar.csv', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white text-xs font-semibold hover:opacity-90 transition shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar CSV
                </a>
            </div>

            {{-- Filtros --}}
            <div class="px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
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
                            <x-audit-status-selector :status="$item->estado ?? 'pendiente'" :action="route('admin.cambiarEstado', $item->id_resultado)" />
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
            <div class="hidden sm:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-left text-sm">
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
                                 <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-end">
                                        <x-audit-status-selector :status="$item->estado ?? 'pendiente'" :action="route('admin.cambiarEstado', $item->id_resultado)" />
                                    </div>
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
        <div x-data="{
                openModal: false,
                targetUser: '',
                targetId: '',
                targetAction: '',
                openPremiumModal: false,
                premiumTargetUser: '',
                premiumTargetId: ''
             }"
             class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Control de Usuarios</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gestión de roles y accesos del sistema</p>
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
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700">
                                        Admin
                                    </span>
                                @endif
                                @php
                                    $planCode = $usuario->activeSubscription?->plan?->code;
                                    $planName = $usuario->activeSubscription?->plan?->name;
                                @endphp
                                @if($usuario->rol == 1)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                        Bypass
                                    </span>
                                @elseif($planCode)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-700">
                                        ★ Premium
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                                        Free
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(auth()->id() !== ($usuario->id_usuario ?? $usuario->id))
                            <div class="flex-shrink-0 flex flex-col gap-2">
                                <button type="button"
                                    @click="openModal = true;
                                            targetUser = '{{ $usuario->nombre ?? $usuario->name }}';
                                            targetId = '{{ $usuario->id_usuario ?? $usuario->id }}';
                                            targetAction = '{{ $usuario->rol == 1 ? 'degradar' : 'promocionar' }}'"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                        {{ $usuario->rol == 1
                                            ? 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-red-400 hover:text-red-500'
                                            : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-emerald-400 hover:text-emerald-500' }}">
                                    {{ $usuario->rol == 1 ? 'Degradar' : 'Promover' }}
                                </button>
                                @if($usuario->rol != 1)
                                    <button type="button"
                                        @click="openPremiumModal = true;
                                                premiumTargetUser = '{{ $usuario->nombre ?? $usuario->name }}';
                                                premiumTargetId = '{{ $usuario->id_usuario ?? $usuario->id }}'"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold border border-amber-300 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                        Premium
                                    </button>
                                @endif
                            </div>
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
            <div class="hidden sm:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/40">
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Usuario</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rol actual</th>
                            <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Suscripción</th>
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
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800/50">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Usuario
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($usuario->rol == 1)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                            Bypass Admin
                                        </span>
                                    @elseif($usuario->activeSubscription?->plan)
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50">
                                                ★ Premium
                                            </span>
                                            <span class="text-[10px] px-2 py-0.5 rounded-md font-semibold
                                                {{ $usuario->activeSubscription->source === 'self_service'
                                                    ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300'
                                                    : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                                                {{ $usuario->activeSubscription->source === 'self_service' ? 'Auto' : 'Admin' }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 dark:text-gray-400">
                                                Hasta {{ optional($usuario->activeSubscription->ends_at)->format('d/m/Y') ?? 'sin fin' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                            Free
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if(auth()->id() !== ($usuario->id_usuario ?? $usuario->id))
                                        <div class="inline-flex items-center gap-2">
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
                                            @if($usuario->rol != 1)
                                                <button type="button"
                                                    @click="openPremiumModal = true;
                                                            premiumTargetUser = '{{ $usuario->nombre ?? $usuario->name }}';
                                                            premiumTargetId = '{{ $usuario->id_usuario ?? $usuario->id }}'"
                                                    class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold border border-amber-300 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                    Premium
                                                </button>
                                            @endif
                                        </div>
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
                                <form :action="'{{ url('admin/usuario') }}/' + targetId + '/rol'" method="POST" x-data="{ loading: false }" @submit="loading = true">
                                    @csrf
                                    <input type="hidden" name="rol" :value="targetAction === 'promocionar' ? 1 : 0">
                                    <button type="submit"
                                            :disabled="loading"
                                            :class="loading ? 'opacity-60 cursor-not-allowed' : ''"
                                            class="w-full py-3 px-6 rounded-xl bg-red-600 hover:bg-red-500 text-white text-sm font-semibold hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <span x-show="!loading">Confirmar acción</span>
                                        <span x-show="loading" class="flex items-center justify-center gap-1.5">
                                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                            </svg>
                                            Procesando…
                                        </span>
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

            {{-- ══════════════════════════════════════
                 MODAL GESTIÓN DE PREMIUM
            ══════════════════════════════════════ --}}
            <template x-teleport="body">
                <div x-show="openPremiumModal"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
                     style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px)"
                     @click.self="openPremiumModal = false"
                     @keydown.escape.window="openPremiumModal = false">

                    <div x-show="openPremiumModal"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         @click.stop
                         class="relative w-full sm:max-w-lg rounded-t-3xl sm:rounded-3xl bg-white dark:bg-gray-900 shadow-2xl overflow-hidden">

                        {{-- Cabecera del modal con gradiente amber --}}
                        <div class="relative bg-gradient-to-br from-amber-500 to-orange-600 px-6 pt-5 pb-6 overflow-hidden">
                            {{-- Decoración --}}
                            <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full bg-white/10"></div>
                            <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-white/10"></div>

                            <button @click="openPremiumModal = false"
                                    class="absolute top-4 right-4 w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>

                            <div class="relative">
                                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-black text-white">Gestionar Suscripción Premium</h3>
                                <p class="text-sm text-white/75 mt-0.5">
                                    Usuario: <span class="font-bold text-white" x-text="premiumTargetUser"></span>
                                </p>
                            </div>
                        </div>

                        {{-- Cuerpo del formulario --}}
                        <form :action="'{{ url('admin/usuario') }}/' + premiumTargetId + '/premium'"
                              method="POST"
                              x-data="{ loading: false }"
                              @submit="loading = true"
                              class="px-6 py-5 space-y-4">
                            @csrf

                            {{-- Selector de plan --}}
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">Plan</label>
                                <select name="plan_id"
                                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                                    @foreach($subscriptionPlans as $plan)
                                        <option value="{{ $plan->id }}">
                                            {{ $plan->name }}
                                            @if($plan->price_cents > 0)
                                                ({{ number_format($plan->price_cents / 100, 2, ',', '.') }}€)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Fechas --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">Inicio <span class="normal-case font-normal">(opcional)</span></label>
                                    <input type="date" name="starts_at"
                                           class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">Fin <span class="normal-case font-normal">(opcional)</span></label>
                                    <input type="date" name="ends_at"
                                           class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                                </div>
                            </div>

                            {{-- Notas --}}
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">Notas internas</label>
                                <textarea name="notes" rows="3" placeholder="Motivo de la activación o cambio…"
                                          class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"></textarea>
                            </div>

                            {{-- Botones de acción --}}
                            <div class="flex flex-col gap-2 pt-1">
                                <button type="submit"
                                        :disabled="loading"
                                        :class="loading ? 'opacity-70 cursor-not-allowed' : 'hover:bg-amber-600'"
                                        class="w-full py-2.5 rounded-xl bg-amber-500 text-white text-sm font-bold transition flex items-center justify-center gap-2">
                                    <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                    <span x-text="loading ? 'Guardando…' : 'Guardar plan'"></span>
                                </button>
                                <button type="button"
                                        @click="openPremiumModal = false"
                                        class="w-full py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    Cerrar
                                </button>
                            </div>
                        </form>

                        {{-- Zona de cancelación --}}
                        <div class="px-6 pb-5"
                             x-data="{ confirmCancel: false }">
                            <div class="rounded-xl border border-dashed border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/10 p-4">
                                <p class="text-xs font-semibold text-red-700 dark:text-red-400 mb-2">Zona de peligro</p>
                                <div x-show="!confirmCancel">
                                    <form :action="'{{ url('admin/usuario') }}/' + premiumTargetId + '/premium/cancel'" method="POST">
                                        @csrf
                                        <button @click="confirmCancel = true"
                                                type="button"
                                                class="text-xs font-semibold text-red-600 dark:text-red-400 hover:underline">
                                            Cancelar suscripción premium de este usuario →
                                        </button>
                                    </form>
                                </div>
                                <div x-show="confirmCancel" class="space-y-2">
                                    <p class="text-xs text-red-700 dark:text-red-400">¿Confirmar cancelación? El usuario perderá acceso inmediatamente.</p>
                                    <div class="flex gap-2">
                                        <form :action="'{{ url('admin/usuario') }}/' + premiumTargetId + '/premium/cancel'" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition">
                                                Confirmar
                                            </button>
                                        </form>
                                        <button @click="confirmCancel = false"
                                                class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-xs font-semibold text-gray-600 dark:text-gray-300">
                                            No, cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
</x-app-layout>
