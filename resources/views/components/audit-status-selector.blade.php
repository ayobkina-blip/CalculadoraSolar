@props(['status', 'action'])

{{--
    BUGFIX: $refs.btn no es accesible dentro de x-teleport porque Alpine
    pierde la referencia al salir del scope del componente.
    Solución: capturar las coordenadas en el momento del click y guardarlas
    en las variables dropdownTop / dropdownLeft del estado del componente.
--}}

<div x-data="{
    currentStatus: '{{ $status }}',
    open: false,
    dropdownTop: 0,
    dropdownLeft: 0,
    dropdownRight: false,
    config: {
        pendiente:  { label: 'Pendiente',  color: 'text-amber-600 dark:text-amber-400',   bg: 'bg-amber-50 dark:bg-amber-900/30',   border: 'border-amber-200 dark:border-amber-700',   icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
        aprobado:   { label: 'Aprobado',   color: 'text-emerald-600 dark:text-emerald-400', bg: 'bg-emerald-50 dark:bg-emerald-900/30', border: 'border-emerald-200 dark:border-emerald-700', icon: 'M5 13l4 4L19 7' },
        rechazado:  { label: 'Rechazado',  color: 'text-rose-600 dark:text-rose-400',     bg: 'bg-rose-50 dark:bg-rose-900/30',     border: 'border-rose-200 dark:border-rose-700',     icon: 'M6 18L18 6M6 6l12 12' }
    },
    toggle(event) {
        if (this.open) { this.open = false; return; }
        const rect = event.currentTarget.getBoundingClientRect();
        const dropdownWidth = 192; // w-48
        const spaceRight = window.innerWidth - rect.left;
        this.dropdownRight  = spaceRight < dropdownWidth + 8;
        this.dropdownTop    = rect.bottom + window.scrollY + 6;
        this.dropdownLeft   = this.dropdownRight
            ? Math.max(8, rect.right + window.scrollX - dropdownWidth)
            : rect.left + window.scrollX;
        this.open = true;
    }
}" class="relative inline-block text-left">

    {{-- ── Botón trigger ── --}}
    <button
        @click="toggle($event)"
        type="button"
        :class="config[currentStatus].bg + ' ' + config[currentStatus].border + ' ' + config[currentStatus].color"
        class="inline-flex items-center gap-1.5 pl-2.5 pr-2 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all duration-150 hover:shadow-sm active:scale-95 focus:outline-none select-none"
    >
        {{-- Icono de estado --}}
        <span class="w-4 h-4 rounded-md flex items-center justify-center shrink-0"
              :class="config[currentStatus].bg">
            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="config[currentStatus].icon"/>
            </svg>
        </span>
        <span x-text="config[currentStatus].label"></span>
        {{-- Chevron animado --}}
        <svg class="w-2.5 h-2.5 opacity-50 transition-transform duration-150"
             :class="open ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- ── Dropdown teleportado al body para evitar overflow en tablas ── --}}
    <template x-teleport="body">
        <div
            x-show="open"
            @click.outside="open = false"
            @keydown.escape.window="open = false"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            :style="`position:fixed; z-index:9999; top:${dropdownTop}px; left:${dropdownLeft}px; width:12rem`"
            class="rounded-2xl bg-white dark:bg-gray-900 shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden"
            x-cloak
        >
            {{-- Cabecera del dropdown --}}
            <div class="px-3 pt-3 pb-2 border-b border-gray-100 dark:border-gray-700/60">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500">Cambiar estado</p>
            </div>

            {{-- Opciones --}}
            <div class="p-1.5 space-y-0.5">
                <template x-for="(c, key) in config" :key="key">
                    <form :action="'{{ $action }}'" method="POST" class="block">
                        @csrf
                        <input type="hidden" name="estado" :value="key">
                        <button
                            type="submit"
                            :disabled="currentStatus === key"
                            :class="currentStatus === key
                                ? c.bg + ' ' + c.color + ' opacity-100 cursor-default'
                                : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'"
                            class="group flex w-full items-center gap-2.5 px-2.5 py-2 rounded-xl text-[10px] font-bold uppercase tracking-wider transition-colors duration-100 focus:outline-none"
                        >
                            {{-- Icono de la opción --}}
                            <span class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 transition-colors"
                                  :class="currentStatus === key ? c.color + ' ' + c.bg : 'bg-gray-100 dark:bg-gray-800 text-gray-400 group-hover:' + c.bg + ' group-hover:' + c.color">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="c.icon"/>
                                </svg>
                            </span>

                            <span x-text="c.label" class="flex-1 text-left"></span>

                            {{-- Check si es el estado actual --}}
                            <svg x-show="currentStatus === key"
                                 class="w-3.5 h-3.5 shrink-0"
                                 :class="c.color"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                </template>
            </div>
        </div>
    </template>
</div>