<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolarController;
use Illuminate\Support\Facades\Route;
use App\Models\Resultado;
use Illuminate\Support\Facades\Auth;

// --- Rutas Públicas ---
Route::get('/', function () {
    return view('home');
})->name('home');

// --- Rutas Protegidas ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard Principal (Gestionado por el Controlador)
    Route::get('/dashboard', [SolarController::class, 'dashboard'])->name('dashboard');

    // 2. Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 3. Calculadora Solar e Ingeniería
    Route::get('/calculadora', function () {
        return view('solarcalc.calculadora');
    })->name('solar.calculadora');

    Route::post('/calculadora/procesar', [SolarController::class, 'procesar'])->name('solar.procesar');

    Route::get('/resultados/{id}', function ($id) {
        $resultado = Resultado::findOrFail($id);
        return view('solarcalc.resultados', compact('resultado'));
    })->name('solar.resultados');

    Route::get('/presupuestos', function () {
        // Usamos id_usuario por tu esquema personalizado
        $presupuestos = Resultado::where('usuario_fr', Auth::user()->id_usuario)->get();
        return view('solarcalc.presupuestos', compact('presupuestos'));
    })->name('solar.presupuestos');

    // 4. Estadísticas e Informes
    Route::get('/estadisticas', [SolarController::class, 'estadisticas'])->name('solar.estadisticas');
    
    Route::get('/solar/descargar-pdf/{id}', [SolarController::class, 'descargarPDF'])->name('solar.pdf');

    // 5. Panel de Administración (Solo para Rol = 1)
    Route::prefix('admin')->group(function () {
        Route::get('/gestion', [SolarController::class, 'adminIndex'])->name('solar.admin');
        Route::post('/usuario/{id}/rol', [SolarController::class, 'cambiarRol'])->name('admin.cambiarRol');
        Route::post('/resultado/{id}/estado', [SolarController::class, 'cambiarEstado'])->name('admin.cambiarEstado');
    });
});

require __DIR__.'/auth.php';