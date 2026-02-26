# Modelos y Base de Datos

Esta documentación detalla la estructura de la base de datos y los modelos Eloquent de la Calculadora Solar, basándose exclusivamente en el análisis del código fuente y las migraciones.

---

## 1. Modelos Eloquent

### 1.1 Model: `User`
*   **Tabla:** `usuarios`
*   **Clave Primaria:** `id_usuario`
*   **Atributos:**
    *   `id_usuario` (int): Identificador único autoincremental.
    *   `nombre` (string, 100): Nombre real del usuario.
    *   `email` (string, 100): Correo electrónico (único).
    *   `avatar` (string, nullable): Ruta de la imagen de perfil.
    *   `rol` (tinyint): `1` para Admin/Editor, `0` para Usuario estándar.
    *   `contrasena_hash` (string, 255): Hash de la contraseña.
    *   `email_verified_at` (timestamp, nullable): Fecha de verificación del email.
    *   `remember_token` (string, 100): Token de sesión recordada.
    *   `created_at`, `updated_at` (timestamps): Fechas de creación y actualización.
*   **Casting:**
    *   `email_verified_at` => `datetime`
    *   `contrasena_hash` => `hashed`
    *   `rol` => `integer`
*   **Appends:** Ninguno (usa métodos como `getEsAdminAttribute` pero no están en `$appends`).
*   **Scopes:** Ninguno definido explícitamente como método `scope...`.
*   **Relaciones:**
    ```php
    // Resultados asociados al usuario
    public function resultados(): HasMany {
        return $this->hasMany(Resultado::class, 'usuario_fr', 'id_usuario');
    }

    // Suscripciones del usuario
    public function subscriptions(): HasMany {
        return $this->hasMany(UserSubscription::class, 'usuario_fr', 'id_usuario');
    }

    // Suscripción activa actual
    public function activeSubscription(): HasOne {
        return $this->hasOne(UserSubscription::class, 'usuario_fr', 'id_usuario')->where('status', 'active')->...;
    }
    ```

### 1.2 Model: `Resultado`
*   **Tabla:** `resultados`
*   **Clave Primaria:** `id_resultado`
*   **Atributos:**
    *   `id_resultado` (int): Identificador único.
    *   `ubicacion` (string, 100): Ubicación de la instalación.
    *   `latitud`, `longitud` (decimal 10,8 / 11,8): Coordenadas geográficas.
    *   `consumo_anual` (int): Consumo anual en kWh.
    *   `superficie_disponible` (decimal 10,2): M2 disponibles.
    *   `orientacion` (int): Ángulo de orientación (default 0).
    *   `inclinacion` (int): Ángulo de inclinación (default 30).
    *   `ahorro_estimado_eur` (decimal 10,2): Ahorro anual calculado.
    *   `paneles_sugeridos` (int): Cantidad de paneles.
    *   `potencia_instalacion_kwp` (float): Potencia pico.
    *   `produccion_anual_kwh` (float): Producción estimada.
    *   `roi_anyos` (decimal 5,2): Retorno de inversión en años.
    *   `radiacion_a_medida` (int): Datos de radiación específicos.
    *   `fuerza` (int): Parámetro técnico de cálculo.
    *   `estado` (string): 'pendiente', 'verificado', 'rechazado' (default 'pendiente').
    *   `usuario_fr` (bigint, unsigned): FK a `usuarios.id_usuario`.
    *   `estadistica_fr` (bigint, unsigned): FK a `estadisticas.id_estadistica`.
    *   `created_at`, `updated_at` (timestamps).
*   **Casting:**
    *   `ahorro_estimado_eur` => `float`
    *   `consumo_anual` => `float`
    *   `produccion_anual_kwh` => `float`
    *   `potencia_instalacion_kwp` => `float`
    *   `roi_anyos` => `float`
    *   `paneles_sugeridos` => `integer`
    *   `latitud`, `longitud` => `decimal:8`
    *   `created_at` => `datetime`
*   **Scopes:**
    ```php
    public function scopeAltoAhorro($query) {
        return $query->where('ahorro_estimado_eur', '>', 1000);
    }
    ```
*   **Relaciones:**
    ```php
    public function usuario(): BelongsTo {
        return $this->belongsTo(User::class, 'usuario_fr', 'id_usuario');
    }
    ```

### 1.3 Model: `SubscriptionPlan`
*   **Tabla:** `subscription_plans`
*   **Clave Primaria:** `id` (default autoincrement)
*   **Atributos:**
    *   `id` (bigint): Identificador único.
    *   `code` (string, 60): Código único (free, premium_monthly, etc).
    *   `name` (string, 120): Nombre comercial.
    *   `price_cents` (unsigned int): Precio en céntimos.
    *   `currency` (string, 3): 'EUR' por defecto.
    *   `interval` (string, 20): 'none', 'month', 'year'.
    *   `simulation_limit` (unsigned int, nullable).
    *   `features` (json, nullable): Características activas.
    *   `is_active` (boolean, default true).
    *   `created_at`, `updated_at` (timestamps).
*   **Casting:**
    *   `price_cents` => `integer`
    *   `simulation_limit` => `integer`
    *   `features` => `array`
    *   `is_active` => `boolean`
*   **Relaciones:**
    ```php
    public function subscriptions(): HasMany {
        return $this->hasMany(UserSubscription::class, 'plan_fr', 'id');
    }
    ```

### 1.4 Model: `UserSubscription`
*   **Tabla:** `user_subscriptions`
*   **Clave Primaria:** `id` (default autoincrement)
*   **Atributos:**
    *   `id` (bigint): Identificador único.
    *   `usuario_fr` (bigint): FK a `usuarios.id_usuario`.
    *   `plan_fr` (bigint): FK a `subscription_plans.id`.
    *   `status` (string, 20): 'active', 'expired', 'cancelled'.
    *   `starts_at` (timestamp, nullable): Inicio de vigencia.
    *   `ends_at` (timestamp, nullable): Fin de vigencia.
    *   `activated_by_fr` (bigint, nullable): FK a `usuarios.id_usuario` (admin que activó).
    *   `source` (string, 40): Origen (default 'manual_admin').
    *   `notes` (text, nullable).
    *   `created_at`, `updated_at` (timestamps).
*   **Casting:**
    *   `starts_at`, `ends_at` => `datetime`
*   **Relaciones:**
    ```php
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'usuario_fr', 'id_usuario');
    }

    public function plan(): BelongsTo {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_fr', 'id');
    }

    public function activatedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'activated_by_fr', 'id_usuario');
    }
    ```

---

## 2. Tablas de Base de Datos

### Tabla: `usuarios`
| Columna | Tipo | Null | Default | Índices |
| :--- | :--- | :--- | :--- | :--- |
| `id_usuario` | bigint (unsigned) | No | AUTO_INCREMENT | PRIMARY |
| `nombre` | varchar(100) | No | | |
| `email` | varchar(100) | No | | UNIQUE |
| `avatar` | varchar(255) | Sí | NULL | |
| `email_verified_at`| timestamp | Sí | NULL | |
| `rol` | tinyint | No | 0 | |
| `contrasena_hash` | varchar(255) | No | | |
| `remember_token` | varchar(100) | Sí | NULL | |
| `created_at` | timestamp | Sí | NULL | |
| `updated_at` | timestamp | Sí | NULL | |

### Tabla: `resultados`
| Columna | Tipo | Null | Default | Índices |
| :--- | :--- | :--- | :--- | :--- |
| `id_resultado` | bigint (unsigned) | No | AUTO_INCREMENT | PRIMARY |
| `ubicacion` | varchar(100) | Sí | NULL | |
| `latitud` | decimal(10,8) | Sí | NULL | |
| `longitud` | decimal(11,8) | Sí | NULL | |
| `consumo_anual` | int | Sí | NULL | |
| `superficie_disponible`| decimal(10,2)| Sí | NULL | |
| `orientacion` | int | No | 0 | |
| `inclinacion` | int | No | 30 | |
| `ahorro_estimado_eur` | decimal(10,2)| Sí | NULL | |
| `paneles_sugeridos` | int | Sí | NULL | |
| `potencia_instalacion_kwp`| float | Sí | NULL | |
| `produccion_anual_kwh` | float | Sí | NULL | |
| `roi_anyos` | decimal(5,2) | Sí | NULL | |
| `radiacion_a_medida`| int | Sí | NULL | |
| `fuerza` | int | Sí | NULL | |
| `estado` | varchar(255) | No | 'pendiente' | |
| `usuario_fr` | bigint (unsigned) | Sí | NULL | FK (usuarios) |
| `estadistica_fr` | bigint (unsigned) | Sí | NULL | FK (estadisticas)|
| `created_at` | timestamp | Sí | NULL | |
| `updated_at` | timestamp | Sí | NULL | |

### Tabla: `subscription_plans`
| Columna | Tipo | Null | Default | Índices |
| :--- | :--- | :--- | :--- | :--- |
| `id` | bigint (unsigned) | No | AUTO_INCREMENT | PRIMARY |
| `code` | varchar(60) | No | | UNIQUE |
| `name` | varchar(120) | No | | |
| `price_cents` | int (unsigned) | No | 0 | |
| `currency` | varchar(3) | No | 'EUR' | |
| `interval` | varchar(20) | No | 'none' | Index |
| `simulation_limit` | int (unsigned) | Sí | NULL | |
| `features` | json | Sí | NULL | |
| `is_active` | tinyint(1) | No | 1 | Index |
| `created_at` | timestamp | Sí | NULL | |
| `updated_at` | timestamp | Sí | NULL | |

### Tabla: `user_subscriptions`
| Columna | Tipo | Null | Default | Índices |
| :--- | :--- | :--- | :--- | :--- |
| `id` | bigint (unsigned) | No | AUTO_INCREMENT | PRIMARY |
| `usuario_fr` | bigint (unsigned) | No | | FK, Index |
| `plan_fr` | bigint (unsigned) | No | | FK |
| `status` | varchar(20) | No | 'active' | Index |
| `starts_at` | timestamp | Sí | NULL | Index |
| `ends_at` | timestamp | Sí | NULL | Index |
| `activated_by_fr` | bigint (unsigned) | Sí | NULL | FK |
| `source` | varchar(40) | No | 'manual_admin' | |
| `notes` | text | Sí | NULL | |
| `created_at` | timestamp | Sí | NULL | |
| `updated_at` | timestamp | Sí | NULL | |

---

## 3. Diagrama de Relaciones (ASCII)

```text
    +-----------+              +---------------------+
    |  usuarios | <----------+ |  user_subscriptions |
    +-----------+ (usuario_fr) +---------------------+
    | id_usuario|              | id (PK)             |
    | nombre    | <----------+ | usuario_fr (FK)     |
    | email     | (activ._by)  | plan_fr (FK)        |
    +-----------+              | status              |
          ^                    +---------------------+
          |                               |
          | (usuario_fr)                  | (plan_fr)
          |                               v
    +-----------+              +---------------------+
    | resultados|              | subscription_plans  |
    +-----------+              +---------------------+
    |id_resultado|             | id (PK)             |
    |usuario_fr (FK)           | code (Unique)       |
    |estad.(FK) |              | name, price...      |
    +-----------+              +---------------------+
          |
          v
    +---------------+
    | estadisticas  |
    +---------------+
    | id_estadistica|
    +---------------+
```

---

## Notas Adicionales
*   No se encontraron Scopes o Appends en los modelos `User`, `SubscriptionPlan` o `UserSubscription`.
*   El modelo `Resultado` implementa un scope (`altoAhorro`) y un accesor (`ahorro_formateado`).
*   Los tipos de datos exactos (precisiones decimales) se han extraído de los archivos de migración.
