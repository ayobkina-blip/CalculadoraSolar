<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Título -->
        <div class="text-center mb-6">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mb-2">Iniciar Sesión</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Accede a tu cuenta de SolarCalc</p>
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
                         autofocus 
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
                         autocomplete="current-password"
                         placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-amber-600 shadow-sm focus:ring-amber-500 focus:ring-offset-0" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 font-medium underline transition-colors" 
                   href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full h-12 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl transition-all">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-200 dark:border-slate-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                ¿No tienes cuenta? 
                <a href="{{ route('register') }}" class="font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
