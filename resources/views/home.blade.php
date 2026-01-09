<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Solar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

    <header class="flex justify-between items-center p-6 border-b border-gray-100">
        <div class="text-xl font-semibold tracking-tight text-gray-800">
            Calculadora Solar
        </div>

        <nav>
            @if (Route::has('login'))
                <div class="flex space-x-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-black transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-black transition">Iniciar sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-gray-600 hover:text-black transition">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>
    </header>

    <main class="max-w-7xl mx-auto py-12 px-6">
        </main>

</body>
</html>