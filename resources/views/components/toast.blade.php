@php
    // Definimos qué llaves de sesión queremos escuchar
    $message = session('success') ?? session('status') ?? session('message');
    $type = session('success') ? 'success' : 'info';
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
        <div class="bg-gray-900/95 backdrop-blur-sm border border-emerald-500/30 shadow-2xl rounded-2xl p-4 flex items-center gap-4">
            {{-- Icono Dinámico --}}
            <div class="flex-shrink-0 w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center border border-emerald-500/40">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <div class="flex-1">
                <p class="text-[9px] font-black uppercase tracking-widest text-emerald-400">Notificación del Sistema</p>
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