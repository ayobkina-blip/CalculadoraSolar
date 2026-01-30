<section>
    <header class="mb-8">
        <h3 class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-[0.15em] flex items-center gap-3">
            <div class="w-1.5 h-4 bg-slate-700 dark:bg-amber-500 rounded-full shadow-[0_0_8px_rgba(30,41,59,0.3)]"></div>
            {{ __('Seguridad de la Cuenta') }}
        </h3>
        <p class="mt-2 text-[11px] text-gray-400 font-medium italic">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantener la seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="max-w-2xl space-y-6">
            {{-- Contraseña Actual --}}
            <div class="group">
                <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1 transition-colors group-focus-within:text-amber-500" />
                <div class="relative">
                    <x-text-input id="update_password_current_password" name="current_password" type="password" 
                        class="block w-full border-gray-100 dark:border-gray-700 dark:bg-gray-900 rounded-2xl shadow-sm focus:ring-amber-500 focus:border-amber-500 h-14 pl-5 transition-all focus:-translate-y-1" 
                        autocomplete="current-password" />
                    <div class="absolute right-4 top-4 text-gray-300 dark:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] font-bold uppercase tracking-tight" />
            </div>

            {{-- Fila: Nueva y Confirmación --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                    <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1 transition-colors group-focus-within:text-amber-500" />
                    <div class="relative">
                        <x-text-input id="update_password_password" name="password" type="password" 
                            class="block w-full border-gray-100 dark:border-gray-700 dark:bg-gray-900 rounded-2xl shadow-sm focus:ring-amber-500 focus:border-amber-500 h-14 pl-5 transition-all focus:-translate-y-1" 
                            autocomplete="new-password" />
                    </div>
                </div>

                <div class="group">
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Nueva')" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1 transition-colors group-focus-within:text-amber-500" />
                    <div class="relative">
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                            class="block w-full border-gray-100 dark:border-gray-700 dark:bg-gray-900 rounded-2xl shadow-sm focus:ring-amber-500 focus:border-amber-500 h-14 pl-5 transition-all focus:-translate-y-1" 
                            autocomplete="new-password" />
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-[10px] font-bold uppercase tracking-tight" />
        </div>

        <div class="flex items-center gap-6 pt-4">
            <x-primary-button class="bg-[#1e293b] dark:bg-amber-600 hover:bg-slate-800 dark:hover:bg-amber-500 rounded-2xl px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-slate-900/10 active:scale-95 border-none">
                {{ __('Actualizar Llaves') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                    class="flex items-center gap-2 text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/20 px-4 py-2 rounded-full border border-emerald-100 dark:border-emerald-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    {{ __('Seguridad Reforzada') }}
                </div>
            @endif
        </div>
    </form>
</section>