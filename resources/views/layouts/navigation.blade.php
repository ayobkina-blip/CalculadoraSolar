<nav x-data="{ open: false }"
    class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 transition-all duration-300 sticky top-0 z-[60] shadow-sm dark:shadow-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-18 py-3">
            <div class="flex">
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div
                            class="bg-amber-500 rounded-xl p-1.5 transition-transform group-hover:rotate-6 duration-300 shadow-lg shadow-amber-500/20">
                            <x-application-logo class="block h-7 w-auto fill-current text-white" />
                        </div>
                        <span class="text-xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">
                            Solar<span class="text-amber-500">Calc</span>
                        </span>
                    </a>
                </div>

                {{-- LINKS DE NAVEGACIÓN --}}
                @php
                // Definir enlaces de navegación una sola vez para reutilización
                $navLinks = [
                ['route' => 'dashboard', 'label' => 'Inicio'],
                ['route' => 'solar.calculadora', 'label' => 'Calculadora'],
                ['route' => 'solar.presupuestos', 'label' => 'Mis Proyectos'],
                ['route' => 'solar.estadisticas', 'label' => 'Métricas'],
                ];
                @endphp

                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    @foreach($navLinks as $link)
                    <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])"
                        class="text-[10px] font-black uppercase tracking-widest transition-all px-4 py-2 rounded-xl border-none hover:bg-slate-50 dark:hover:bg-slate-800 {{ request()->routeIs($link['route']) ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-amber-900/10' : '' }}">
                        {{ __($link['label']) }}
                    </x-nav-link>
                    @endforeach

                    {{-- Enlace al panel de administración (solo visible para administradores) --}}
                    @if(Auth::check() && (Auth::user()->rol == 1 || Auth::user()->es_admin))
                    <x-nav-link :href="route('solar.admin')"
                        :active="request()->routeIs('solar.admin') || request()->routeIs('admin.*')"
                        class="text-[10px] font-black uppercase tracking-widest text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 px-4 py-2 rounded-xl border-none {{ request()->routeIs('solar.admin') || request()->routeIs('admin.*') ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                        {{ __('Admin Panel') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- BOTONES DERECHA --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">

                {{-- DARK MODE SWITCH --}}
                <button @click="darkMode = !darkMode"
                    class="p-2.5 rounded-xl text-gray-400 dark:text-amber-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-all border border-transparent hover:border-gray-200 dark:hover:border-slate-700 active:scale-90">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                        </path>
                    </svg>
                </button>

                {{-- DROPDOWN DE PERFIL MEJORADO --}}
                <div class="relative z-[70]">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:shadow-lg hover:border-amber-300 dark:hover:border-amber-600 transition-all group backdrop-blur-sm">
                                <div
                                    class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center text-white font-black shadow-md group-hover:scale-110 transition-transform overflow-hidden ring-2 ring-amber-200 dark:ring-amber-800">
                                    @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        alt="{{ Auth::user()->nombre }}" class="w-full h-full object-cover">
                                    @else
                                    <span class="text-sm">{{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1))
                                        }}</span>
                                    @endif
                                </div>
                                <span
                                    class="max-w-[100px] truncate font-semibold text-xs uppercase tracking-wide hidden sm:block">{{
                                    Auth::user()->nombre }}</span>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div
                                class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-900">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center text-white font-black shadow-md overflow-hidden ring-2 ring-amber-200 dark:ring-amber-800">
                                        @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                            alt="{{ Auth::user()->nombre }}" class="w-full h-full object-cover">
                                        @else
                                        <span class="text-sm">{{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1))
                                            }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-slate-900 dark:text-white truncate">{{
                                            Auth::user()->nombre }}</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate mt-0.5">{{
                                            Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 px-1">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span
                                        class="text-[9px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Sesión
                                        Activa</span>
                                </div>
                            </div>

                            <div class="py-2">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="text-xs font-semibold py-3 px-4 hover:bg-amber-50 dark:hover:bg-amber-900/20 mx-2 rounded-lg flex items-center gap-3 transition-all group">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span
                                        class="text-slate-700 dark:text-slate-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{
                                        __('Configurar Perfil') }}</span>
                                </x-dropdown-link>

                                <div class="border-t border-slate-100 dark:border-slate-700 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 py-3 px-4 mx-2 rounded-lg flex items-center gap-3 transition-all group">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            {{-- HAMBURGUESA MÓVIL --}}
            <div class="-me-2 flex items-center sm:hidden gap-2">
                <button @click="darkMode = !darkMode" class="p-2 text-gray-400 dark:text-amber-400">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button @click="open = ! open"
                    class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 focus:outline-none transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL DESPLEGABLE --}}
    <div :class="{'block': open, 'hidden': ! open}" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="hidden sm:hidden bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            @foreach($navLinks as $link)
            <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])"
                class="text-[10px] font-black uppercase tracking-widest py-4 border-none {{ request()->routeIs($link['route']) ? 'text-amber-500 bg-amber-50/50 dark:bg-amber-900/10' : '' }}">
                {{ __($link['label']) }}
            </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="pt-4 pb-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 px-6">
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white font-black shadow-lg overflow-hidden">
                    @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-lg">{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}</span>
                    @endif
                </div>
                <div>
                    <div class="font-black text-sm text-slate-900 dark:text-white uppercase tracking-tight">{{
                        Auth::user()->nombre }}</div>
                    <div class="font-mono text-[10px] text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center justify-center py-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-300">
                    {{ __('Perfil') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center py-3 bg-red-50 dark:bg-red-900/20 rounded-xl text-[10px] font-black uppercase tracking-widest text-red-500">
                        {{ __('Salir') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>