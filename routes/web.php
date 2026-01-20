<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Calculadora Solar
    Route::get('/calculadora', function () {
        return view('solarcalc.calculadora');
    })->name('solar.calculadora');

    Route::post('/calculadora/procesar', [SolarController::class, 'procesar'])->name('solar.procesar');

    Route::get('/resultados/{id}', function ($id) {
        $resultado = \App\Models\Resultado::findOrFail($id);
        return view('solarcalc.resultados', compact('resultado'));
    })->name('solar.resultados');

    Route::get('/presupuestos', function () {
        $presupuestos = \App\Models\Resultado::where('usuario_fr', Auth::user()->id_usuario)->get();
        return view('solarcalc.presupuestos', compact('presupuestos'));
    })->name('solar.presupuestos');

    Route::get('/estadisticas', function () {
        return view('solarcalc.estadisticas');
    })->name('solar.estadisticas');
    // Elimina la versión simple y deja solo esta:
    Route::get('/estadisticas', [SolarController::class, 'estadisticas'])->name('solar.estadisticas');

    Route::get('/dashboard', [SolarController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('/solar/descargar-pdf/{id}', [SolarController::class, 'descargarPDF'])
    ->name('solar.pdf')
    ->middleware('auth');
});

require __DIR__.'/auth.php';