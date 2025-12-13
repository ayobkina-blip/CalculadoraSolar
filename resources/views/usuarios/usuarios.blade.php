<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Plantilla Cutre</title>
    {{-- Aquí meteremos el CSS, pero luego. --}}
</head>
<body>
    <div id="app">
        {{-- ¡Contenido aquí, listo! --}}
        @yield('content')
    </div>
</body>
</html>