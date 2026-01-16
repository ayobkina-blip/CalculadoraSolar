<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use Illuminate\Support\Facades\Auth;

class SolarController extends Controller
{
    public function procesar(Request $request)
    {
        $request->validate([
            'consumo' => 'required|numeric|min:1',
            'superficie' => 'required|numeric|min:1',
        ]);

        $potenciaGenerada = min(($request->consumo / 100), ($request->superficie / 6)); 
        $ahorroAnual = $potenciaGenerada * 215.50;

        $registro = Resultado::create([
            'ahorro_estimado_eur' => $ahorroAnual,
            'fuerza'              => round($potenciaGenerada, 2),
            'ubicacion'           => $request->direccion ?? 'Calle Benimodo 3, Algemesí',
            'consumo_anual'       => $request->consumo * 12,
            'radiacion_a_medida'  => 1650,
            'usuario_fr'          => Auth::user()->id_usuario,
            'estadistica_fr'      => null,
        ]);

        return redirect()->route('solar.resultados', ['id' => $registro->id_resultado]);
    }
}