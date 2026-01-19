<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use Illuminate\Support\Facades\Auth;

class SolarController extends Controller
{
    /**
     * Procesa los datos del formulario de la calculadora solar.
     */
    public function procesar(Request $request)
    {
        // 1. Validación de los datos de entrada
        $request->validate([
            'consumo' => 'required|numeric|min:0.1',
            'superficie' => 'required|numeric|min:1',
            'orientacion' => 'required|integer',
            'inclinacion' => 'required|integer|min:0|max:90',
        ]);

        // 2. Definición de constantes técnicas (Estándares de Ingeniería)
        $potenciaPanelWp = 0.450; // Cada panel tiene 450W (0.45 kWp)
        $rendimientoSistema = 0.80; // Pérdidas del 20% (suciedad, cables, calor, inversor)
        $hspMedia = 4.4; // Horas de Sol Pico media en la zona (Valencia/Algemesí aprox.)
        $precioKwhMedio = 0.18; // Precio de la electricidad en €/kWh
        $costeFijoInstalacion = 1500; // Inversor, protecciones y mano de obra
        $costeVariablePorPanel = 250; // Precio por cada panel instalado

        // 3. Lógica de cálculo
        $consumoAnualKwh = $request->consumo * 12;
        $consumoDiarioKwh = $consumoAnualKwh / 365;

        // Ajuste de producción según la orientación seleccionada
        // El Sur (0) rinde al 100%, desviaciones reducen la eficiencia
        $factorOrientacion = 1.0;
        if (abs($request->orientacion) >= 45 && abs($request->orientacion) < 90) {
            $factorOrientacion = 0.90; // Sureste/Suroeste
        } elseif (abs($request->orientacion) >= 90) {
            $factorOrientacion = 0.80; // Este/Oeste
        }

        // Cálculo de potencia necesaria (Fórmula fotovoltaica profesional)
        // P = E / (HSP * PR)
        $potenciaNecesariaKwp = $consumoDiarioKwh / ($hspMedia * $rendimientoSistema * $factorOrientacion);
        
        // Número de paneles teóricos según el consumo
        $numPanelesTeoricos = ceil($potenciaNecesariaKwp / $potenciaPanelWp);

        // Limitación por espacio físico (aprox. 2m² por panel de 450W)
        $maxPanelesPorEspacio = floor($request->superficie / 2.0);
        
        // Decisión final: Instalamos lo que necesita o lo que cabe
        $panelesFinales = min($numPanelesTeoricos, $maxPanelesPorEspacio);
        $potenciaInstaladaKwp = $panelesFinales * $potenciaPanelWp;

        // 4. Estimación de resultados económicos
        $produccionAnualKwh = $potenciaInstaladaKwp * $hspMedia * 365 * $rendimientoSistema * $factorOrientacion;
        $ahorroAnualEur = $produccionAnualKwh * $precioKwhMedio;
        
        $costeTotalProyecto = $costeFijoInstalacion + ($panelesFinales * $costeVariablePorPanel);
        $roiAnyos = ($ahorroAnualEur > 0) ? ($costeTotalProyecto / $ahorroAnualEur) : 0;

        // 5. Almacenamiento en la base de datos
        $resultado = Resultado::create([
            'usuario_fr' => Auth::id(),
            'ubicacion' => 'Calle Benimodo 3, Algemesí', // Valor por defecto o del request
            'consumo_anual' => (int)$consumoAnualKwh,
            'superficie_disponible' => $request->superficie,
            'orientacion' => $request->orientacion,
            'inclinacion' => $request->inclinacion,
            'ahorro_estimado_eur' => $ahorroAnualEur,
            'paneles_sugeridos' => $panelesFinales,
            'potencia_instalacion_kwp' => $potenciaInstaladaKwp,
            'produccion_anual_kwh' => $produccionAnualKwh,
            'roi_anyos' => round($roiAnyos, 2),
            // 'fuerza' y 'radiacion_a_medida' pueden usarse para otros indicadores
        ]);

        // Redirección a la vista de resultados (debes crear esta ruta)
        return redirect()->route('solar.resultados', ['id' => $resultado->id_resultado])
                 ->with('success', 'Cálculo técnico completado con éxito.');
    }
}