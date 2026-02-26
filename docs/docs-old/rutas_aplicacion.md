# Documentación de Rutas - SolarCalc

Este documento detalla todos los endpoints de la aplicación, organizados por su contexto de acceso, incluyendo métodos, controladores, middlewares y propósitos.

## 1. Rutas Públicas
Acceso permitido a cualquier visitante sin necesidad de autenticación.

| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `/` | `home` | Clausura (Vista) | - | Página de aterrizaje principal. |

---

## 2. Rutas de Autenticación (Guest)
Rutas para la gestión de acceso, limitadas a usuarios **no autenticados** (`guest`).

| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `register` | `register` | `RegisteredUserController@create` | `guest` | Formulario de registro. |
| POST | `register` | - | `RegisteredUserController@store` | `guest` | Procesa el registro de usuario. |
| GET | `login` | `login` | `AuthenticatedSessionController@create` | `guest` | Formulario de inicio de sesión. |
| POST | `login` | - | `AuthenticatedSessionController@store` | `guest` | Procesa el inicio de sesión. |
| GET | `forgot-password` | `password.request` | `PasswordResetLinkController@create` | `guest` | Formulario de recuperación de clave. |
| POST | `forgot-password` | `password.email` | `PasswordResetLinkController@store` | `guest` | Envía enlace de recuperación. |
| GET | `reset-password/{token}` | `password.reset` | `NewPasswordController@create` | `guest` | Formulario de nueva contraseña. |
| POST | `reset-password` | `password.store` | `NewPasswordController@store` | `guest` | Guarda la nueva contraseña. |

---

## 3. Rutas de Usuario Autenticado
Rutas protegidas que requieren inicio de sesión y verificación de email (`auth`, `verified`).

| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `/dashboard` | `dashboard` | `SolarController@dashboard` | `auth, verified` | Panel principal del usuario. |
| GET | `/calculadora` | `solar.calculadora` | `SolarController@calculadora` | `auth, verified` | Interfaz de la calculadora solar. |
| POST | `/calculadora/procesar`| `solar.procesar` | `SolarController@procesar` | `auth, verified, simulation.quota` | Procesa y guarda la simulación. |
| GET | `/resultados/{id}` | `solar.resultados` | `SolarController@mostrarResultado` | `auth, verified` | Detalle técnico de un presupuesto. |
| GET | `/presupuestos` | `solar.presupuestos` | `SolarController@presupuestos` | `auth, verified` | Historial de simulaciones. |
| GET | `/estadisticas` | `solar.estadisticas` | `SolarController@estadisticas` | `auth, verified` | Gráficos y métricas de energía. |
| POST | `logout` | `logout` | `AuthenticatedSessionController@destroy`| `auth` | Cierra la sesión activa. |

### Gestión de Perfil
| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | `auth` | Formulario de edición de perfil. |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | `auth` | Actualiza datos y avatar. |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | `auth` | Elimina la cuenta del usuario. |

---

## 4. Rutas Premium
Rutas que requieren un plan activo (`premium.feature`).

| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `/premium` | `premium.index` | `PremiumController@index` | `auth, verified` | Landing de planes y comparador. |
| GET | `/solar/descargar-pdf/{id}`| `solar.pdf` | `SolarController@descargarPDF` | `premium.feature:pdf_export` | Generación de informe técnico. |
| POST | `/premium/compare` | `premium.compare` | `PremiumController@compare` | `premium.feature:result_compare` | Compara múltiples resultados. |
| GET | `/premium/export/csv` | `premium.export.csv` | `PremiumController@exportCsv` | `premium.feature:csv_export` | Exporta histórico personal. |

---

## 5. Rutas de Administración
Acceso restringido a usuarios con rol de administrador (`admin`).

| Método | URI | Nombre | Acción | Middlewares | Descripción |
| :--- | :--- | :--- | :--- | :--- | :--- |
| GET | `admin/gestion` | `solar.admin` | `SolarController@adminIndex` | `auth, admin` | Auditoría de simulaciones. |
| GET | `admin/usuarios` | `admin.usuarios` | `UsuarioController@index` | `auth, admin` | Listado global de usuarios. |
| GET | `admin/estadisticas` | `admin.estadisticas` | `SolarController@adminEstadisticas` | `auth, admin` | Métricas globales del sistema. |
| GET | `admin/exportar/csv` | `admin.exportar.csv` | `SolarController@exportarCSV` | `auth, admin` | Exportación masiva de datos. |
| POST | `admin/usuario/{id}/rol` | `admin.cambiarRol` | `SolarController@cambiarRol` | `auth, admin` | Cambia entre Usuario/Admin. |
| POST | `admin/resultado/{id}/estado`| `admin.cambiarEstado` | `SolarController@cambiarEstado` | `auth, admin` | Aprueba o deniega simulaciones. |
| POST | `admin/usuario/{id}/premium`| `admin.premium.update` | `AdminSubscriptionController@update` | `auth, admin` | Asigna planes manualmente. |
| POST | `admin/usuario/{id}/premium/cancel`| `admin.premium.cancel` | `AdminSubscriptionController@cancel` | `auth, admin` | Cancela suscripciones activas. |
