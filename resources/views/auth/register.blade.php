<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Título -->
        <div class="text-center mb-6">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mb-2">Crear Cuenta</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Únete a la comunidad SolarCalc</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" />
            <x-text-input id="name" 
                         class="block w-full h-12 px-4 rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" 
                         type="text" 
                         name="name" 
                         :value="old('name')" 
                         required 
                         autofocus 
                         autocomplete="name"
                         placeholder="Juan Pérez" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" />
            <x-text-input id="email" 
                         class="block w-full h-12 px-4 rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" 
                         type="email" 
                         name="email" 
                         :value="old('email')" 
                         required 
                         autocomplete="username"
                         placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" />
            <x-text-input id="password" 
                         class="block w-full h-12 px-4 rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all"
                         type="password"
                         name="password"
                         required 
                         autocomplete="new-password"
                         placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
            <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">La contraseña debe tener al menos 8 caracteres</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" />
            <x-text-input id="password_confirmation" 
                         class="block w-full h-12 px-4 rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all"
                         type="password"
                         name="password_confirmation" 
                         required 
                         autocomplete="new-password"
                         placeholder="Repite tu contraseña" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full h-12 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl transition-all">
                {{ __('Crear Cuenta') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-gray-200 dark:border-slate-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                    Inicia sesión aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
