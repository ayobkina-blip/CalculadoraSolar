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
    public function adminIndex()
{
    if (auth()->user()->rol != 1) {
        abort(403);
    }

    // El with('usuario') ahora funcionará porque lo definimos arriba
    $todosLosPresupuestos = \App\Models\Resultado::with('usuario')->latest()->get();
    
    return view('solarcalc.admin', compact('todosLosPresupuestos'));
}

    /**
     * Cambiar el estado de un presupuesto para afectar a las gráficas globales
     */
    public function cambiarEstado(Request $request, $id)
    {
        // Verificamos si el rol es 1 (Admin)
        if (auth()->user()->rol != 1) abort(403);

        $resultado = Resultado::findOrFail($id);
        $resultado->estado = $request->nuevo_estado; // Asegúrate de tener esta columna en resultados
        $resultado->save();

        return back()->with('success', 'El estado ha sido actualizado. Las estadísticas globales han cambiado.');
    }
    public function descargarPDF($id)
{
    $resultado = Resultado::where('id_resultado', $id)
        ->where('usuario_fr', Auth::id())
        ->firstOrFail();

    // DEPURACIÓN RÁPIDA: Si esto es 0 aquí, el problema es la base de datos
    // Esto está bien: evita errores si el ROI es 0 o negativo
        $roi = $resultado->roi_anyos > 0 ? $resultado->roi_anyos : 'No calculado';

        $data = [
            'resultado' => $resultado,
            'roi' => $roi, // IMPORTANTE: Usa $roi en la vista PDF, no $resultado->roi_anyos
            'fecha' => date('d/m/Y'),
        ];

    $pdf = Pdf::loadView('solarcalc.pdf', $data);
    return $pdf->download('Presupuesto_SOLARCALC_'.$id.'.pdf');
}
    public function dashboard()
{
    $user = auth()->user();
    
    // 1. Obtenemos todos los presupuestos para cálculos globales
    $presupuestos = \App\Models\Resultado::where('usuario_fr', $user->id_usuario)->get();
    $conteo = $presupuestos->count();
    $ahorroTotal = $presupuestos->sum('ahorro_estimado_eur');
    $totalKwh = $presupuestos->sum('produccion_anual_kwh');

    // 2. Métricas de Impacto Ambiental (Cálculos técnicos)
    $co2Evitado = round(($totalKwh * 0.25) / 1000, 2); // 0.25kg CO2 por kWh
    $arbolesEquivalentes = floor($totalKwh * 0.04); // Aprox 1 árbol por cada 25kWh anuales

    // 3. Obtener los últimos 3 para la lista rápida
    $ultimosPresupuestos = $presupuestos->sortByDesc('created_at')->take(3);

    // 4. Datos para el gráfico de barras (Rendimiento Mensual)
    $curva = [0.05, 0.06, 0.09, 0.11, 0.13, 0.14, 0.14, 0.12, 0.09, 0.07, 0.05, 0.05];
    $datosGrafico = [];
    foreach ($curva as $mes) { 
        $datosGrafico[] = round($totalKwh * $mes, 2); 
    }

    // 5. Datos para el gráfico de Donut (Desglose del último presupuesto)
    $ultimo = $presupuestos->last();
    $repartoCostes = [];
    if ($ultimo) {
        $costePaneles = $ultimo->paneles_sugeridos * 250; // Coste variable definido en lógica
        $costeBase = 1500; // Coste fijo de instalación e inversor
        $repartoCostes = [$costePaneles, $costeBase];
    }

    return view('dashboard', [
        'presupuestos' => $ultimosPresupuestos,
        'conteo' => $conteo,
        'ahorroTotal' => $ahorroTotal,
        'co2' => $co2Evitado,
        'arboles' => $arbolesEquivalentes,
        'datosGrafico' => $datosGrafico,
        'repartoCostes' => $repartoCostes,
        'ultimo' => $ultimo
    ]);
}
public function estadisticas()
{
    $user = auth()->user();
    
    // FILTRADO PROFESIONAL: Solo sumamos datos reales verificados por admin
    $presupuestosVerificados = \App\Models\Resultado::where('estado', 'verificado')->get();

    $produccionTotalKwh = $presupuestosVerificados->sum('produccion_anual_kwh');
    
    // Si no hay verificados, podrías mostrar un mensaje o usar una media base
    $usuariosContados = \App\Models\User::count();

    return view('solarcalc.estadisticas', [
        'radiacion' => 1650,
        'usuarios' => $usuariosContados,
        'co2' => round(($produccionTotalKwh * 0.25) / 1000, 2),
        'datosGrafico' => $this->calcularCurvaMensual($produccionTotalKwh)
    ]);
}

// Función auxiliar para no repetir código
private function calcularCurvaMensual($total) {
    $curvaValencia = [0.05, 0.06, 0.09, 0.11, 0.13, 0.14, 0.14, 0.12, 0.09, 0.07, 0.05, 0.05];
    return array_map(fn($mes) => round($total * $mes, 2), $curvaValencia);
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