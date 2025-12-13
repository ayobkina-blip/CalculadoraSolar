@extends('layouts.auth')

@section('title', 'Iniciar Sesion')

@section('content')
    <div class="login-page">
        <div class="login">
            <div class="izquierdo">
                <h2>Bienvenido</h2>
                <p>Ingresa tus credenciales para acceder a la plataforma.</p>
            </div>
            <div class="derecho">
                <form action="#" method="POST">
                    <input type="email" placeholder="Correo electrónico" required>
                    <input type="password" placeholder="Contraseña" required>
                    <button type="submit">Acceder</button>
                </form>
            </div>
        </div>
    </div>
@endsection