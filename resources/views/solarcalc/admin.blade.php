<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            {{ __('Gestión Administrativa de SolarCalc') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- SECCIÓN 1: AUDITORÍA DE SIMULACIONES --}}
            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 sm:rounded-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">Auditoría de Simulaciones</h3>
                        <p class="text-xs text-gray-500 mt-1 font-medium">Validación de registros para cálculo de métricas globales.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Usuario</th>
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Potencia</th>
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Estado</th>
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            {{-- Cambiado a @forelse para mayor seguridad profesional --}}
                            @forelse($todosLosPresupuestos as $item)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[10px] font-bold text-gray-500">
                                            {{ strtoupper(substr($item->usuario->nombre ?? $item->usuario->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            {{-- Ajuste dinámico de nombre según tu modelo --}}
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-200">
                                                {{ $item->usuario->nombre ?? $item->usuario->name ?? 'Invitado' }}
                                            </span>
                                            <span class="text-[9px] font-mono text-gray-400 uppercase">REF: {{ $item->id_resultado }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ number_format($item->potencia_instalacion_kwp, 2) }} <span class="text-[10px] font-bold opacity-50">kWp</span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    @php
                                        $color = [
                                            'verificado' => 'emerald',
                                            'pendiente' => 'slate',
                                            'rechazado' => 'rose'
                                        ][$item->estado ?? 'pendiente'];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-{{ $color }}-200 bg-{{ $color }}-50 text-{{ $color }}-700 dark:bg-{{ $color }}-900/20 dark:text-{{ $color }}-400">
                                        {{ $item->estado ?? 'pendiente' }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <form action="{{ route('admin.cambiarEstado', $item->id_resultado) }}" method="POST" class="inline-block">
                                        @csrf
                                        <select name="nuevo_estado" onchange="this.form.submit()" class="text-[10px] font-bold bg-transparent border-gray-200 dark:border-gray-700 rounded p-1 dark:text-gray-300 cursor-pointer">
                                            <option value="pendiente" {{ ($item->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="verificado" {{ ($item->estado ?? '') == 'verificado' ? 'selected' : '' }}>Verificar</option>
                                            <option value="rechazado" {{ ($item->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazar</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-sm text-gray-400 italic">No hay simulaciones registradas para auditar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SECCIÓN 2: CONTROL DE USUARIOS --}}
            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 sm:rounded-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">Control de Usuarios</h3>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Gestión de privilegios y niveles de acceso al sistema.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Identidad</th>
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Rango</th>
                                <th class="px-8 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($usuarios as $usuario)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $usuario->nombre ?? $usuario->name }}</span>
                                        <span class="text-[10px] text-gray-400 font-mono">{{ $usuario->email }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    {{-- Ajustado para leer el campo 'rol' basándome en SolarController --}}
                                    @php $isAdmin = ($usuario->rol == 1 || ($usuario->es_admin ?? false)); @endphp
                                    <span class="px-2 py-0.5 text-[9px] font-bold rounded border {{ $isAdmin ? 'border-red-200 text-red-600 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 text-gray-500 bg-gray-50 dark:bg-gray-800' }}">
                                        {{ $isAdmin ? 'ADMINISTRADOR' : 'USUARIO' }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    {{-- Usando id_usuario como identificador principal --}}
                                    <form action="{{ route('admin.cambiarRol', $usuario->id_usuario ?? $usuario->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold uppercase py-1.5 px-3 rounded border border-gray-200 dark:border-gray-700 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                                            Cambiar Rango
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center text-sm text-gray-400 italic">No se encontraron usuarios en la base de datos.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>