# Controladores

Esta documentación detalla el propósito, la lógica y la estructura de los controladores principales de la Aplicación de Calculadora Solar.

---

## 1. `SolarController`

**Propósito:** Es el controlador central de la aplicación. Gestiona desde el panel de administración global hasta el motor de cálculo fotovoltaico, la exportación de resultados y las estadísticas del sistema.

### Métodos

#### `adminIndex(Request $request)`
*   **Firma:** `public function adminIndex(Request $request)`
*   **Recibe:** Un objeto `Request` con posibles filtros (`estado`, `buscar`, `orden`).
*   **Lógica:**
    1.  Inicia una consulta sobre el modelo `Resultado` cargando la relación `usuario`.
    2.  Aplica filtros de búsqueda por ubicación o datos del usuario (nombre/email) e incluye un filtro por estado.
    3.  Gestiona la ordenación mediante un `switch` (fecha, potencia, ahorro).
    4.  Pagina los resultados (15 por página).
    5.  Obtiene la lista de usuarios con el conteo de sus resultados y sus suscripciones activas.
    6.  Recupera los planes de suscripción premium disponibles.
*   **Devuelve:** Una vista `solarcalc.admin` con los datos compactados.
*   **Excepciones/Validaciones:** No aplica validaciones formales, pero maneja valores predeterminados para la ordenación.

#### `calculadora(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function calculadora(Request $request, SubscriptionAccessService $subscriptionAccess): View`
*   **Recibe:** `Request` y la inyección del servicio `SubscriptionAccessService`.
*   **Lógica:** Obtiene datos de cuotas de simulación y estado de suscripción del usuario actual mediante el servicio inyectado.
*   **Devuelve:** Vista `solarcalc.calculadora`.

#### `dashboard()`
*   **Firma:** `public function dashboard()`
*   **Lógica:**
    1.  Filtra los últimos 5 presupuestos del usuario autenticado.
    2.  Calcula métricas agregadas: total de simulaciones, ahorro total acumulado y producción de energía total.
    3.  Calcula indicadores ambientales: Toneladas de CO2 evitadas (0.25 kg/kWh) y árboles equivalentes (0.04 árboles/kWh).
    4.  Genera una curva de producción mensual estimada mediante el método privado `calcularCurvaMensual`.
*   **Devuelve:** Vista `dashboard` con todas las métricas.

#### `estadisticas(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function estadisticas(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Lógica:** 
    1.  Verifica si el usuario tiene permiso para ver estadísticas avanzadas (`FEATURE_ADVANCED_STATS`).
    2.  Si no tiene permiso, devuelve una vista de "teaser" o adelanto.
    3.  Si tiene permiso, calcula sumatorios globales de ahorro y producción, y agrupa las simulaciones por día de los últimos 30 días.
*   **Devuelve:** Vista `solarcalc.estadisticas` o `solarcalc.estadisticas-teaser`.

#### `adminEstadisticas()`
*   **Firma:** `public function adminEstadisticas()`
*   **Lógica:** Recopila métricas globales para el administrador: total de usuarios, simulaciones por estado, actividad mensual, top usuarios por número de simulaciones y promedios de ahorro.
*   **Devuelve:** Vista `solarcalc.admin-estadisticas`.

#### `presupuestos(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function presupuestos(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Lógica:** Lista y filtra (por búsqueda y orden) los presupuestos del usuario autenticado con paginación de 10 elementos. Consulta los permisos premium para activar/desactivar botones de descarga o exportación.
*   **Devuelve:** Vista `solarcalc.presupuestos`.

#### `exportarCSV(Request $request)`
*   **Firma:** `public function exportarCSV(Request $request)`
*   **Lógica:** Genera un flujo de datos CSV de los resultados filtrados. Incluye BOM para compatibilidad con Excel (UTF-8) y escribe los encabezados y filas manualmente.
*   **Devuelve:** Un `stream` de respuesta con headers de descarga de archivo.

#### `cambiarEstado(Request $request, $id)`
*   **Firma:** `public function cambiarEstado(Request $request, $id)`
*   **Lógica:** Valida que el estado sea uno de los permitidos (`pendiente`, `aprobado`, `rechazado`), busca el resultado por `id_resultado` y lo actualiza.
*   **Validaciones:** `request->validate()` con mensajes personalizados en español.
*   **Retorno:** Redirección atrás con mensaje de éxito.

#### `mostrarResultado($id, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function mostrarResultado($id, SubscriptionAccessService $subscriptionAccess)`
*   **Lógica:** Busca un resultado asegurando que pertenezca al usuario autenticado.
*   **Excepciones:** `firstOrFail()` lanza 404 si no se encuentra o no pertenece al usuario.
*   **Retorno:** Vista `solarcalc.resultados`.

#### `procesar(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function procesar(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Lógica (Motor de Cálculo):**
    1.  **Cuota:** Verifica si el usuario puede realizar simulaciones mediante el servicio.
    2.  **Validación:** Reglas estrictas sobre consumo (50-10000), superficie (10-10000), orientación e inclinación.
    3.  **API PVGIS:** Realiza una llamada HTTP a la API de la UE para obtener la radiación solar exacta basándose en latitud/longitud. Extrae la producción anual estimada por kWp (`E_y`).
    4.  **Fallback:** Si la API falla, usa una tabla interna de HSP por provincias españolas.
    5.  **Dimensionamiento:** Calcula la potencia necesaria vs el límite de espacio físico (2m2 por panel). Determina los paneles finales y la potencia instalada.
    6.  **Finanzas:** Calcula el coste total (fijo + variable), ahorro anual y el ROI (años).
    7.  **Persistencia:** Crea el registro en la tabla `resultados`.
*   **Retorno:** Redirección a la vista del resultado generado.

#### `descargarPDF($id, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function descargarPDF($id, SubscriptionAccessService $subscriptionAccess)`
*   **Lógica:** Verifica el permiso `pdf_export`, carga el registro y genera el PDF usando la librería `Barryvdh\DomPDF`.
*   **Retorno:** Descarga del archivo PDF.

#### `cambiarRol(Request $request, $id)`
*   **Firma:** `public function cambiarRol(Request $request, $id)`
*   **Lógica:** Impide la auto-degradación (un admin no puede quitarse su propio permiso) y alterna el valor de `rol` entre 0 y 1.
*   **Retorno:** Redirección atrás con éxito/error.

---

## 2. `PremiumController`

**Propósito:** Gestiona las vistas y acciones exclusivas de los planes de pago, como la comparación de múltiples simulaciones y la exportación de datos de usuario.

### Métodos

#### `index(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function index(Request $request, SubscriptionAccessService $subscriptionAccess): View`
*   **Lógica:** Prepara los datos para la página de suscripción premium, incluyendo el catálogo de planes y el estado actual del usuario.
*   **Retorno:** Vista `solarcalc.premium`.

#### `compare(Request $request, SubscriptionAccessService $subscriptionAccess)`
*   **Firma:** `public function compare(Request $request, SubscriptionAccessService $subscriptionAccess): View`
*   **Recibe:** Array de IDs de resultados en el Request.
*   **Lógica:** 
    1.  Valida que se envíen entre 2 y 3 IDs distintos.
    2.  Recupera los resultados de la DB asegurando que pertenezcan al usuario.
    3.  Ordena los resultados para que coincidan con la selección del usuario.
*   **Excepciones:** `abort(403)` si se intentan cargar resultados ajenos.
*   **Retorno:** Vista `solarcalc.premium` con los datos de comparación.

#### `exportCsv(Request $request)`
*   **Firma:** `public function exportCsv(Request $request): StreamedResponse`
*   **Lógica:** Similar al exportador global pero limitado a los datos propios del usuario autenticado.
*   **Retorno:** Descarga de CSV.

---

## 3. `ProfileController`

**Propósito:** Encargado de la gestión de la cuenta personal del usuario (perfil, email, avatar y eliminación de cuenta).

### Métodos

#### `edit(Request $request)`
*   **Firma:** `public function edit(Request $request): View`
*   **Lógica:** Obtiene el conteo total de simulaciones del usuario y calcula su ahorro medio histórico para mostrarlo en el formulario de perfil.
*   **Retorno:** Vista `profile.edit`.

#### `update(ProfileUpdateRequest $request)`
*   **Firma:** `public function update(ProfileUpdateRequest $request): RedirectResponse`
*   **Lógica:** 
    1.  Gestiona la subida de avatar: borra el archivo anterior si existe y guarda el nuevo en el disco `public`.
    2.  Actualiza el nombre (`nombre`) y el email solo si se proporcionan.
    3.  Si el email cambia, marca el usuario como no verificado (`email_verified_at = null`).
*   **Validaciones:** Usa la clase `ProfileUpdateRequest` para reglas complejas de unicidad e imágenes.
*   **Retorno:** Redirección con estatus de éxito.

#### `destroy(Request $request)`
*   **Firma:** `public function destroy(Request $request): RedirectResponse`
*   **Lógica:** Valida la contraseña actual, cierra la sesión del usuario, elimina el registro de la base de datos (con borrado en cascada configurado en BD) e invalida la sesión.
*   **Retorno:** Redirección a la home.

---

## 4. `AdminSubscriptionController`

**Propósito:** Proporciona herramientas de administración para gestionar manualmente las suscripciones de los usuarios (asignar planes premium, cancelar suscripciones).

### Métodos

#### `update(Request $request, int $id)`
*   **Firma:** `public function update(Request $request, int $id): RedirectResponse`
*   **Lógica:** 
    1.  Si el plan elegido es `free`, cancela la suscripción activa actual.
    2.  Si es un plan premium, calcula las fechas de inicio y fin (por defecto suma un mes o un año según el intervalo del plan).
    3.  Cancela cualquier suscripción previa activa y crea una nueva entrada en `user_subscriptions`.
*   **Validaciones:** Verifica que el código del plan exista y sea válido.
*   **Retorno:** Redirección atrás con mensaje explicativo.

#### `cancel(Request $request, int $id)`
*   **Firma:** `public function cancel(Request $request, int $id): RedirectResponse`
*   **Lógica:** Busca la suscripción activa del usuario por su ID y marca el estado como `cancelled` con fecha de fin inmediata.
*   **Retorno:** Mensaje de éxito o error si no había nada que cancelar.

---

## 5. `UsuarioController`

**Propósito:** Gestión básica de visualización de usuarios registrados.

### Métodos

#### `index()`
*   **Firma:** `public function index(): View`
*   **Lógica:** Obtiene todos los usuarios utilizando `withCount('resultados')` para rendimiento, permitiendo ver de un vistazo quiénes son los usuarios más activos.
*   **Retorno:** Vista `usuarios.usuarios`.

#### `show($id)`
*   **Firma:** `public function show($id)`
*   **Lógica:** Busca un usuario por ID o devuelve 404.
*   **Retorno:** Vista `usuarios.show`.

---

## Servicios y Clases Auxiliares

### `SubscriptionAccessService`
Utilizado masivamente por `SolarController` y `PremiumController` para:
- `getCurrentPlan($user)`: Identificar el plan actual del usuario (incluyendo bypass para admins).
- `hasFeature($user, $feature)`: Comprobar si un usuario tiene acceso a una característica específica (PDF, CSV, Comparar).
- `remainingSimulations($user)`: Calcular cuántas simulaciones gratuitas le quedan.

### `ProfileUpdateRequest`
Encargado de la lógica de validación del perfil, asegurando que:
- El email sea único en la tabla `usuarios` (ignorando al usuario actual).
- El avatar cumpla con requisitos de tamaño (2MB) y tipo (mimes).
