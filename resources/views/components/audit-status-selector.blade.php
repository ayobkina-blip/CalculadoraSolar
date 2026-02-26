@props(['status', 'action'])

<div x-data="{ 
    currentStatus: '{{ $status }}',
    open: false,
    config: {
        pendiente: { label: 'Pendiente', color: 'text-amber-600 dark:text-amber-400', bg: 'bg-amber-50 dark:bg-amber-900/30', border: 'border-amber-200 dark:border-amber-800/50', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
        aprobado: { label: 'Aprobado', color: 'text-emerald-600 dark:text-emerald-400', bg: 'bg-emerald-50 dark:bg-emerald-900/30', border: 'border-emerald-200 dark:border-emerald-800/50', icon: 'M5 13l4 4L19 7' },
        rechazado: { label: 'Rechazado', color: 'text-rose-600 dark:text-rose-400', bg: 'bg-rose-50 dark:bg-rose-900/30', border: 'border-rose-200 dark:border-rose-800/50', icon: 'M6 18L18 6M6 6l12 12' }
    }
}" class="relative inline-block text-left">
    
    <button @click="open = !open" type="button" 
            :class="config[currentStatus].bg + ' ' + config[currentStatus].border + ' ' + config[currentStatus].color"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all duration-200 hover:shadow-md active:scale-95 focus:outline-none">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="config[currentStatus].icon"/>
        </svg>
        <span x-text="config[currentStatus].label"></span>
        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 w-40 origin-top-right rounded-2xl bg-white dark:bg-gray-900 shadow-2xl border border-gray-100 dark:border-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
         x-cloak>
        <div class="py-1">
            <template x-for="(c, key) in config">
                <form :action="'{{ $action }}'" method="POST">
                    @csrf
                    <input type="hidden" name="estado" :value="key">
                    <button type="submit" 
                            class="group flex w-full items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                            :class="currentStatus === key ? 'bg-gray-50/50 dark:bg-gray-800/50 pointer-events-none opacity-50' : ''">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center transition-colors"
                             :class="c.bg + ' ' + c.color">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="c.icon"/>
                            </svg>
                        </div>
                        <span x-text="c.label"></span>
                        <svg x-show="currentStatus === key" class="w-4 h-4 ml-auto text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>
            </template>
        </div>
    </div>
</div>
