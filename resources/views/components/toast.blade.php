@php
    // Sistema de notificaciones mejorado con soporte para múltiples tipos
    $message = session('success') ?? session('error') ?? session('status') ?? session('message');
    $type = 'info';
    if (session('success')) $type = 'success';
    elseif (session('error')) $type = 'error';
    elseif (session('status')) $type = 'info';
    
    // Configuración de colores e iconos según el tipo
    $config = [
        'success' => [
            'bg' => 'bg-emerald-500/20',
            'border' => 'border-emerald-500/40',
            'icon' => 'text-emerald-400',
            'text' => 'text-emerald-400',
            'svg' => 'M5 13l4 4L19 7'
        ],
        'error' => [
            'bg' => 'bg-red-500/20',
            'border' => 'border-red-500/40',
            'icon' => 'text-red-400',
            'text' => 'text-red-400',
            'svg' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
        ],
        'info' => [
            'bg' => 'bg-blue-500/20',
            'border' => 'border-blue-500/40',
            'icon' => 'text-blue-400',
            'text' => 'text-blue-400',
            'svg' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        ]
    ];
    $style = $config[$type] ?? $config['info'];
@endphp

@if ($message)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-[100] max-w-sm w-full"
    >
        <div class="bg-gray-900/95 backdrop-blur-sm border {{ $style['border'] }} shadow-2xl rounded-2xl p-4 flex items-center gap-4">
            {{-- Icono Dinámico según tipo --}}
            <div class="flex-shrink-0 w-10 h-10 {{ $style['bg'] }} rounded-xl flex items-center justify-center border {{ $style['border'] }}">
                <svg class="w-6 h-6 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $style['svg'] }}"></path>
                </svg>
            </div>

            <div class="flex-1">
                <p class="text-[9px] font-black uppercase tracking-widest {{ $style['text'] }}">
                    @if($type === 'success') Operación Exitosa
                    @elseif($type === 'error') Error del Sistema
                    @else Notificación
                    @endif
                </p>
                <p class="text-[11px] text-gray-200 font-medium mt-0.5 leading-relaxed">
                    {{ $message }}
                </p>
            </div>

            <button @click="show = false" class="text-gray-500 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif