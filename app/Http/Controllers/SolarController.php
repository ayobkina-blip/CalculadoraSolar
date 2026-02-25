<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resultado;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class SolarController extends Controller
{
    /**
     * PANEL DE ADMINISTRACIÓN GLOBAL
     * Muestra todos los presupuestos y usuarios del sistema con paginación y filtros.
     * Acceso restringido a administradores mediante middleware.
     */
    public function adminIndex(Request $request)
    {
        // Consulta base con relaciones
        $query = Resultado::with('usuario')->latest();
        
        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        // Búsqueda por ubicación o usuario
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('ubicacion', 'like', "%{$buscar}%")
                  ->orWhereHas('usuario', function($q) use ($buscar) {
                      $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                  });
            });
        }
        
        // Ordenación
        $orden = $request->get('orden', 'fecha_desc');
        switch ($orden) {
            case 'fecha_asc':
                $query->oldest();
                break;
            case 'potencia_desc':
                $query->orderBy('potencia_instalacion_kwp', 'desc');
                break;
            case 'potencia_asc':
                $query->orderBy('potencia_instalacion_kwp', 'asc');
                break;
            case 'ahorro_desc':
                $query->orderBy('ahorro_estimado_eur', 'desc');
                break;
            default:
                $query->latest();
        }
        
        // Paginación (15 por página)
        $todosLosPresupuestos = $query->paginate(15)->withQueryString();
        
        // Usuarios con conteo de resultados
        $usuarios = User::withCount('resultados')
            ->with(['activeSubscription.plan'])
            ->get();

        $subscriptionPlans = SubscriptionPlan::query()
            ->whereIn('code', [
                SubscriptionPlan::CODE_PREMIUM_MONTHLY,
                SubscriptionPlan::CODE_PREMIUM_YEARLY,
            ])
            ->where('is_active', true)
            ->orderByRaw("CASE code WHEN 'premium_monthly' THEN 1 WHEN 'premium_yearly' THEN 2 ELSE 3 END")
            ->get();

        return view('solarcalc.admin', compact('todosLosPresupuestos', 'usuarios', 'subscriptionPlans'));
    }

    public function calculadora(Request $request, SubscriptionAccessService $subscriptionAccess): View
    {
        $user = $request->user();

        return view('solarcalc.calculadora', [
            'remainingSimulations' => $subscriptionAccess->remainingSimulations($user),
            'isPremiumActive' => $subscriptionAccess->isPremiumActive($user),
            'currentPlan' => $subscriptionAccess->getCurrentPlan($user),
        ]);
    }

    /**
     * DASHBOARD PERSONAL DEL USUARIO
     * Muestra métricas, gráficos y últimas simulaciones del usuario autenticado.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Obtenemos todos los presupuestos del usuario (usando id_usuario según esquema)
        $presupuestos = Resultado::where('usuario_fr', $user->id_usuario)
            ->latest()
            ->take(5) // Solo los 5 más recientes para el dashboard
            ->get();
        
        // Cálculos para los contadores
        $todosLosPresupuestos = Resultado::where('usuario_fr', $user->id_usuario)->get();
        $conteo = $todosLosPresupuestos->count();
        $ahorroTotal = $todosLosPresupuestos->sum('ahorro_estimado_eur');
        $totalKwh = $todosLosPresupuestos->sum('produccion_anual_kwh');
        
        // Cálculos ambientales (factor de emisión: 0.25 kg CO2/kWh)
        $co2 = round(($totalKwh * 0.25) / 1000, 2); // Toneladas de CO2 evitadas
        $arboles = floor($totalKwh * 0.04); // Equivalencia en árboles plantados

        // Gráficos y último registro
        $datosGrafico = $this->calcularCurvaMensual($totalKwh);
        $ultimo = $todosLosPresupuestos->last();
        $repartoCostes = $ultimo ? [$ultimo->paneles_sugeridos * 250, 1500] : [];

        return view('dashboard', compact(
            'presupuestos', 'conteo', 'ahorroTotal', 
            'co2', 'arboles', 'datosGrafico', 
            'repartoCostes', 'ultimo'
        ));
    }
    /**
     * Muestra la vista de estadísticas generales del sistema
     * Calcula métricas globales de todas las simulaciones realizadas.
     */
    public function estadisticas(Request $request, SubscriptionAccessService $subscriptionAccess)
    {
        $user = $request->user();

        if (!$subscriptionAccess->hasFeature($user, SubscriptionPlan::FEATURE_ADVANCED_STATS)) {
            return view('solarcalc.estadisticas-teaser', [
                'remainingSimulations' => $subscriptionAccess->remainingSimulations($user),
                'currentPlan' => $subscriptionAccess->getCurrentPlan($user),
            ]);
        }

        // Cálculos globales para los indicadores
        $totalKwhGlobal = Resultado::sum('produccion_anual_kwh');
        $totalPresupuestos = Resultado::count();
        $ahorroTotalGlobal = Resultado::sum('ahorro_estimado_eur');
        
        // Estadísticas por día (últimos 30 días)
        $presupuestosPorDia = Resultado::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        // Curva mensual basada en datos reales si existen
        $datosGrafico = $this->calcularCurvaMensual($totalKwhGlobal);
        
        $data = [
            'radiacion' => 1650, // Dato estático o de API
            'usuarios' => User::count(),
            'co2' => round(($totalKwhGlobal * 0.25) / 1000, 2), // Toneladas de CO2 evitadas
            'totalPresupuestos' => $totalPresupuestos,
            'ahorroTotalGlobal' => $ahorroTotalGlobal,
            'presupuestosPorDia' => $presupuestosPorDia,
            'datosGrafico' => $datosGrafico
        ];

        return view('solarcalc.estadisticas', $data);
    }
    
    /**
     * Panel de estadísticas avanzadas para administradores
     * Incluye métricas detalladas, gráficos y análisis de rendimiento.
     */
    public function adminEstadisticas()
    {
        // Estadísticas generales
        $totalUsuarios = User::count();
        $totalPresupuestos = Resultado::count();
        $totalKwh = Resultado::sum('produccion_anual_kwh');
        $ahorroTotal = Resultado::sum('ahorro_estimado_eur');
        
        // Presupuestos por estado
        $porEstado = Resultado::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get()
            ->pluck('total', 'estado');
        
        // Presupuestos por día (últimos 30 días)
        $presupuestosPorDia = Resultado::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        // Top 5 usuarios con más simulaciones
        $topUsuarios = User::withCount('resultados')
            ->orderBy('resultados_count', 'desc')
            ->take(5)
            ->get();
        
        // Promedio de ahorro por presupuesto
        $ahorroPromedio = Resultado::avg('ahorro_estimado_eur');
        
        return view('solarcalc.admin-estadisticas', compact(
            'totalUsuarios', 'totalPresupuestos', 'totalKwh', 'ahorroTotal',
            'porEstado', 'presupuestosPorDia', 'topUsuarios', 'ahorroPromedio'
        ));
    }
    
    /**
     * Listado de presupuestos del usuario con paginación y filtros
     */
    public function presupuestos(Request $request, SubscriptionAccessService $subscriptionAccess)
    {
        $user = auth()->user();
        
        // Consulta base
        $query = Resultado::where('usuario_fr', $user->id_usuario);
        
        // Filtro por ubicación
        if ($request->filled('buscar')) {
            $query->where('ubicacion', 'like', "%{$request->buscar}%");
        }
        
        // Ordenación
        $orden = $request->get('orden', 'fecha_desc');
        switch ($orden) {
            case 'fecha_asc':
                $query->oldest();
                break;
            case 'potencia_desc':
                $query->orderBy('potencia_instalacion_kwp', 'desc');
                break;
            case 'potencia_asc':
                $query->orderBy('potencia_instalacion_kwp', 'asc');
                break;
            case 'ahorro_desc':
                $query->orderBy('ahorro_estimado_eur', 'desc');
                break;
            default:
                $query->latest();
        }
        
        // Paginación (10 por página)
        $presupuestos = $query->paginate(10)->withQueryString();
        
        return view('solarcalc.presupuestos', [
            'presupuestos' => $presupuestos,
            'canDownloadPdf' => $subscriptionAccess->hasFeature($user, SubscriptionPlan::FEATURE_PDF_EXPORT),
            'canCompare' => $subscriptionAccess->hasFeature($user, SubscriptionPlan::FEATURE_RESULT_COMPARE),
            'canExportCsv' => $subscriptionAccess->hasFeature($user, SubscriptionPlan::FEATURE_CSV_EXPORT),
            'remainingSimulations' => $subscriptionAccess->remainingSimulations($user),
            'currentPlan' => $subscriptionAccess->getCurrentPlan($user),
        ]);
    }
    
    /**
     * Exportar datos a CSV (Solo administradores)
     */
    public function exportarCSV(Request $request)
    {
        // Consulta base
        $query = Resultado::with('usuario');
        
        // Aplicar filtros si existen
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        
        $resultados = $query->get();
        
        // Generar CSV
        $filename = 'presupuestos_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($resultados) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8 (Excel)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados
            fputcsv($file, [
                'ID',
                'Usuario',
                'Email',
                'Ubicación',
                'Potencia (kWp)',
                'Paneles',
                'Producción Anual (kWh)',
                'Ahorro Estimado (€)',
                'ROI (años)',
                'Estado',
                'Fecha Creación'
            ], ';');
            
            // Datos
            foreach ($resultados as $resultado) {
                fputcsv($file, [
                    $resultado->id_resultado,
                    $resultado->usuario->nombre ?? 'N/A',
                    $resultado->usuario->email ?? 'N/A',
                    $resultado->ubicacion,
                    number_format($resultado->potencia_instalacion_kwp, 2),
                    $resultado->paneles_sugeridos,
                    number_format($resultado->produccion_anual_kwh, 2),
                    number_format($resultado->ahorro_estimado_eur, 2),
                    $resultado->roi_anyos,
                    $resultado->estado ?? 'pendiente',
                    $resultado->created_at->format('d/m/Y H:i')
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Actualiza el estado de un presupuesto (Admin Only)
     * El middleware 'admin' ya verifica los permisos, pero mantenemos validación adicional.
     */
    public function cambiarEstado(Request $request, $id)
    {
        // Validación mejorada con mensajes personalizados
        $request->validate([
            'estado' => 'required|string|in:pendiente,aprobado,rechazado'
        ], [
            'estado.required' => 'Debe seleccionar un estado válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        // Búsqueda por ID personalizado (id_resultado)
        $resultado = Resultado::where('id_resultado', $id)->firstOrFail();

        // Asignación y guardado
        $resultado->estado = $request->input('estado');
        $resultado->save();

        return back()->with('success', 'Estado del presupuesto #' . $id . ' actualizado correctamente a: ' . ucfirst($request->estado));
    }

    /**
     * Prioridad 1 aplicada: acceso a resultados restringido al usuario autenticado.
     */
    public function mostrarResultado($id, SubscriptionAccessService $subscriptionAccess)
    {
        $resultado = Resultado::where('id_resultado', $id)
            ->where('usuario_fr', Auth::id())
            ->firstOrFail();

        return view('solarcalc.resultados', [
            'resultado' => $resultado,
            'canDownloadPdf' => $subscriptionAccess->hasFeature(auth()->user(), SubscriptionPlan::FEATURE_PDF_EXPORT),
            'currentPlan' => $subscriptionAccess->getCurrentPlan(auth()->user()),
        ]);
    }

    /**
     * MOTOR DE CÁLCULO FOTOVOLTAICO DINÁMICO (Core Logic v2.0)
     * Procesa los parámetros de entrada y calcula la instalación solar óptima.
     * Utiliza la API de PVGIS para obtener datos precisos de radiación solar.
     */
    public function procesar(Request $request, SubscriptionAccessService $subscriptionAccess)
    {
        if (!$subscriptionAccess->canCreateSimulation($request->user())) {
            return redirect()
                ->route('premium.index', ['reason' => 'simulation_quota'])
                ->with('premium_reason', 'simulation_quota')
                ->with('error', 'Has alcanzado el límite gratuito de 3 simulaciones.');
        }

        // Validación mejorada con mensajes personalizados en español
        $request->validate([
            'consumo' => 'required|numeric|min:50|max:10000',
            'superficie' => 'required|numeric|min:10|max:10000',
            'orientacion' => 'required|integer|in:-90,-45,0,45,90',
            'inclinacion' => 'required|integer|min:0|max:90',
            'provincia' => 'required|string|max:100',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ], [
            'consumo.required' => 'El consumo mensual es obligatorio.',
            'consumo.numeric' => 'El consumo debe ser un número válido.',
            'consumo.min' => 'El consumo mínimo es de 50 kWh/mes.',
            'consumo.max' => 'El consumo máximo permitido es de 10,000 kWh/mes.',
            'superficie.required' => 'La superficie disponible es obligatoria.',
            'superficie.numeric' => 'La superficie debe ser un número válido.',
            'superficie.min' => 'La superficie mínima es de 10 m².',
            'superficie.max' => 'La superficie máxima permitida es de 10,000 m².',
            'orientacion.required' => 'Debe seleccionar una orientación.',
            'orientacion.in' => 'La orientación seleccionada no es válida.',
            'inclinacion.required' => 'La inclinación es obligatoria.',
            'inclinacion.min' => 'La inclinación mínima es de 0 grados.',
            'inclinacion.max' => 'La inclinación máxima es de 90 grados.',
            'provincia.required' => 'Debe especificar la ubicación.',
            'latitud.required' => 'Debe seleccionar una ubicación en el mapa.',
            'latitud.between' => 'La latitud debe estar entre -90 y 90 grados.',
            'longitud.required' => 'Debe seleccionar una ubicación en el mapa.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180 grados.',
        ]);

        // 1. LLAMADA A LA API DE PVGIS (Unión Europea)
        // Parámetros: peakpower=1 (para saber cuánto produce 1kWp), loss=14 (pérdidas estándar)
        $lat = $request->latitud;
        $lon = $request->longitud;
        $angle = $request->inclinacion;
        $aspect = $request->orientacion; // PVGIS usa 0 para Sur, -90 Este, 90 Oeste

        $url = "https://re.jrc.ec.europa.eu/api/v5_2/PVcalc?lat={$lat}&lon={$lon}&peakpower=1&loss=14&angle={$angle}&aspect={$aspect}&outputformat=json";

        try {
            $response = Http::timeout(10)->get($url);
            
            if ($response->successful() && isset($response->json()['outputs']['totals']['fixed']['E_y'])) {
                $data = $response->json();
                // E_y es la producción anual estimada por cada 1kWp instalado en ese punto exacto
                $produccionAnualPorKwp = $data['outputs']['totals']['fixed']['E_y'];
                // Calculamos la HSP equivalente (Horas Solares Pico)
                $hspLocal = $produccionAnualPorKwp / 365;
            } else {
                throw new \Exception("La API de PVGIS no respondió correctamente");
            }
        } catch (\Exception $e) {
            // Fallback: Si la API falla, usamos tabla de provincias españolas
            $tablaHSP = [
                'valencia' => 4.9, 'alicante' => 5.1, 'murcia' => 5.2,
                'madrid' => 4.9, 'barcelona' => 4.2, 'sevilla' => 5.3,
                'malaga' => 5.1, 'granada' => 5.0, 'cordoba' => 5.2,
                'zaragoza' => 4.8, 'bilbao' => 3.5, 'santander' => 3.2,
                'valladolid' => 4.5, 'salamanca' => 4.6, 'leon' => 4.3
            ];
            $provinciaKey = strtolower(trim($request->provincia));
            $hspLocal = $tablaHSP[$provinciaKey] ?? 4.4; // Valor por defecto para España
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
    public function descargarPDF($id, SubscriptionAccessService $subscriptionAccess)
    {
        if (!$subscriptionAccess->hasFeature(auth()->user(), SubscriptionPlan::FEATURE_PDF_EXPORT)) {
            return redirect()
                ->route('premium.index', ['reason' => SubscriptionPlan::FEATURE_PDF_EXPORT])
                ->with('premium_reason', SubscriptionPlan::FEATURE_PDF_EXPORT)
                ->with('error', 'La exportación PDF forma parte del plan Premium.');
        }

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
     * Permite cambiar el rol de un usuario entre administrador y usuario normal.
     * El middleware 'admin' ya verifica los permisos.
     */
    public function cambiarRol(Request $request, $id)
    {
        // Validación adicional
        $request->validate([
            'rol' => 'sometimes|integer|in:0,1'
        ]);

        // Prevenir auto-degradación
        $currentUserId = auth()->user()->id_usuario ?? auth()->id();
        if ($currentUserId == $id) {
            return back()->with('error', 'No puedes modificar tu propio rol de administrador por seguridad.');
        }

        // Buscar y actualizar usuario
        $usuario = User::where('id_usuario', $id)->firstOrFail();
        $rolAnterior = $usuario->rol == 1 ? 'Administrador' : 'Usuario';
        $usuario->rol = ($usuario->rol == 1) ? 0 : 1;
        $usuario->save();

        $rolNuevo = $usuario->rol == 1 ? 'Administrador' : 'Usuario';
        return back()->with('success', "Rol de {$usuario->nombre} actualizado: {$rolAnterior} → {$rolNuevo}");
    }

    /**
     * FUNCIONES AUXILIARES
     */
    
    /**
     * Calcula la curva de producción mensual estimada basada en el total anual.
     * 
     * Utiliza factores de distribución mensual típicos para la región mediterránea,
     * donde los meses de verano (junio-julio) tienen mayor producción solar.
     * 
     * @param float $total Producción anual total en kWh
     * @return array Array con 12 valores (uno por mes) en kWh
     */
    private function calcularCurvaMensual(float $total): array
    {
        // Factores de distribución mensual para clima mediterráneo
        // Valores normalizados que suman aproximadamente 1.0
        $factoresMensuales = [
            0.05, // Enero
            0.06, // Febrero
            0.09, // Marzo
            0.11, // Abril
            0.13, // Mayo
            0.14, // Junio (pico)
            0.14, // Julio (pico)
            0.12, // Agosto
            0.09, // Septiembre
            0.07, // Octubre
            0.05, // Noviembre
            0.05  // Diciembre
        ];
        
        // Aplicar factores al total anual y redondear a 2 decimales
        return array_map(fn($factor) => round($total * $factor, 2), $factoresMensuales);
    }
}
