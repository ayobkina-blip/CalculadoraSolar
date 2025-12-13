<?php
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/', function () {
    return view('login.login');
});