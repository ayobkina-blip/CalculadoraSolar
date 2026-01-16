<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SolarCalc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 antialiased font-sans">
    <div class="min-h-screen">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center text-xl font-bold dark:text-white">
                <a href="/"><span class="text-yellow-500">Solar</span>Calc</a>
            </div>

            <div class="flex items-center space-x-8">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-yellow-500 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-yellow-500 transition">
                        Iniciar sesión
                    </a>
                    
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-yellow-500 transition">
                        Crear cuenta
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>