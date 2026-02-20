<?php
// Prioridad 1 aplicada: autorización de resultados por usuario movida a controlador.

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolarController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/resultados/{id}', [SolarController::class, 'mostrarResultado'])->name('solar.resultados');

    Route::get('/presupuestos', [SolarController::class, 'presupuestos'])->name('solar.presupuestos');

    // 4. Estadísticas e Informes
    Route::get('/estadisticas', [SolarController::class, 'estadisticas'])->name('solar.estadisticas');
    
    Route::get('/solar/descargar-pdf/{id}', [SolarController::class, 'descargarPDF'])->name('solar.pdf');

    // 5. Panel de Administración (Solo para Rol = 1) - Protegido con middleware
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/gestion', [SolarController::class, 'adminIndex'])->name('solar.admin');
        Route::post('/usuario/{id}/rol', [SolarController::class, 'cambiarRol'])->name('admin.cambiarRol');
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::post('/resultado/{id}/estado', [SolarController::class, 'cambiarEstado'])->name('admin.cambiarEstado');
        Route::get('/estadisticas', [SolarController::class, 'adminEstadisticas'])->name('admin.estadisticas');
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::get('/exportar/csv', [SolarController::class, 'exportarCSV'])->name('admin.exportar.csv');
    });
});

require __DIR__.'/auth.php';
