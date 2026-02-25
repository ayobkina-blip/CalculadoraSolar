{{-- Actualización: nav autenticado fijo y responsive con coherencia visual, accesibilidad y menú móvil mejorado sin romper lógica Blade/Alpine. --}}
<nav x-data="{ open: false }" @keydown.escape.window="open = false"
    class="fixed top-0 w-full z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-sm">
    @php
        // Definir enlaces de navegación una sola vez para reutilización.
        $navLinks = [
            ['route' => 'dashboard', 'label' => 'Inicio'],
            ['route' => 'solar.calculadora', 'label' => 'Calculadora'],
            ['route' => 'solar.presupuestos', 'label' => 'Mis Proyectos'],
            ['route' => 'solar.estadisticas', 'label' => 'Métricas'],
            ['route' => 'premium.index', 'label' => 'Premium'],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 md:h-[72px] flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 lg:gap-8 min-w-0">
                {{-- LOGO --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-3 group rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <div
                        class="bg-amber-600 rounded-xl p-1.5 shadow-sm transition-all duration-200 ease-in-out group-hover:shadow-md">
                        <x-application-logo class="block h-7 w-auto fill-current text-white" />
                    </div>
                    <span class="text-lg lg:text-xl font-black tracking-tight text-gray-900 dark:text-white uppercase">
                        Solar<span class="text-amber-500">Calc</span>
                    </span>
                </a>

                {{-- LINKS TABLET + DESKTOP (md+) --}}
                <div class="hidden md:flex items-center gap-1 lg:gap-3 min-w-0">
                    @foreach($navLinks as $link)
                        <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])"
                            class="px-2 lg:px-3 py-2 text-sm lg:text-base rounded-lg {{ request()->routeIs($link['route']) ? 'border-amber-600 text-amber-500' : '' }}">
                            {{ __($link['label']) }}
                        </x-nav-link>
                    @endforeach

                    {{-- Enlace admin (solo para administradores) --}}
                    @if(Auth::check() && (Auth::user()->rol == 1 || Auth::user()->es_admin))
                        <x-nav-link :href="route('solar.admin')"
                            :active="request()->routeIs('solar.admin') || request()->routeIs('admin.*')"
                            class="px-2 lg:px-3 py-2 text-sm rounded-lg font-semibold border {{ request()->routeIs('solar.admin') || request()->routeIs('admin.*') ? 'border-amber-600 text-amber-500 bg-amber-50 dark:bg-amber-950/30' : 'border-red-300/80 dark:border-red-700/60 text-red-500 dark:text-red-400 hover:border-red-400 hover:text-red-600 dark:hover:text-red-300' }}">
                            {{ __('Admin') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- ACCIONES DERECHA (md+) --}}
            <div class="hidden md:flex items-center gap-2 lg:gap-4">
                {{-- DARK MODE SWITCH --}}
                <button @click="darkMode = !darkMode" type="button" aria-label="Cambiar tema"
                    class="inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-amber-400 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <span class="relative inline-flex h-5 w-5 items-center justify-center transition-transform duration-200 ease-in-out"
                        :class="{ 'rotate-180': darkMode }">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                            </path>
                        </svg>
                    </span>
                </button>

                {{-- DROPDOWN PERFIL --}}
                <div class="relative z-[70]">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center gap-2.5 px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:border-amber-500 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 group">
                                <div
                                    class="w-9 h-9 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center text-white font-black shadow-sm transition-all duration-200 ease-in-out group-hover:scale-105 overflow-hidden ring-2 ring-amber-200 dark:ring-amber-800">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                            alt="{{ Auth::user()->nombre }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-sm">{{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <span class="max-w-[120px] truncate text-xs uppercase tracking-wide hidden lg:block">
                                    {{ Auth::user()->nombre }}
                                </span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-500 transition-colors duration-200 ease-in-out"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div
                                class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center text-white font-black shadow-sm overflow-hidden ring-2 ring-amber-200 dark:ring-amber-800">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                                alt="{{ Auth::user()->nombre }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sm">{{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->nombre }}</p>
                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 px-1">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span class="text-[9px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">
                                        Sesión activa
                                    </span>
                                </div>
                            </div>

                            <div class="py-2">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="text-xs font-semibold py-3 px-4 mx-2 rounded-lg flex items-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 ease-in-out group">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-500 transition-colors duration-200 ease-in-out"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-amber-500 transition-colors duration-200 ease-in-out">
                                        {{ __('Configurar Perfil') }}
                                    </span>
                                </x-dropdown-link>

                                <div class="border-t border-gray-100 dark:border-gray-700 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 py-3 px-4 mx-2 rounded-lg flex items-center gap-3 transition-all duration-200 ease-in-out group">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>{{ __('Cerrar Sesión') }}</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            {{-- HAMBURGUESA MÓVIL (< md) --}}
            <div class="md:hidden flex items-center gap-2">
                <button @click="darkMode = !darkMode" type="button" aria-label="Cambiar tema"
                    class="inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-amber-400 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>

                <button @click="open = !open" type="button" aria-label="Abrir menú de navegación"
                    :aria-expanded="open.toString()" aria-controls="mobile-private-menu"
                    class="inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <span class="relative block h-5 w-5" aria-hidden="true">
                        <span class="absolute left-0 top-1/2 block h-0.5 w-5 bg-current transition-all duration-200 ease-in-out"
                            :class="open ? 'rotate-45' : '-translate-y-1.5'"></span>
                        <span class="absolute left-0 top-1/2 block h-0.5 w-5 bg-current transition-all duration-200 ease-in-out"
                            :class="open ? 'opacity-0' : 'opacity-100'"></span>
                        <span class="absolute left-0 top-1/2 block h-0.5 w-5 bg-current transition-all duration-200 ease-in-out"
                            :class="open ? '-rotate-45' : 'translate-y-1.5'"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div id="mobile-private-menu" x-cloak x-show="open"
        x-transition:enter="transition-all duration-200 ease-in-out"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition-all duration-200 ease-in-out"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md">
        <div class="px-4 py-4">
            <div class="space-y-1">
                @foreach($navLinks as $link)
                    <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])"
                        x-on:click="open = false"
                        class="text-sm font-semibold">
                        {{ __($link['label']) }}
                    </x-responsive-nav-link>
                @endforeach

                @if(Auth::check() && (Auth::user()->rol == 1 || Auth::user()->es_admin))
                    <x-responsive-nav-link :href="route('solar.admin')"
                        :active="request()->routeIs('solar.admin') || request()->routeIs('admin.*')"
                        x-on:click="open = false"
                        class="text-sm font-semibold {{ request()->routeIs('solar.admin') || request()->routeIs('admin.*') ? 'text-amber-500' : 'text-red-500 dark:text-red-400' }}">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/40 rounded-2xl px-4 py-4">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-11 h-11 bg-amber-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->nombre }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-base">{{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->nombre }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('profile.edit') }}" @click="open = false"
                        class="inline-flex items-center justify-center py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-700 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        {{ __('Perfil') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center py-3 rounded-xl bg-red-50 dark:bg-red-900/20 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            {{ __('Salir') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
