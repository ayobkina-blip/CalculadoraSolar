<section>
    <header class="mb-8">
        <h3 class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-[0.15em] flex items-center gap-2">
            <div class="w-1.5 h-4 bg-[#1e293b] dark:bg-gray-200 rounded-full"></div>
            {{ __('Seguridad de la Cuenta') }}
        </h3>
        <p class="mt-2 text-[11px] text-gray-400 font-medium italic">
            {{ __('Se recomienda cambiar la contraseña periódicamente para proteger sus datos.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="max-w-xl space-y-5">
            <div>
                <x-input-label for="current_password" :value="__('Contraseña Actual')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1" />
                <x-text-input id="current_password" name="current_password" type="password" class="block w-full rounded-xl border-gray-200 h-12" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] font-bold uppercase" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" :value="__('Nueva Contraseña')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1" />
                    <x-text-input id="password" name="password" type="password" class="block w-full rounded-xl border-gray-200 h-12" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Nueva')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-xl border-gray-200 h-12" />
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
        </div>

        <div class="pt-4">
            <x-primary-button class="bg-[#1e293b] hover:bg-slate-700 rounded-xl px-8 py-4 text-[10px] font-black uppercase tracking-widest shadow-md">
                {{ __('Actualizar Credenciales') }}
            </x-primary-button>
        </div>
    </form>
</section>