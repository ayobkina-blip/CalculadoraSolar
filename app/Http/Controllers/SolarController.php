<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class SolarController extends Controller
{
    /**
     * PANEL DE ADMINISTRACIÓN GLOBAL
     */
    public function adminIndex()
    {
        if (auth()->user()->rol != 1) abort(403);

        return view('solarcalc.admin', [
            'todosLosPresupuestos' => Resultado::with('usuario')->latest()->get(),
            'usuarios' => User::withCount('resultados')->get()
        ]);
    }

    /**
     * DASHBOARD PERSONAL DEL USUARIO
     */
    // En SolarController.php
    public function dashboard()
    {
        $user = auth()->user();
        
        // 1. Obtenemos todos los presupuestos (usando id_usuario según tu esquema)
        $presupuestos = Resultado::where('usuario_fr', $user->id_usuario)->get();
        
        // 2. Cálculos para los contadores (usando los nombres que espera el JS de tu vista)
        $conteo = $presupuestos->count();
        $ahorroTotal = $presupuestos->sum('ahorro_estimado_eur');
        $totalKwh = $presupuestos->sum('produccion_anual_kwh');
        $co2 = round(($totalKwh * 0.25) / 1000, 2); // Cambiado de $co2Evitado a $co2
        $arboles = floor($totalKwh * 0.04);         // Cambiado de $arbolesEquivalentes a $arboles

        // 3. Gráficos y último registro
        $datosGrafico = $this->calcularCurvaMensual($totalKwh);
        $ultimo = $presupuestos->last();
        $repartoCostes = $ultimo ? [$ultimo->paneles_sugeridos * 250, 1500] : [];

        // IMPORTANTE: El compact debe incluir 'presupuestos' para el @forelse
        return view('dashboard', compact(
            'presupuestos', 'conteo', 'ahorroTotal', 
            'co2', 'arboles', 'datosGrafico', 
            'repartoCostes', 'ultimo'
        ));
    }
    /**
     * Muestra la vista de estadísticas generales
     */
    public function estadisticas()
    {
        // 1. Cálculos globales para los indicadores
        $totalKwhGlobal = Resultado::sum('produccion_anual_kwh');
        
        $data = [
            'radiacion' => 1650, // Dato estático o de API
            'usuarios' => User::count(), // Conteo real de la tabla usuarios
            'co2' => round(($totalKwhGlobal * 0.25) / 1000, 2), // Tons de CO2
            'datosGrafico' => [10, 15, 25, 45, 60, 80, 85, 70, 50, 30, 15, 10] // Curva por defecto
        ];

        return view('solarcalc.estadisticas', $data);
    }

    /**
     * Actualiza el estado de un presupuesto (Admin Only)
     */
    public function cambiarEstado(Request $request, $id)
    {
        // 1. Verificación de seguridad
        if (auth()->user()->rol != 1) {
            abort(403, 'Acceso denegado.');
        }

        // 2. Validación
        $request->validate([
            'estado' => 'required|string|in:pendiente,aprobado,rechazado'
        ]);

        // 3. Búsqueda por tu ID personalizado (id_resultado)
        $resultado = Resultado::where('id_resultado', $id)->firstOrFail();

        if (!$resultado) {
            return back()->with('error', 'No se encontró el presupuesto #' . $id);
        }

        // 4. Asignación y guardado
        $resultado->estado = $request->input('estado');
        
        if ($resultado->save()) {
            return back()->with('success', 'Estado del presupuesto #' . $id . ' actualizado a ' . $request->estado);
        } else {
            return back()->with('error', 'Error crítico al guardar en la base de datos.');
        }
    }

    /**
     * MOTOR DE CÁLCULO FOTOVOLTAICO DINÁMICO (Core Logic v2.0)
     */
    public function procesar(Request $request)
    {
        $request->validate([
            'consumo' => 'required|numeric|min:0.1',
            'superficie' => 'required|numeric|min:1',
            'orientacion' => 'required|integer',
            'inclinacion' => 'required|integer|min:0|max:90',
            'provincia' => 'required|string',
            'latitud' => 'required|numeric', // Ahora son obligatorios para la API
            'longitud' => 'required|numeric',
        ]);

        // 1. LLAMADA A LA API DE PVGIS (Unión Europea)
        // Parámetros: peakpower=1 (para saber cuánto produce 1kWp), loss=14 (pérdidas estándar), raddatabase=PVGIS-SARAH2
        $lat = $request->latitud;
        $lon = $request->longitud;
        $angle = $request->inclinacion;
        $aspect = $request->orientacion; // PVGIS usa 0 para Sur, -90 Este, 90 Oeste (igual que tú)

        $url = "https://re.jrc.ec.europa.eu/api/v5_2/PVcalc?lat={$lat}&lon={$lon}&peakpower=1&loss=14&angle={$angle}&aspect={$aspect}&outputformat=json";

        try {
            $response = Http::timeout(5)->get($url);
            
            if ($response->successful()) {
                $data = $response->json();
                // E_y es la producción anual estimada por cada 1kWp instalado en ese punto exacto
                $produccionAnualPorKwp = $data['outputs']['totals']['fixed']['E_y'];
                // Calculamos la HSP equivalente (Horas Solares Pico) para mantener tu lógica
                $hspLocal = $produccionAnualPorKwp / 365;
            } else {
                throw new \Exception("Error en API");
            }
        } catch (\Exception $e) {
            // Fallback: Si la API falla, usamos tu tabla de provincias anterior
            $tablaHSP = ['valencia' => 4.9, 'madrid' => 4.9, 'barcelona' => 4.2]; // ... tu tabla completa
            $provinciaKey = strtolower(trim($request->provincia));
            $hspLocal = $tablaHSP[$provinciaKey] ?? 4.4;
        }

        // 2. CONSTANTES DE INGENIERÍA
        $potenciaPanelWp = 0.450;      // 450W por panel
        $rendimientoSistema = 0.90;    // Bajamos a 0.90 porque la API ya incluye la mayoría de pérdidas
        $precioKwhMedio = 0.18;        
        $costeFijoInstalacion = 1500;  
        $costeVariablePorPanel = 250;  

        // 3. LÓGICA DE DIMENSIONAMIENTO
        $consumoAnualKwh = $request->consumo * 12;
        
        // Cuánta potencia necesitamos para cubrir ese consumo basado en la API
        $potenciaNecesariaKwp = $consumoAnualKwh / ($hspLocal * 365 * $rendimientoSistema);
        $numPanelesTeoricos = ceil($potenciaNecesariaKwp / $potenciaPanelWp);
        
        // Límite de espacio (2m2 por panel)
        $maxPanelesPorEspacio = floor($request->superficie / 2.0);
        
        $panelesFinales = max(1, min($numPanelesTeoricos, $maxPanelesPorEspacio));
        $potenciaInstaladaKwp = $panelesFinales * $potenciaPanelWp;

        // 4. RESULTADOS FINALES
        // Producción real = kWp instalados * producción por kWp de la API
        $produccionAnualKwh = $potenciaInstaladaKwp * $hspLocal * 365 * $rendimientoSistema;
        
        $ahorroAnualEur = $produccionAnualKwh * $precioKwhMedio;
        $costeTotalProyecto = $costeFijoInstalacion + ($panelesFinales * $costeVariablePorPanel);
        $roiAnyos = $ahorroAnualEur > 0 ? round($costeTotalProyecto / $ahorroAnualEur, 1) : 0;

        // 5. GUARDAR EN BD
        $resultado = Resultado::create([
            'usuario_fr' => auth()->id(),
            'ubicacion' => ucfirst($request->provincia),
            'latitud' => $lat,
            'longitud' => $lon,
            'consumo_anual' => $consumoAnualKwh,
            'superficie_disponible' => $request->superficie,
            'orientacion' => $request->orientacion,
            'inclinacion' => $request->inclinacion,
            'ahorro_estimado_eur' => $ahorroAnualEur,
            'paneles_sugeridos' => $panelesFinales,
            'potencia_instalacion_kwp' => $potenciaInstaladaKwp,
            'produccion_anual_kwh' => $produccionAnualKwh,
            'roi_anyos' => $roiAnyos,
        ]);

        return redirect()->route('solar.resultados', $resultado->id_resultado);
    }

    /**
     * GENERACIÓN DE INFORME TÉCNICO PDF
     */
    public function descargarPDF($id)
    {
        $resultado = Resultado::where('id_resultado', $id)
            ->where('usuario_fr', Auth::id())
            ->firstOrFail();

        $data = [
            'resultado' => $resultado,
            'roi' => $resultado->roi_anyos > 0 ? $resultado->roi_anyos : 'No calculado',
            'fecha' => date('d/m/Y'),
        ];

        return Pdf::loadView('solarcalc.pdf', $data)
                  ->download('SolarCalc_Presupuesto_'.$id.'.pdf');
    }

    /**
     * GESTIÓN DE ROLES (Admin Only)
     */
    public function cambiarRol($id)
    {
        if (auth()->user()->rol != 1) abort(403);

        if (auth()->id() == $id || auth()->user()->id_usuario == $id) {
            return back()->with('error', 'No puedes degradar tu propio acceso administrativo.');
        }

        $usuario = User::where('id_usuario', $id)->firstOrFail();
        $usuario->rol = ($usuario->rol == 1) ? 0 : 1;
        $usuario->save();

        return back()->with('success', 'Rango de ' . ($usuario->nombre ?? $usuario->name) . ' actualizado.');
    }

    /**
     * FUNCIONES AUXILIARES
     */
    private function calcularCurvaMensual($total) {
        $curvaValencia = [0.05, 0.06, 0.09, 0.11, 0.13, 0.14, 0.14, 0.12, 0.09, 0.07, 0.05, 0.05];
        return array_map(fn($mes) => round($total * $mes, 2), $curvaValencia);
    }
}