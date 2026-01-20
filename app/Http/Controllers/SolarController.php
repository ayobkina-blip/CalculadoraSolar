<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SolarController extends Controller
{
    /**
     * Procesa los datos del formulario de la calculadora solar.
     */
    public function descargarPDF($id)
{
    $resultado = Resultado::where('id_resultado', $id)
        ->where('usuario_fr', Auth::id())
        ->firstOrFail();

    // DEPURACIÓN RÁPIDA: Si esto es 0 aquí, el problema es la base de datos
    $roi = $resultado->roi_anyos > 0 ? $resultado->roi_anyos : 'No calculado';

    $data = [
        'resultado' => $resultado,
        'roi' => $roi, // Enviamos el ROI como una variable independiente y limpia
        'fecha' => date('d/m/Y'),
    ];

    $pdf = Pdf::loadView('solarcalc.pdf', $data);
    return $pdf->download('Presupuesto_SOLARCALC_'.$id.'.pdf');
}
    public function dashboard()
{
    $user = auth()->user();
    // Obtenemos los últimos 3 presupuestos para una tabla rápida
    $ultimosPresupuestos = \App\Models\Resultado::where('usuario_fr', $user->id_usuario)
        ->latest()
        ->take(3)
        ->get();

    // Datos para los contadores
    $presupuestos = \App\Models\Resultado::where('usuario_fr', $user->id_usuario)->get();
    $totalKwh = $presupuestos->sum('produccion_anual_kwh');
    
    // Simulación de curva para el mini-gráfico
    $curva = [0.05, 0.06, 0.09, 0.11, 0.13, 0.14, 0.14, 0.12, 0.09, 0.07, 0.05, 0.05];
    $datosGrafico = [];
    foreach ($curva as $mes) { $datosGrafico[] = round($totalKwh * $mes, 2); }

    return view('dashboard', [
        'presupuestos' => $ultimosPresupuestos,
        'conteo' => $presupuestos->count(),
        'ahorroTotal' => $presupuestos->sum('ahorro_estimado_eur'),
        'datosGrafico' => $datosGrafico
    ]);
}
    public function estadisticas()
{
    // Obtener el usuario y sus presupuestos guardados
    $user = auth()->user();
    $presupuestos = \App\Models\Resultado::where('usuario_fr', $user->id_usuario)->get();

    $produccionTotalKwh = $presupuestos->sum('produccion_anual_kwh');
    
    // Simulación de curva de radiación mensual para Algemesí
    $curvaValencia = [0.05, 0.06, 0.09, 0.11, 0.13, 0.14, 0.14, 0.12, 0.09, 0.07, 0.05, 0.05];
    $datosMensuales = [];

    foreach ($curvaValencia as $mes) {
        $datosMensuales[] = round($produccionTotalKwh * $mes, 2);
    }

    return view('solarcalc.estadisticas', [
        'radiacion' => 1650,
        'usuarios' => \App\Models\User::count(),
        'co2' => round(($produccionTotalKwh * 0.25) / 1000, 2),
        'datosGrafico' => $datosMensuales // Esta es la variable que espera el JS
    ]);
}
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

        // Evitamos división por cero y aseguramos un mínimo de 0.1 para que no sea invisible
        if ($ahorroAnualEur > 0) {
            $roiAnyos = round($costeTotalProyecto / $ahorroAnualEur, 1);
        } else {
            $roiAnyos = 0; // O un valor estimado base
        }

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
            'roi_anyos' => $roiAnyos,
            // 'fuerza' y 'radiacion_a_medida' pueden usarse para otros indicadores
        ]);

        // Redirección a la vista de resultados (debes crear esta ruta)
        return redirect()->route('solar.resultados', ['id' => $resultado->id_resultado])
                 ->with('success', 'Cálculo técnico completado con éxito.');
    }
}