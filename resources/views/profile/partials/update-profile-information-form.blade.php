<section>
    <header class="mb-8">
        <h3 class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-[0.15em] flex items-center gap-2">
            <div class="w-1.5 h-4 bg-amber-500 rounded-full"></div>
            {{ __('Identidad del Usuario') }}
        </h3>
        <p class="mt-2 text-[11px] text-gray-400 font-medium italic">
            {{ __("Gestiona la información pública de tu cuenta y el canal de notificaciones.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <x-input-label for="name" :value="__('Nombre Completo')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1" />
                <x-text-input id="name" name="name" type="text" class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl shadow-sm focus:ring-amber-500 focus:border-amber-500 h-12" :value="old('name', $user->name)" required autofocus />
                <x-input-error class="mt-2 text-[10px] font-bold uppercase" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Dirección de Correo')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1" />
                <x-text-input id="email" name="email" type="email" class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl shadow-sm focus:ring-amber-500 focus:border-amber-500 h-12" :value="old('email', $user->email)" required />
                <x-input-error class="mt-2 text-[10px] font-bold uppercase" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[#1e293b] hover:bg-slate-700 rounded-xl px-8 py-4 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                {{ __('Guardar Cambios') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                    {{ __('✓ Actualizado') }}
                </p>
            @endif
        </div>
    </form>
</section>