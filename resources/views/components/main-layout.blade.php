<!DOCTYPE html>
{{-- Actualización: nave pública fija, responsive y accesible con comportamiento consistente en móvil/tablet/escritorio. --}}
<html lang="es" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SolarCalc | Energía Inteligente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white dark:bg-[#0f172a] antialiased font-sans text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <header>
            <nav x-data="{ open: false }" @keydown.escape.window="open = false"
                class="fixed top-0 w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="h-16 md:h-[72px] flex items-center justify-between gap-4">

                        {{-- Logo --}}
                        <a href="/" class="inline-flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 rounded-xl">
                            <div
                                class="bg-amber-600 p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all duration-200 ease-in-out">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-lg sm:text-xl font-black tracking-tight uppercase text-gray-900 dark:text-white">
                                Solar<span class="text-amber-500">Calc</span>
                            </span>
                        </a>

                        {{-- Desktop / Tablet --}}
                        <div class="hidden md:flex items-center gap-4 lg:gap-6">
                            <button @click="darkMode = !darkMode" type="button" aria-label="Cambiar tema"
                                class="inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-amber-400 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <span class="relative inline-flex h-5 w-5 items-center justify-center transition-transform duration-200 ease-in-out"
                                    :class="{ 'rotate-180': darkMode }">
                                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                        </path>
                                    </svg>
                                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                                        </path>
                                    </svg>
                                </span>
                            </button>

                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="inline-flex items-center h-10 px-3 text-sm lg:text-base font-semibold border-b-2 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 {{ request()->routeIs('dashboard') ? 'border-amber-600 text-amber-500' : 'border-transparent text-gray-500 dark:text-gray-300 hover:text-amber-500 hover:border-amber-500' }}">
                                    Dashboard
                                </a>
                                <a href="{{ url('/profile') }}"
                                    class="inline-flex items-center h-10 px-3 text-sm lg:text-base font-semibold border-b-2 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 {{ request()->routeIs('profile.*') ? 'border-amber-600 text-amber-500' : 'border-transparent text-gray-500 dark:text-gray-300 hover:text-amber-500 hover:border-amber-500' }}">
                                    Mi Perfil
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center h-10 px-4 text-sm font-semibold rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Entrar
                                </a>
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center h-10 px-5 text-sm font-semibold rounded-xl bg-amber-600 text-white hover:bg-amber-500 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Empezar
                                </a>
                            @endauth
                        </div>

                        {{-- Mobile controls --}}
                        <div class="md:hidden flex items-center gap-2">
                            <button @click="darkMode = !darkMode" type="button" aria-label="Cambiar tema"
                                class="inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-amber-400 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                                <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                                    </path>
                                </svg>
                            </button>

                            <button @click="open = !open" type="button" aria-label="Abrir menú principal"
                                :aria-expanded="open.toString()" aria-controls="mobile-public-menu"
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

                {{-- Mobile menu --}}
                <div id="mobile-public-menu" x-cloak x-show="open"
                    x-transition:enter="transition-all duration-200 ease-in-out"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in-out"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="md:hidden border-t border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md">
                    <div class="px-4 py-4 space-y-3">
                        <div class="divide-y divide-gray-200 dark:divide-gray-800">
                            @auth
                                <a href="{{ url('/dashboard') }}" @click="open = false"
                                    class="flex items-center py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-100 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Dashboard
                                </a>
                                <a href="{{ url('/profile') }}" @click="open = false"
                                    class="flex items-center py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-100 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Mi Perfil
                                </a>
                            @else
                                <a href="{{ route('login') }}" @click="open = false"
                                    class="flex items-center py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-100 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-gray-800 rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Entrar
                                </a>
                                <a href="{{ route('register') }}" @click="open = false"
                                    class="mt-3 w-full inline-flex items-center justify-center py-3 px-4 text-sm font-semibold rounded-xl bg-amber-600 text-white hover:bg-amber-500 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Empezar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-toast />
    </div>
</body>

</html>
