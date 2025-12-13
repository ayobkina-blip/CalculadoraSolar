<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Plantilla por Defecto')</title>

    <link href="{{ asset('css/estilo.login.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

    <main class="container">
        @yield('content') 
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>