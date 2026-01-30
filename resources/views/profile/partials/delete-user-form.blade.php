<section x-data="{ confirmingUserDeletion: false }" class="space-y-6">
    <header class="flex items-center gap-4">
        <div class="p-3 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </div>
        <div>
            <h2 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">
                {{ __('Eliminación Permanente') }}
            </h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 font-medium italic">
                Esta acción purgará todos tus presupuestos y datos del servidor.
            </p>
        </div>
    </header>

    <x-danger-button
        class="rounded-2xl py-4 px-8 text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-rose-200 dark:shadow-none"
        @click="confirmingUserDeletion = true"
    >{{ __('Eliminar Cuenta') }}</x-danger-button>

    {{-- MODAL DE ELIMINACIÓN --}}
    <template x-teleport="body">
        <div x-show="confirmingUserDeletion" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            
            {{-- Fondo desenfocado --}}
            <div x-show="confirmingUserDeletion" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="confirmingUserDeletion = false" 
                 class="absolute inset-0 bg-slate-950/60 backdrop-blur-md"></div>

            {{-- Contenido del Modal --}}
            <div x-show="confirmingUserDeletion"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-slate-200 dark:border-slate-800 p-10 overflow-hidden">
                
                <div class="absolute top-0 left-0 w-full h-2 bg-rose-600"></div>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-full flex items-center justify-center mb-6 ring-8 ring-rose-50 dark:ring-rose-900/10">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>

                        <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                            Confirmar Borrado
                        </h2>

                        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            Una vez eliminada la cuenta, no hay marcha atrás. Por favor, introduce tu contraseña para confirmar que eres el titular del sistema.
                        </p>

                        <div class="mt-8 w-full">
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full text-center bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-2xl py-4 font-black"
                                placeholder="{{ __('Contraseña de Verificación') }}"
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-10 flex flex-col sm:flex-row gap-3 w-full">
                            <button type="button" @click="confirmingUserDeletion = false" class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                {{ __('Cancelar') }}
                            </button>
                            <button type="submit" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-rose-200 dark:shadow-none transition-all active:scale-95">
                                {{ __('Confirmar Destrucción') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </template>
</section>