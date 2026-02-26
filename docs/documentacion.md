# CalculadoraSolar — Documentación Técnica

> Plataforma web para la simulación, análisis y gestión de proyectos de energía solar fotovoltaica.  
> Construida con **Laravel 12** · **MySQL** · **Alpine.js** · **Tailwind CSS**  
> Documentación generada el 26 de febrero de 2026.

---

## Índice

1. [Introducción](#1-introducción)
2. [Instalación y Configuración](#2-instalación-y-configuración)
3. [Arquitectura del Sistema](#3-arquitectura-del-sistema)
4. [Autenticación y Roles](#4-autenticación-y-roles)
5. [Modelos y Base de Datos](#5-modelos-y-base-de-datos)
6. [Controladores](#6-controladores)
7. [Servicios — Lógica de Negocio](#7-servicios--lógica-de-negocio)
8. [Middlewares Personalizados](#8-middlewares-personalizados)
9. [Rutas de la Aplicación](#9-rutas-de-la-aplicación)
10. [Vistas y Frontend](#10-vistas-y-frontend)

---

## 1. Introducción

**CalculadoraSolar** permite a propietarios de viviendas y empresas estimar el potencial de ahorro energético de una instalación fotovoltaica. La plataforma integra datos geográficos precisos a través de la API PVGIS (Unión Europea) y algoritmos de ingeniería fotovoltaica para generar proyecciones realistas de producción energética y retorno de inversión (ROI).

### Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Framework backend | Laravel 12 |
| Autenticación | Laravel Breeze (UI) + Laravel Fortify (lógica) |
| Base de datos | MySQL / MariaDB |
| Frontend | Tailwind CSS v4, Alpine.js, Vite |
| Mapas | MapLibre GL JS + Nominatim (OpenStreetMap) |
| Gráficos | Chart.js |
| Generación PDF | barryvdh/laravel-dompdf |
| API externa | PVGIS v5.2 (Comisión Europea) |

### Requisitos del sistema

- PHP ^8.2 con extensión GD o Imagick
- Composer
- Node.js y NPM
- MySQL 8+ o MariaDB 10.6+

---

## 2. Instalación y Configuración

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio> CalculadoraSolar
cd CalculadoraSolar

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias de frontend
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Compilar assets y arrancar servidor
npm run dev
php artisan serve
```

### Variables de entorno clave

| Variable | Descripción |
|----------|-------------|
| `DB_DATABASE` | Nombre de la base de datos |
| `DB_USERNAME` / `DB_PASSWORD` | Credenciales de acceso |
| `MAIL_MAILER` | Driver de correo para verificación de email |
| `MAIL_FROM_ADDRESS` | Dirección remitente del sistema |
| `FILESYSTEM_DISK` | Disco de almacenamiento para avatares (`public`) |

---

## 3. Arquitectura del Sistema

### Estructura de carpetas relevante

```
app/
├── Http/
│   ├── Controllers/      — Controladores de la aplicación
│   ├── Middleware/        — Middlewares personalizados (admin, premium, quota)
│   └── Requests/          — Form Requests con reglas de validación
├── Models/               — Modelos Eloquent
└── Services/             — Lógica de negocio (SubscriptionAccessService)

resources/views/
├── layouts/              — app.blade.php, navigation.blade.php
├── solarcalc/            — Vistas principales de la aplicación
├── profile/              — Gestión de perfil de usuario
└── auth/                 — Scaffolding de Breeze/Fortify

routes/
├── web.php               — Rutas principales
└── auth.php              — Rutas de autenticación
```

### Flujo de una simulación

```
Usuario → GET /calculadora
          └─ SolarController@calculadora
                └─ Muestra formulario con mapa MapLibre + datos de cuota

Usuario → POST /calculadora/procesar
          └─ Middleware: simulation.quota (verifica límite del plan)
          └─ SolarController@procesar
                ├─ Valida parámetros de entrada
                ├─ Llama a API PVGIS con lat/lon → obtiene E_y (kWh/kWp·año)
                │    └─ Fallback: tabla interna de HSP por provincias
                ├─ Calcula paneles, potencia, coste, ahorro y ROI
                ├─ Persiste en tabla `resultados`
                └─ Redirige a GET /resultados/{id}
```

---

## 4. Autenticación y Roles

El sistema usa **Laravel Breeze** para los formularios de autenticación y **Laravel Fortify** para la lógica de backend, incluyendo soporte para autenticación de dos factores (2FA).

### Flujos disponibles

- **Registro** — Formulario estándar con verificación de email obligatoria.
- **Login** — Sesión con opción de "recuérdame" y protección contra fuerza bruta.
- **Recuperación de contraseña** — Envío de enlace por email.
- **2FA** — Configurable por el usuario desde los ajustes de perfil.
- **Verificación de email** — Requerida para acceder al dashboard y la calculadora.

### Roles de usuario

| Valor `rol` | Tipo | Permisos |
|-------------|------|---------|
| `0` | Usuario estándar | Calculadora, sus propios resultados, perfil |
| `1` | Administrador | Acceso total + panel de administración + cambio de roles |

> Los administradores tienen bypass automático en el `SubscriptionAccessService`, lo que les otorga acceso ilimitado a todas las funcionalidades premium sin necesidad de suscripción activa.

---

## 5. Modelos y Base de Datos

### Diagrama de relaciones

```
    +-----------+              +---------------------+
    |  usuarios | <----------+ |  user_subscriptions |
    +-----------+ (usuario_fr) +---------------------+
    | id_usuario|              | id (PK)             |
    | nombre    | <----------+ | usuario_fr (FK)     |
    | email     | (activat_by) | plan_fr (FK)        |
    +-----------+              | status              |
          ^                    +---------------------+
          |                               |
          | (usuario_fr)                  | (plan_fr)
          |                               v
    +-----------+              +---------------------+
    | resultados|              | subscription_plans  |
    +-----------+              +---------------------+
    |id_resultado              | id (PK)             |
    |usuario_fr  |             | code (UNIQUE)       |
    |estadist_fr |             | name, price_cents...|
    +-----------+              +---------------------+
          |
          v
    +---------------+
    |  estadisticas |
    +---------------+
    | id_estadistica|
    +---------------+
```

---

### 5.1 Modelo `User`

**Tabla:** `usuarios` · **PK:** `id_usuario`

| Columna | Tipo | Null | Default | Notas |
|---------|------|------|---------|-------|
| `id_usuario` | bigint unsigned | No | AUTO_INCREMENT | PRIMARY |
| `nombre` | varchar(100) | No | | |
| `email` | varchar(100) | No | | UNIQUE |
| `avatar` | varchar(255) | Sí | NULL | Ruta en disco `public` |
| `rol` | tinyint | No | `0` | 0=usuario, 1=admin |
| `contrasena_hash` | varchar(255) | No | | Cast: `hashed` |
| `email_verified_at` | timestamp | Sí | NULL | Cast: `datetime` |
| `remember_token` | varchar(100) | Sí | NULL | |
| `created_at` / `updated_at` | timestamp | Sí | NULL | |

**Relaciones Eloquent:**

```php
// Historial de simulaciones del usuario
public function resultados(): HasMany
    → hasMany(Resultado::class, 'usuario_fr', 'id_usuario')

// Todas las suscripciones históricas
public function subscriptions(): HasMany
    → hasMany(UserSubscription::class, 'usuario_fr', 'id_usuario')

// Suscripción vigente actual
public function activeSubscription(): HasOne
    → hasOne(UserSubscription::class, 'usuario_fr', 'id_usuario')
       ->where('status', 'active')
```

---

### 5.2 Modelo `Resultado`

**Tabla:** `resultados` · **PK:** `id_resultado`

| Columna | Tipo | Null | Default | Notas |
|---------|------|------|---------|-------|
| `id_resultado` | bigint unsigned | No | AUTO_INCREMENT | PRIMARY |
| `ubicacion` | varchar(100) | Sí | NULL | |
| `latitud` | decimal(10,8) | Sí | NULL | Cast: `decimal:8` |
| `longitud` | decimal(11,8) | Sí | NULL | Cast: `decimal:8` |
| `consumo_anual` | int | Sí | NULL | kWh/año · Cast: `float` |
| `superficie_disponible` | decimal(10,2) | Sí | NULL | m² |
| `orientacion` | int | No | `0` | Azimut en grados |
| `inclinacion` | int | No | `30` | Grados |
| `paneles_sugeridos` | int | Sí | NULL | Cast: `integer` |
| `potencia_instalacion_kwp` | float | Sí | NULL | Cast: `float` |
| `produccion_anual_kwh` | float | Sí | NULL | Cast: `float` |
| `ahorro_estimado_eur` | decimal(10,2) | Sí | NULL | Cast: `float` |
| `roi_anyos` | decimal(5,2) | Sí | NULL | Cast: `float` |
| `radiacion_a_medida` | int | Sí | NULL | Dato de PVGIS |
| `fuerza` | int | Sí | NULL | Parámetro técnico |
| `estado` | varchar(255) | No | `'pendiente'` | pendiente / verificado / rechazado |
| `usuario_fr` | bigint unsigned | Sí | NULL | FK → `usuarios.id_usuario` |
| `estadistica_fr` | bigint unsigned | Sí | NULL | FK → `estadisticas.id_estadistica` |
| `created_at` / `updated_at` | timestamp | Sí | NULL | Cast: `datetime` |

**Scopes:**
```php
// Filtra resultados con ahorro superior a 1.000 €/año
public function scopeAltoAhorro($query)
    → where('ahorro_estimado_eur', '>', 1000)
```

**Relaciones Eloquent:**
```php
public function usuario(): BelongsTo
    → belongsTo(User::class, 'usuario_fr', 'id_usuario')
```

---

### 5.3 Modelo `SubscriptionPlan`

**Tabla:** `subscription_plans` · **PK:** `id`

| Columna | Tipo | Null | Default | Notas |
|---------|------|------|---------|-------|
| `id` | bigint unsigned | No | AUTO_INCREMENT | PRIMARY |
| `code` | varchar(60) | No | | UNIQUE (ej: `free`, `premium_monthly`) |
| `name` | varchar(120) | No | | Nombre comercial |
| `price_cents` | int unsigned | No | `0` | Precio en céntimos · Cast: `integer` |
| `currency` | varchar(3) | No | `'EUR'` | |
| `interval` | varchar(20) | No | `'none'` | `none` / `month` / `year` |
| `simulation_limit` | int unsigned | Sí | NULL | NULL = ilimitado · Cast: `integer` |
| `features` | json | Sí | NULL | Array de slugs de features · Cast: `array` |
| `is_active` | tinyint(1) | No | `1` | Cast: `boolean` |
| `created_at` / `updated_at` | timestamp | Sí | NULL | |

**Relaciones Eloquent:**
```php
public function subscriptions(): HasMany
    → hasMany(UserSubscription::class, 'plan_fr', 'id')
```

---

### 5.4 Modelo `UserSubscription`

**Tabla:** `user_subscriptions` · **PK:** `id`

| Columna | Tipo | Null | Default | Notas |
|---------|------|------|---------|-------|
| `id` | bigint unsigned | No | AUTO_INCREMENT | PRIMARY |
| `usuario_fr` | bigint unsigned | No | | FK → `usuarios` · Index |
| `plan_fr` | bigint unsigned | No | | FK → `subscription_plans` |
| `status` | varchar(20) | No | `'active'` | `active` / `expired` / `cancelled` · Index |
| `starts_at` | timestamp | Sí | NULL | Cast: `datetime` · Index |
| `ends_at` | timestamp | Sí | NULL | Cast: `datetime` · Index |
| `activated_by_fr` | bigint unsigned | Sí | NULL | FK → admin que activó |
| `source` | varchar(40) | No | `'manual_admin'` | Origen de la suscripción |
| `notes` | text | Sí | NULL | Notas del administrador |
| `created_at` / `updated_at` | timestamp | Sí | NULL | |

**Relaciones Eloquent:**
```php
public function user(): BelongsTo
    → belongsTo(User::class, 'usuario_fr', 'id_usuario')

public function plan(): BelongsTo
    → belongsTo(SubscriptionPlan::class, 'plan_fr', 'id')

public function activatedBy(): BelongsTo
    → belongsTo(User::class, 'activated_by_fr', 'id_usuario')
```

---

## 6. Controladores

### 6.1 `SolarController`

Controlador central de la aplicación. Gestiona el motor de cálculo fotovoltaico, el dashboard de usuario, las estadísticas, la exportación y el panel de administración.

---

#### `calculadora(Request $request, SubscriptionAccessService $subscriptionAccess): View`

Muestra el formulario de la calculadora solar. Inyecta los datos de cuota y estado de suscripción del usuario para mostrar las simulaciones restantes en la UI.

**Devuelve:** Vista `solarcalc.calculadora`

---

#### `procesar(Request $request, SubscriptionAccessService $subscriptionAccess)`

Motor de cálculo principal. Ejecuta el siguiente flujo:

1. **Cuota** — Verifica mediante el servicio que el usuario puede crear una nueva simulación.
2. **Validación** — Aplica reglas estrictas: consumo entre 50 y 10.000 kWh, superficie entre 10 y 10.000 m², orientación e inclinación dentro de rangos físicos válidos.
3. **API PVGIS** — Realiza una petición HTTP a la API de la UE con las coordenadas de la ubicación. Extrae el campo `E_y` (producción anual estimada por kWp).
4. **Fallback** — Si la API no responde, usa una tabla interna de Horas Solares Pico (HSP) por provincias españolas.
5. **Dimensionamiento** — Calcula la potencia necesaria frente al límite de espacio físico (2 m² por panel). Determina el número final de paneles y la potencia instalada en kWp.
6. **Cálculo financiero** — Coste total (componente fija + variable por kWp), ahorro anual estimado y ROI en años.
7. **Persistencia** — Crea el registro en la tabla `resultados`.

**Devuelve:** Redirección a `solar.resultados` con el ID del nuevo resultado.

---

#### `mostrarResultado($id, SubscriptionAccessService $subscriptionAccess)`

Carga un resultado verificando que pertenezca al usuario autenticado mediante `firstOrFail()`. Lanza 404 si no se encuentra o pertenece a otro usuario.

**Devuelve:** Vista `solarcalc.resultados`

---

#### `dashboard()`

Panel personal del usuario. Calcula:

- Últimas 5 simulaciones.
- Métricas agregadas: total de simulaciones, ahorro acumulado y producción total.
- Indicadores ambientales: toneladas de CO₂ evitadas (0,25 kg/kWh) y árboles equivalentes (0,04 árboles/kWh).
- Curva de producción mensual estimada (método privado `calcularCurvaMensual`).

**Devuelve:** Vista `dashboard`

---

#### `estadisticas(Request $request, SubscriptionAccessService $subscriptionAccess)`

Comprueba si el usuario tiene acceso a la feature `FEATURE_ADVANCED_STATS`. Si no, devuelve una vista *teaser*. Si tiene acceso, calcula sumatorios globales de ahorro y producción agrupados por día de los últimos 30 días.

**Devuelve:** Vista `solarcalc.estadisticas` o `solarcalc.estadisticas-teaser`

---

#### `presupuestos(Request $request, SubscriptionAccessService $subscriptionAccess)`

Lista y filtra los presupuestos del usuario autenticado con paginación de 10 elementos. Consulta permisos premium para activar o desactivar botones de descarga y exportación.

**Devuelve:** Vista `solarcalc.presupuestos`

---

#### `descargarPDF($id, SubscriptionAccessService $subscriptionAccess)`

Verifica el permiso `pdf_export`, carga el registro y genera el PDF usando `Barryvdh\DomPDF` sobre la vista `solarcalc.pdf`.

**Devuelve:** Descarga del archivo PDF.

---

#### `exportarCSV(Request $request)`

Genera un stream CSV de los resultados del sistema (uso admin). Incluye BOM UTF-8 para compatibilidad con Excel. Escribe cabeceras y filas de forma manual sobre el stream.

**Devuelve:** `StreamedResponse` con headers de descarga.

---

#### `adminIndex(Request $request)`

Panel de auditoría para administradores. Aplica filtros por `estado`, texto de búsqueda y ordenación (`switch` por fecha, potencia o ahorro). Pagina los resultados a 15 por página. Carga también el listado de usuarios con conteo de simulaciones y planes disponibles.

**Devuelve:** Vista `solarcalc.admin`

---

#### `adminEstadisticas()`

Recopila KPIs globales: total de usuarios, simulaciones por estado, actividad mensual, top usuarios por número de simulaciones y promedios de ahorro.

**Devuelve:** Vista `solarcalc.admin-estadisticas`

---

#### `cambiarEstado(Request $request, $id)`

Valida que el estado sea uno de los permitidos (`pendiente`, `aprobado`, `rechazado`) con mensajes en español y actualiza el registro. 

**Devuelve:** Redirección atrás con mensaje de éxito.

---

#### `cambiarRol(Request $request, $id)`

Alterna el campo `rol` entre 0 y 1. Impide la auto-degradación: un administrador no puede quitarse su propio permiso.

**Devuelve:** Redirección atrás con mensaje de éxito o error.

---

### 6.2 `PremiumController`

Gestiona las vistas y acciones exclusivas de los planes de pago.

---

#### `index(Request $request, SubscriptionAccessService $subscriptionAccess): View`

Prepara la landing page de planes, incluyendo el catálogo de planes activos y el estado actual de la suscripción del usuario.

**Devuelve:** Vista `solarcalc.premium`

---

#### `compare(Request $request, SubscriptionAccessService $subscriptionAccess): View`

Valida que se envíen entre 2 y 3 IDs distintos de resultados. Recupera los modelos desde la base de datos asegurando que pertenezcan al usuario autenticado. Lanza `abort(403)` si se intenta cargar un resultado ajeno. Ordena los resultados según la selección original del usuario.

**Devuelve:** Vista `solarcalc.premium` con datos de comparación.

---

#### `exportCsv(Request $request): StreamedResponse`

Exportación CSV limitada a los datos propios del usuario autenticado.

**Devuelve:** `StreamedResponse` con descarga de CSV.

---

### 6.3 `ProfileController`

Gestión de la cuenta personal del usuario.

---

#### `edit(Request $request): View`

Obtiene el conteo total de simulaciones del usuario y calcula su ahorro medio histórico para mostrarlos en el formulario.

**Devuelve:** Vista `profile.edit`

---

#### `update(ProfileUpdateRequest $request): RedirectResponse`

1. Si se sube un avatar nuevo, elimina el anterior del disco `public` y guarda el nuevo.
2. Actualiza `nombre` y `email` si se proporcionan.
3. Si el email cambia, establece `email_verified_at = null` forzando re-verificación.

La validación la realiza la clase `ProfileUpdateRequest` (unicidad de email ignorando el usuario actual, tamaño máximo de avatar 2MB, tipos MIME permitidos).

**Devuelve:** Redirección con status de éxito.

---

#### `destroy(Request $request): RedirectResponse`

Valida la contraseña actual, cierra la sesión, elimina el registro de la base de datos (el borrado en cascada elimina también los resultados asociados, cumpliendo con RGPD) e invalida la sesión.

**Devuelve:** Redirección a la home.

---

### 6.4 `AdminSubscriptionController`

Herramientas para gestionar manualmente las suscripciones de los usuarios desde el panel de administración.

---

#### `update(Request $request, int $id): RedirectResponse`

Si el plan elegido es `free`, cancela la suscripción activa. Si es un plan premium, calcula las fechas de inicio y fin (suma 1 mes o 1 año según el intervalo del plan), cancela cualquier suscripción previa activa y crea la nueva entrada en `user_subscriptions`.

---

#### `cancel(Request $request, int $id): RedirectResponse`

Busca la suscripción activa del usuario y marca su estado como `cancelled` con fecha de fin inmediata. Devuelve error si no había suscripción activa.

---

### 6.5 `UsuarioController`

Gestión de visualización de usuarios desde el panel de administración.

---

#### `index(): View`

Obtiene todos los usuarios usando `withCount('resultados')` para mostrar de un vistazo los usuarios más activos.

**Devuelve:** Vista `usuarios.usuarios`

---

#### `show($id)`

Busca un usuario por ID o lanza 404.

**Devuelve:** Vista `usuarios.show`

---

## 7. Servicios — Lógica de Negocio

### `SubscriptionAccessService`

Centraliza toda la lógica de autorización del modelo freemium. Es el único punto de verdad para saber qué puede hacer un usuario en función de su plan. Todos los controladores y middlewares que necesitan verificar permisos lo hacen a través de este servicio.

---

#### `getCurrentPlan(User $user): SubscriptionPlan`

1. Si el usuario es administrador, devuelve un **plan virtual** con todos los permisos sin consultar la base de datos.
2. Si no, busca la suscripción activa y devuelve su plan asociado.
3. Si no hay suscripción, devuelve el plan por defecto `free`.

**Invocado por:** `SolarController`, `PremiumController`, métodos internos del servicio.

---

#### `getCurrentSubscription(User $user): ?UserSubscription`

Realiza una **limpieza proactiva**: marca como `expired` cualquier suscripción cuya fecha `ends_at` sea pasada antes de buscar la activa. Luego retorna la suscripción con `status = active` vigente, o `null`.

---

#### `hasFeature(User $user, string $feature): bool`

Comprueba si el slug de la funcionalidad (ej. `pdf_export`, `csv_export`, `result_compare`) está presente en el array JSON `features` del plan actual. Los administradores siempre reciben `true`.

**Invocado por:** Middleware `EnsurePremiumFeature`, `SolarController`.

---

#### `remainingSimulations(User $user): ?int`

Consulta `simulation_limit` del plan. Si es `null` (ilimitado o admin), devuelve `null`. Si no, devuelve `max(0, limite - conteo_actual)`.

**Invocado por:** `SolarController`, `PremiumController`, Middleware `EnsureSimulationQuota`.

---

#### `canCreateSimulation(User $user): bool`

Atajo que retorna `true` si `remainingSimulations` es `null` o `> 0`.

**Invocado por:** `SolarController`, Middleware `EnsureSimulationQuota`.

---

#### `isPremiumActive(User $user): bool`

Devuelve `true` si el código del plan actual es distinto de `free`.

---

#### `getPlanCatalog(): Collection`

Recupera los planes activos (mensual y anual) ordenados para mostrarlos en la landing de suscripción.

**Invocado por:** `PremiumController@index`.

---

## 8. Middlewares Personalizados

### 8.1 `EsAdmin`

**Propósito:** Bloquear el acceso a las rutas de administración para usuarios sin privilegios.

```php
public function handle(Request $request, Closure $next): Response
{
    if (auth()->check() && (auth()->user()->rol === 1 || auth()->user()->es_admin)) {
        return $next($request);
    }
    abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
}
```

**Lógica:** Verifica que exista sesión activa y que el usuario tenga `rol === 1` o el atributo virtual `es_admin`. Si no se cumple, detiene la ejecución con un HTTP 403.

**Rutas donde se aplica:** Todo el grupo con prefijo `admin/` — gestión de usuarios, cambio de roles, estadísticas globales y exportación administrativa.

---

### 8.2 `EnsurePremiumFeature`

**Propósito:** Control de acceso granular a funcionalidades según el plan de suscripción.

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

**Lógica:** Delega en `SubscriptionAccessService::hasFeature()` la comprobación. El parámetro `$feature` se pasa directamente desde la definición de la ruta (ej. `premium.feature:pdf_export`). Si el usuario no tiene el permiso, redirige a la landing premium pasando la razón del bloqueo, lo que permite a la vista resaltar la ventaja específica que obtendría al suscribirse.

| Ruta | Feature requerida |
|------|------------------|
| `GET /solar/descargar-pdf/{id}` | `pdf_export` |
| `POST /premium/compare` | `result_compare` |
| `GET /premium/export/csv` | `csv_export` |

---

### 8.3 `EnsureSimulationQuota`

**Propósito:** Limitar el número de simulaciones para usuarios del plan gratuito.

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

**Lógica:** Usa `canCreateSimulation()` del servicio, que compara el `simulation_limit` del plan (3 para el plan `free`) contra el conteo de registros en `resultados` del usuario. Si se supera el límite, redirige a la selección de planes antes de que se ejecute la lógica del controlador (y por tanto antes de realizar la llamada a la API PVGIS).

**Ruta donde se aplica:** `POST /calculadora/procesar`

---

## 9. Rutas de la Aplicación

### Rutas Públicas

| Método | URI | Nombre | Controlador | Descripción |
|--------|-----|--------|-------------|-------------|
| GET | `/` | `home` | Clausura | Página de aterrizaje |

### Autenticación (solo usuarios no autenticados)

| Método | URI | Nombre | Controlador | Descripción |
|--------|-----|--------|-------------|-------------|
| GET | `/register` | `register` | `RegisteredUserController@create` | Formulario de registro |
| POST | `/register` | — | `RegisteredUserController@store` | Procesa el registro |
| GET | `/login` | `login` | `AuthenticatedSessionController@create` | Formulario de login |
| POST | `/login` | — | `AuthenticatedSessionController@store` | Procesa el login |
| GET | `/forgot-password` | `password.request` | `PasswordResetLinkController@create` | Recuperación de contraseña |
| POST | `/forgot-password` | `password.email` | `PasswordResetLinkController@store` | Envía enlace de recuperación |
| GET | `/reset-password/{token}` | `password.reset` | `NewPasswordController@create` | Nueva contraseña |
| POST | `/reset-password` | `password.store` | `NewPasswordController@store` | Guarda nueva contraseña |

### Usuario Autenticado (`auth`, `verified`)

| Método | URI | Nombre | Controlador | Descripción |
|--------|-----|--------|-------------|-------------|
| GET | `/dashboard` | `dashboard` | `SolarController@dashboard` | Panel principal |
| GET | `/calculadora` | `solar.calculadora` | `SolarController@calculadora` | Formulario de simulación |
| POST | `/calculadora/procesar` | `solar.procesar` | `SolarController@procesar` | + MW: `simulation.quota` |
| GET | `/resultados/{id}` | `solar.resultados` | `SolarController@mostrarResultado` | Detalle de simulación |
| GET | `/presupuestos` | `solar.presupuestos` | `SolarController@presupuestos` | Historial de simulaciones |
| GET | `/estadisticas` | `solar.estadisticas` | `SolarController@estadisticas` | Métricas y gráficos |
| POST | `/logout` | `logout` | `AuthenticatedSessionController@destroy` | Cierra sesión |
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | Editar perfil |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | Guardar cambios |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | Eliminar cuenta |

### Rutas Premium (`premium.feature:<slug>`)

| Método | URI | Nombre | Controlador | Feature |
|--------|-----|--------|-------------|---------|
| GET | `/premium` | `premium.index` | `PremiumController@index` | — |
| GET | `/solar/descargar-pdf/{id}` | `solar.pdf` | `SolarController@descargarPDF` | `pdf_export` |
| POST | `/premium/compare` | `premium.compare` | `PremiumController@compare` | `result_compare` |
| GET | `/premium/export/csv` | `premium.export.csv` | `PremiumController@exportCsv` | `csv_export` |

### Administración (`auth`, `admin`)

| Método | URI | Nombre | Controlador | Descripción |
|--------|-----|--------|-------------|-------------|
| GET | `/admin/gestion` | `solar.admin` | `SolarController@adminIndex` | Auditoría de simulaciones |
| GET | `/admin/usuarios` | `admin.usuarios` | `UsuarioController@index` | Listado de usuarios |
| GET | `/admin/estadisticas` | `admin.estadisticas` | `SolarController@adminEstadisticas` | KPIs globales |
| GET | `/admin/exportar/csv` | `admin.exportar.csv` | `SolarController@exportarCSV` | Exportación masiva |
| POST | `/admin/usuario/{id}/rol` | `admin.cambiarRol` | `SolarController@cambiarRol` | Cambio de rol |
| POST | `/admin/resultado/{id}/estado` | `admin.cambiarEstado` | `SolarController@cambiarEstado` | Cambio de estado |
| POST | `/admin/usuario/{id}/premium` | `admin.premium.update` | `AdminSubscriptionController@update` | Asignar plan |
| POST | `/admin/usuario/{id}/premium/cancel` | `admin.premium.cancel` | `AdminSubscriptionController@cancel` | Cancelar plan |

---

## 10. Vistas y Frontend

### Tecnologías utilizadas

| Tecnología | Uso |
|-----------|-----|
| **Blade** | Motor de plantillas, control de acceso en UI |
| **Alpine.js** | Reactividad de formularios, modales, menús y gestión de temas |
| **Tailwind CSS v4** | Sistema de diseño responsivo (paleta Amber/Red/Slate) |
| **Chart.js** | Visualización de KPIs y curvas de producción |
| **MapLibre GL JS** | Mapa interactivo para selección de ubicación |
| **Fetch API** | Geocodificación con Nominatim (OpenStreetMap) |
| **Vite** | Compilación y hot-reload de assets |

---

### Layouts

**`layouts/app.blade.php`** — Layout base. Gestiona el modo oscuro (`darkMode`) con persistencia en `localStorage` vía Alpine.js. Define los stacks `@stack('styles')` y `@stack('js')` para recursos específicos de cada página. Usa `@vite` para cargar assets compilados.

**`layouts/navigation.blade.php`** — Barra de navegación responsiva. Variables Alpine: `open` (menú móvil), `atTop` (opacidad al hacer scroll). Muestra u oculta enlaces de admin y premium según el rol y plan del usuario.

---

### Vistas principales

**`solarcalc/calculadora.blade.php`**

Vista central para crear simulaciones. Alpine.js gestiona en tiempo real los campos `consumo`, `superficie`, `orientacion` e `inclinacion`, mostrando una estimación previa de ahorro y paneles antes de enviar el formulario. Integra un mapa MapLibre GL JS con geocodificación: el usuario escribe una dirección, se consulta Nominatim mediante `fetch`, y al colocar el marcador se actualizan los inputs ocultos de `latitud` y `longitud` que se enviarán con el formulario.

Variables Blade recibidas: `$plan` (datos de cuota y simulaciones restantes).

---

**`solarcalc/resultados.blade.php`**

Muestra el detalle técnico de una simulación guardada: gráfico de producción mensual con Chart.js, KPIs (potencia kWp, superficie, ROI) y botón de descarga PDF (visible solo si `$canDownloadPdf` es `true`).

Variables Blade recibidas: `$resultado` (modelo `Resultado`), `$canDownloadPdf` (booleano del servicio de suscripción).

---

**`solarcalc/presupuestos.blade.php`**

Historial paginado de simulaciones del usuario. Vista dual: cards en móvil, tabla en escritorio. Incluye filtros de búsqueda y ordenación. Contiene el formulario del **comparador premium** (un `<select multiple>` que recoge IDs y los envía a `POST /premium/compare`). Muestra banners informativos con simulaciones restantes según el plan.

Variables Blade recibidas: `$presupuestos` (paginado), `$currentPlan`, `$remainingSimulations`.

---

**`solarcalc/estadisticas.blade.php`**

Dashboard de métricas solares. Dos gráficos Chart.js: curva de producción mensual (línea con gradiente, compatible con modo oscuro) e histograma de actividad de los últimos 30 días. Se renderiza solo si el usuario tiene la feature `FEATURE_ADVANCED_STATS`; en caso contrario se muestra `estadisticas-teaser.blade.php`.

Variables Blade recibidas: `$datosGrafico`, `$presupuestosPorDia`.

---

**`solarcalc/admin.blade.php`**

Panel de gestión operativa para administradores. Lista global de simulaciones con filtros de estado y cambio de estado inline. Incluye modales Alpine.js (con `x-teleport`) para promover/degradar usuarios y asignar planes premium manualmente.

Variables Blade recibidas: `$todosLosPresupuestos`, `$usuarios`, `$subscriptionPlans`.

---

**`solarcalc/premium.blade.php`**

Landing de suscripción y herramientas avanzadas. Muestra las tarjetas de planes con precios formateados. Activa el comparador de resultados si `$isPremiumActive` es `true`. Muestra bloqueos visuales con razones dinámicas para guiar al usuario hacia la conversión.

---

**`solarcalc/pdf.blade.php`**

Plantilla de informe técnico en PDF. Usa CSS inline optimizado para DomPDF. Estructura: cabecera corporativa con ID único de proyecto, tabla de geoposicionamiento, tabla de dimensionamiento técnico (paneles, potencia, producción), análisis financiero (coste, ahorro, ROI) y nota de certificación de datos PVGIS v5.2.

---

**`profile/edit.blade.php`**

Formulario unificado para editar nombre, email y avatar. Muestra el historial de simulaciones del usuario y su ahorro medio histórico.

---

*Documentación generada el 26 de febrero de 2026.*