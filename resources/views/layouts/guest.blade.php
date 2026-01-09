<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
    <div class="contenedor-principal min-h-screen flex flex-col sm:flex-row">
        
        <div class="contenedor-base w-full sm:w-[60vw] relative h-[40vh] sm:h-screen bg-black overflow-hidden">
            <x-auth-carrusel /> 
        </div>

        <div class="w-full sm:w-[40vw] flex flex-col justify-center items-center p-6 sm:p-12 bg-white dark:bg-gray-900 shadow-xl overflow-y-auto min-h-screen">
            
            <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex justify-center mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>