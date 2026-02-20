{{-- Prioridad 2 aplicada: habilitada inyección de estilos vía @stack('styles') para vistas como calculadora. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SolarCalc') }}</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-[#0b1120] text-slate-900 dark:text-slate-200 transition-colors duration-300">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                {{-- El nav en navigation.blade.php usa h-16/md:h-[72px]; este margen evita solape del header. --}}
                <header class="mt-16 md:mt-[72px] bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white transition-colors">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            {{-- Si no hay header, se compensa el nav fijo con pt-20/pt-24; con header se reduce para evitar doble separación. --}}
            <main class="{{ isset($header) ? 'pt-8 sm:pt-10' : 'pt-20 sm:pt-24' }} pb-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <x-toast />
        @stack('js')
    </body>
</html>
