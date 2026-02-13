<!DOCTYPE html>
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

<body class="bg-white dark:bg-[#0f172a] antialiased font-sans transition-colors duration-300">

    <div class="min-h-screen flex flex-col">

        <nav class="fixed w-full bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 z-50 transition-all duration-300"
            x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">

                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-3 group">
                        <div
                            class="bg-amber-500 p-2 rounded-xl shadow-lg group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xl font-black tracking-tighter text-gray-900 dark:text-white uppercase">
                            Solar<span class="text-amber-500">Calc</span>
                        </span>
                    </a>

                    {{-- Derecha: Navegación y Switch (Desktop) --}}
                    <div class="hidden md:flex items-center gap-6">

                        <button @click="darkMode = !darkMode"
                            class="p-2.5 rounded-xl bg-gray-50 dark:bg-slate-800 text-gray-400 dark:text-amber-400 border border-gray-200 dark:border-slate-700 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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

                        <div class="flex items-center gap-6">
                            @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-amber-500 transition-colors">Dashboard</a>
                            <a href="{{ url('/profile') }}"
                                class="text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-amber-500 transition-colors">Mi
                                Perfil</a>
                            @else
                            <a href="{{ route('login') }}"
                                class="text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-amber-500 transition-colors">Entrar</a>
                            <a href="{{ route('register') }}"
                                class="bg-gray-900 dark:bg-amber-500 text-white px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all shadow-lg shadow-gray-200 dark:shadow-none">
                                Empezar
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Botón Hamburguesa (Móvil) --}}
                    <div class="-mr-2 flex items-center md:hidden gap-4">
                        <button @click="darkMode = !darkMode" class="p-2 text-gray-400 dark:text-amber-400">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menú Móvil --}}
            <div :class="{'block': open, 'hidden': ! open}" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="hidden md:hidden bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-xl border-t border-gray-100 dark:border-slate-800 absolute w-full left-0 shadow-xl">
                <div class="pt-4 pb-6 space-y-2 px-6">
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="block w-full text-center py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 text-lg font-black text-slate-900 dark:text-white mb-3">
                        Ir al Dashboard
                    </a>
                    <a href="{{ url('/profile') }}"
                        class="block w-full text-center py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-400">
                        Mi Perfil
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-400 mb-3">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-4 rounded-2xl bg-amber-500 text-lg font-black text-white shadow-lg shadow-amber-500/30">
                        Empezar Ahora
                    </a>
                    @endif
                </div>
            </div>
        </nav>

        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <x-toast />
    </div>

</body>

</html>