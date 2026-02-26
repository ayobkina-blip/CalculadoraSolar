# Servicios y Lógica de Negocio

Esta documentación describe los servicios internos de la aplicación que centralizan la lógica de negocio, especialmente lo referente a suscripciones y permisos.

---

## 1. `SubscriptionAccessService`

**Propósito:** Actúa como el motor de autorización y lógica de negocio para el modelo "Freemium" de la aplicación. Centraliza las reglas sobre qué puede hacer cada usuario según su plan de suscripción, gestionando cuotas de simulación, acceso a características premium y la lógica de "bypass" para administradores.

### Métodos Públicos

#### `getCurrentPlan(User $user)`
*   **Firma:** `public function getCurrentPlan(User $user): SubscriptionPlan`
*   **Parámetros:** Objeto `User` del que se desea consultar el plan.
*   **Lógica:**
    1.  Si el usuario es administrador (vía `isAdminBypass`), devuelve un plan virtual con todos los permisos.
    2.  Busca la suscripción activa actual del usuario.
    3.  Si existe una suscripción, devuelve su modelo `plan` asociado.
    4.  Si no hay suscripción, devuelve el plan por defecto "Free".
*   **Valor de Retorno:** Una instancia de `SubscriptionPlan`.
*   **Invocado por:** `SolarController`, `PremiumController`, y otros métodos internos del servicio.

#### `getCurrentSubscription(User $user)`
*   **Firma:** `public function getCurrentSubscription(User $user): ?UserSubscription`
*   **Lógica:** Realiza una limpieza proactiva marcando como `expired` cualquier suscripción cuya fecha `ends_at` sea pasada. Luego busca la suscripción con `status = active` vigente en el momento actual.
*   **Valor de Retorno:** `UserSubscription` o `null`.

#### `hasFeature(User $user, string $feature)`
*   **Firma:** `public function hasFeature(User $user, string $feature): bool`
*   **Parámetros:** `User` usuario, `string` código de la funcionalidad (ej. `pdf_export`).
*   **Lógica:** Comprueba si el código de la funcionalidad está presente en el array de `features` del plan actual del usuario. Los administradores siempre tienen `true`.
*   **Valor de Retorno:** Booleano.
*   **Invocado por:** `EnsurePremiumFeature` (Middleware), `SolarController`.

#### `remainingSimulations(User $user)`
*   **Firma:** `public function remainingSimulations(User $user): ?int`
*   **Lógica:** Consulta el `simulation_limit` del plan actual. Si es nulo (plan ilimitado o admin), devuelve `null`. Si no, resta el número de registros en la tabla `resultados` de ese usuario del límite total. Asegura que el resultado nunca sea menor a 0.
*   **Valor de Retorno:** `int` (restantes) o `null` (ilimitado).
*   **Invocado por:** `SolarController`, `PremiumController`, `EnsureSimulationQuota` (Middleware).

#### `canCreateSimulation(User $user)`
*   **Firma:** `public function canCreateSimulation(User $user): bool`
*   **Lógica:** Atajo que devuelve `true` si `remainingSimulations` es nulo o mayor que 0.
*   **Valor de Retorno:** Booleano.
*   **Invocado por:** `SolarController`, `EnsureSimulationQuota` (Middleware).

#### `isPremiumActive(User $user)`
*   **Firma:** `public function isPremiumActive(User $user): bool`
*   **Lógica:** Verifica si el código del plan actual del usuario es distinto de `free`.
*   **Valor de Retorno:** Booleano.
*   **Invocado por:** `SolarController`, `PremiumController`.

#### `getPlanCatalog()`
*   **Firma:** `public function getPlanCatalog(): Collection`
*   **Lógica:** Recupera de la base de datos los planes premium activos (mensual y anual) ordenados racionalmente.
*   **Valor de Retorno:** Colección de `SubscriptionPlan`.
*   **Invocado por:** `PremiumController`.

---

## Invocaciones y dependencias

### Consumo desde Middlewares
*   `EnsurePremiumFeature`: Usa `hasFeature()` para bloquear rutas dinámicamente según la característica requerida.
*   `EnsureSimulationQuota`: Usa `canCreateSimulation()` para impedir nuevas simulaciones en el plan gratuito una vez superado el límite.

### Consumo desde Controladores
*   `SolarController`:
    *   `calculadora()`: Usa el servicio para mostrar las simulaciones restantes en la UI.
    *   `procesar()`: Valida la cuota antes de iniciar el cálculo.
    *   `descargarPDF()`: Verifica el acceso a la feature de exportación.
    *   `estadisticas()`: Verifica el acceso a estadísticas avanzadas.
*   `PremiumController`:
    *   `index()`: Obtiene el catálogo de planes y el estado premium del usuario.
    *   `compare()`: Verifica el acceso a la herramienta de comparación.

### Consumo desde Modelos (Indirecto)
*   El modelo `User` expone el método `activeSubscription()` que facilita el trabajo del servicio, aunque el servicio prefiere realizar su propia consulta para manejar expiraciones proactivas.
