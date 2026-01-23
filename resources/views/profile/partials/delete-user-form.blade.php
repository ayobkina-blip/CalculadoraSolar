<section>
    <header class="mb-6">
        <h3 class="text-sm font-black text-red-600 dark:text-red-400 uppercase tracking-[0.15em] flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ __('Acciones Irreversibles') }}
        </h3>
        <p class="mt-2 text-[11px] text-gray-500 font-medium">
            {{ __('La eliminación de la cuenta purgará permanentemente su historial de simulaciones y datos técnicos.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl px-6 py-4 text-[10px] font-black uppercase tracking-widest shadow-sm shadow-red-500/10"
    >
        {{ __('Eliminar cuenta del sistema') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-widest">
                {{ __('Confirmación Requerida') }}
            </h2>

            <p class="mt-3 text-sm text-gray-500">
                {{ __('Para procesar la baja definitiva, ingrese su contraseña actual como medida de seguridad.') }}
            </p>

            <div class="mt-6">
                <x-text-input id="password" name="password" type="password" class="block w-full rounded-xl border-gray-200" placeholder="{{ __('Introduce tu contraseña') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 py-3 text-[10px] font-black uppercase tracking-widest">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-6 py-3 text-[10px] font-black uppercase tracking-widest">
                    {{ __('Confirmar Borrado') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>