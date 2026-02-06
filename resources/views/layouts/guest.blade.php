<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SolarCalc') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-slate-50 dark:bg-slate-950">
        <div class="min-h-screen flex flex-col lg:flex-row">
            {{-- Carrusel lateral (oculto en móviles pequeños, visible en tablets y desktop) --}}
            <div class="hidden md:block w-full lg:w-[55%] xl:w-[60%] relative h-[30vh] md:h-screen bg-black overflow-hidden">
                <x-auth-carrusel /> 
            </div>

            {{-- Formulario principal --}}
            <div class="w-full lg:w-[45%] xl:w-[40%] flex flex-col justify-center items-center p-4 sm:p-6 md:p-8 lg:p-12 bg-white dark:bg-slate-900 overflow-y-auto min-h-screen">
                <div class="w-full max-w-md bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700">
                    {{-- Logo responsive --}}
                    <div class="flex justify-center mb-6 sm:mb-8">
                        <a href="/" class="group">
                            <div class="bg-amber-500 rounded-xl p-2 group-hover:rotate-6 transition-transform shadow-lg">
                                <x-application-logo class="w-16 h-16 sm:w-20 sm:h-20 fill-current text-white" />
                            </div>
                        </a>
                    </div>

                    {{-- Contenido del formulario --}}
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>