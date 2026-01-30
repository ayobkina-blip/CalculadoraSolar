<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            {{ __('Gestión Administrativa de SolarCalc') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- KPIS DE RENDIMIENTO --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['label' => 'Simulaciones', 'value' => $todosLosPresupuestos->count(), 'color' => 'blue', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label' => 'Pendientes', 'value' => $todosLosPresupuestos->where('estado', 'pendiente')->count(), 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Aprobados', 'value' => $todosLosPresupuestos->where('estado', 'aprobado')->count(), 'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Ingenieros', 'value' => $usuarios->count(), 'color' => 'red', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z']
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-5 dark:opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-24 h-24 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $stat['value'] }}</p>
                </div>
                @endforeach
            </div>
            
            {{-- TABLA DE PRESUPUESTOS --}}
            <div class="bg-white dark:bg-slate-900 shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800 rounded-[2.5rem] overflow-hidden">
                <div class="px-8 py-7 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-6 bg-red-600 rounded-full"></div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">Auditoría de Sistemas</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Operador</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Carga Técnica</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Estado</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($todosLosPresupuestos as $item)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-11 w-11 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-slate-700 shadow-inner group-hover:bg-white dark:group-hover:bg-slate-700 transition-colors">
                                            <span class="text-sm font-black text-slate-500 dark:text-slate-400">
                                                {{ strtoupper(substr($item->usuario->nombre ?? $item->usuario->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $item->usuario->nombre ?? $item->usuario->name ?? 'Invitado' }}</span>
                                            <span class="text-[10px] font-mono text-red-600 dark:text-red-400 font-black">ID_LOG: #{{ $item->id_resultado }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($item->potencia_instalacion_kwp, 2) }} kWp</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Producción Estimada</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusConfig = [
                                            'aprobado' => ['color' => 'emerald', 'icon' => 'M5 13l4 4L19 7'],
                                            'pendiente' => ['color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'rechazado' => ['color' => 'rose', 'icon' => 'M6 18L18 6M6 6l12 12'],
                                        ][$item->estado ?? 'pendiente'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border border-{{ $statusConfig['color'] }}-200 bg-{{ $statusConfig['color'] }}-50 text-{{ $statusConfig['color'] }}-700 dark:bg-{{ $statusConfig['color'] }}-900/30 dark:text-{{ $statusConfig['color'] }}-400 dark:border-{{ $statusConfig['color'] }}-800/50">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $statusConfig['icon'] }}" />
                                        </svg>
                                        {{ $item->estado ?? 'pendiente' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <form action="{{ route('admin.cambiarEstado', $item->id_resultado) }}" method="POST" class="flex justify-end">
                                        @csrf
                                        <div class="relative inline-flex items-center">
                                            <select name="estado" onchange="this.form.submit()" class="appearance-none text-[10px] font-black uppercase py-2.5 pl-4 pr-10 rounded-2xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 focus:ring-0 focus:border-red-500 transition-all cursor-pointer shadow-sm group-hover:border-slate-400">
                                                <option value="pendiente" {{ ($item->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Revisar</option>
                                                <option value="aprobado" {{ ($item->estado ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobar</option>
                                                <option value="rechazado" {{ ($item->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Denegar</option>
                                            </select>
                                            <div class="absolute right-3 pointer-events-none text-slate-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- ... --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- GESTIÓN DE RANGOS CON MODAL PROFESIONAL --}}
            <div x-data="{ openModal: false, targetUser: '', targetId: '', targetAction: '' }" class="bg-slate-900 dark:bg-white p-[2px] rounded-[2.5rem] shadow-2xl relative">
                <div class="bg-white dark:bg-slate-900 rounded-[2.45rem] overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Control de Autoridades</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($usuarios as $usuario)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-all">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-800 dark:text-white">{{ $usuario->nombre ?? $usuario->name }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono tracking-wider">{{ $usuario->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @if(auth()->id() !== ($usuario->id_usuario ?? $usuario->id))
                                            {{-- El botón ahora dispara el modal en lugar de enviar el form directo --}}
                                            <button type="button" 
                                                @click="openModal = true; 
                                                        targetUser = '{{ $usuario->nombre ?? $usuario->name }}'; 
                                                        targetId = '{{ $usuario->id_usuario ?? $usuario->id }}';
                                                        targetAction = '{{ $usuario->rol == 1 ? 'degradar' : 'promocionar' }}'"
                                                class="group relative inline-flex items-center gap-2 text-[10px] font-black uppercase py-3 px-8 rounded-2xl bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:scale-[1.02] active:scale-95 transition-all shadow-xl">
                                                <span>{{ $usuario->rol == 1 ? 'Degradar' : 'Promocionar' }}</span>
                                                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        @else
                                            <span class="flex items-center justify-end gap-2 text-[10px] font-black uppercase text-emerald-500 tracking-widest">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                                Sesión Maestra
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ESTRUCTURA DEL MODAL --}}
                <template x-teleport="body">
                    <div x-show="openModal" 
                        class="fixed inset-0 z-[99] flex items-center justify-center overflow-hidden" 
                        x-cloak>
                        
                        {{-- Backdrop (Fondo desenfocado) --}}
                        <div x-show="openModal" 
                            x-transition:enter="ease-out duration-300" 
                            x-transition:enter-start="opacity-0" 
                            x-transition:enter-end="opacity-100" 
                            x-transition:leave="ease-in duration-200" 
                            x-transition:leave-start="opacity-100" 
                            x-transition:leave-end="opacity-0" 
                            @click="openModal = false" 
                            class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm"></div>

                        {{-- Contenido del Modal --}}
                        <div x-show="openModal" 
                            x-transition:enter="ease-out duration-300" 
                            x-transition:enter-start="opacity-0 scale-90 translate-y-4" 
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                            x-transition:leave="ease-in duration-200" 
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                            x-transition:leave-end="opacity-0 scale-90 translate-y-4" 
                            class="relative w-full max-w-md p-8 bg-white dark:bg-slate-900 shadow-2xl rounded-[3rem] border border-slate-200 dark:border-slate-800">
                            
                            <div class="flex flex-col items-center text-center">
                                {{-- Icono de Advertencia --}}
                                <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-full mb-6 text-red-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>

                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight leading-tight">
                                    Confirmar cambio <br> de jerarquía
                                </h3>
                                
                                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400 font-medium">
                                    ¿Estás seguro de que deseas <span class="text-red-600 font-black uppercase" x-text="targetAction"></span> al usuario <span class="text-slate-900 dark:text-white font-bold" x-text="targetUser"></span>? Esta acción afecta inmediatamente los permisos de acceso.
                                </p>

                                <div class="mt-8 flex flex-col w-full gap-3">
                                    {{-- Formulario dinámico --}}
                                    <form :action="'{{ url('admin/usuario') }}/' + targetId + '/rol'" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-4 px-6 bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-red-200 dark:shadow-none transition-all active:scale-95">
                                            Confirmar Acción
                                        </button>
                                    </form>

                                    <button @click="openModal = false" class="w-full py-4 px-6 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 text-xs font-black uppercase tracking-widest transition-colors">
                                        Cancelar y volver
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>
    </div>
</x-app-layout>