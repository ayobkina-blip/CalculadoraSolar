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
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    {{-- Cambiamos el bg del body a uno más profundo --}}
    <body class="font-sans antialiased bg-slate-50 dark:bg-[#0b1120] text-slate-900 dark:text-slate-200 transition-colors duration-300">
        <div class="min-h-screen">
            
            {{-- El botón ya está dentro de este componente de navegación --}}
            @include('layouts.navigation')

            @isset($header)
                {{-- Arreglado: bg-slate-900 para que no sea azul brillante, sino mate profesional --}}
                <header class="bg-white dark:bg-[#111827] shadow-sm border-b border-gray-200 dark:border-slate-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{-- Forzamos el color del título del header --}}
                        <div class="text-xl font-bold text-slate-800 dark:text-white transition-colors">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        <x-toast />
        @stack('js')
    </body>
</html>