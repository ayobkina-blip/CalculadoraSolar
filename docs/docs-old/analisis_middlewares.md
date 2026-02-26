# Middlewares

Esta documentación analiza los middlewares personalizados implementados para gestionar la seguridad, los roles y los límites de uso del sistema.

---

## 1. `EsAdmin` (Middleware de Administración)

**Propósito:** Restringir el acceso a las funciones de gestión global únicamente a usuarios con privilegios de administrador.

### Código del método `handle`
```php
public function handle(Request $request, Closure $next): Response
{
    // Verificar que el usuario esté autenticado y tenga rol de administrador
    if (auth()->check() && (auth()->user()->rol === 1 || auth()->user()->es_admin)) {
        return $next($request);
    }
    
    // Denegar acceso si no es administrador
    abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
}
```

### Explicación Línea a Línea
1.  `if (auth()->check() && ...)`: Primero valida que exista una sesión activa.
2.  `(...->rol === 1 || ...->es_admin)`: Comprueba si el campo `rol` en la tabla `usuarios` es igual a 1 o si el atributo virtual `es_admin` (definido en el modelo User) es verdadero.
3.  `return $next($request)`: Si la condición se cumple, permite que la solicitud continúe hacia el controlador.
4.  `abort(403, ...)`: Si falla, detiene la ejecución inmediatamente y devuelve una respuesta de error 403 (Prohibido) con un mensaje amigable.

### Aplicación y Respuesta
*   **Respuesta de Fallo:** `Abort 403 (JSON o vista de error de Laravel)`.
*   **Rutas Aplicadas:** Grupo de rutas con prefijo `admin/` (Gestión de usuarios, cambio de roles, estadísticas globales, exportación administrativa).
*   **Sentido:** Es vital para proteger datos sensibles de todos los usuarios y evitar que usuarios estándar manipulen la configuración del sistema.

---

## 2. `EnsurePremiumFeature` (Acceso a Funciones Premium)

**Propósito:** Controlar el acceso granular a características específicas según el plan de suscripción del usuario.

### Código del método `handle`
```php
public function handle(Request $request, Closure $next, string $feature): Response|RedirectResponse
{
    $user = $request->user();

    if (!$user || !$this->subscriptionAccess->hasFeature($user, $feature)) {
        return redirect()
            ->route('premium.index', ['reason' => $feature])
            ->with('premium_reason', $feature)
            ->with('error', 'Esta función está disponible solo para cuentas Premium.');
    }

    return $next($request);
}
```

### Explicación Línea a Línea
1.  `$user = $request->user()`: Obtiene la instancia del usuario que realiza la petición.
2.  `!$user || ...`: Seguridad básica de nulidad (aunque suele ir tras `auth`).
3.  `!$this->subscriptionAccess->hasFeature($user, $feature)`: Delega en el servicio `SubscriptionAccessService` la comprobación de si el plan actual del usuario incluye la "feature" solicitada (pasada como parámetro desde la ruta).
4.  `return redirect()->route(...)`: Si no tiene el permiso, redirige al usuario a la página de planes premium.
5.  `->with('premium_reason', $feature)`: Pasa la razón del bloqueo para que la vista premium pueda resaltar qué ventaja obtendría al suscribirse.

### Aplicación y Respuesta
*   **Respuesta de Fallo:** `Redirección (302)` a la ruta `premium.index` con mensajes flash de error.
*   **Rutas Aplicadas:**
    *   `/solar/descargar-pdf/{id}` (Feature: `pdf_export`)
    *   `/premium/compare` (Feature: `result_compare`)
    *   `/premium/export/csv` (Feature: `csv_export`)
*   **Sentido:** Permite monetizar la aplicación bloqueando solo las herramientas avanzadas sin impedir el uso de la calculadora básica.

---

## 3. `EnsureSimulationQuota` (Cuota de Simulaciones)

**Propósito:** Implementar límites de uso en la calculadora para usuarios del plan gratuito.

### Código del método `handle`
```php
public function handle(Request $request, Closure $next): Response|RedirectResponse
{
    $user = $request->user();

    if (!$user || !$this->subscriptionAccess->canCreateSimulation($user)) {
        return redirect()
            ->route('premium.index', ['reason' => 'simulation_quota'])
            ->with('premium_reason', 'simulation_quota')
            ->with('error', 'Has alcanzado el límite gratuito de 3 simulaciones.');
    }

    return $next($request);
}
```

### Explicación Línea a Línea
1.  `$user = $request->user()`: Identifica al usuario.
2.  `!$this->subscriptionAccess->canCreateSimulation($user)`: El servicio comprueba el límite del plan (ej. 3 para el plan 'free') contra el conteo de registros en la tabla `resultados` para ese usuario.
3.  `return redirect()->route(...)`: Si se superó el límite, redirige a la selección de planes.
4.  `->with('premium_reason', 'simulation_quota')`: Indica específicamente que el bloqueo es por falta de cuota.

### Aplicación y Respuesta
*   **Respuesta de Fallo:** `Redirección (302)` a la ruta `premium.index`.
*   **Rutas Aplicadas:** `POST /calculadora/procesar`.
*   **Sentido:** Evita el abuso de recursos del servidor (llamadas a la API de PVGIS) y sirve como disparador para la conversión de usuarios gratuitos a premium.
