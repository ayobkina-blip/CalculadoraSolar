# Memoria del Proyecto: Calculadora Solar (SolarCalc)

---

## 1. Resumen Ejecutivo
SolarCalc es una aplicación web que estima en menos de un minuto la viabilidad fotovoltaica de cualquier vivienda introduciendo su ubicación en el mapa. Consulta la API europea PVGIS para obtener radiación exacta del punto seleccionado, calcula potencia óptima, producción anual, ahorro estimado y ROI sin pedir datos de contacto, y permite descargar un informe PDF. Incluye paneles diferenciados para usuarios y administradores.

## 2. Objetivos y Alcance
- Ofrecer un estudio preliminar gratuito y anónimo de autoconsumo.
- Gestionar roles: usuario y administrador (rol = 1) con vistas protegidas.
- Cobertura geográfica amplia: cualquier punto geolocalizado (España y otros países soportados por PVGIS), sin limitarse a Algemesí.

## 3. Stakeholders
- Propietarios de viviendas unifamiliares en distintas regiones.
- Comunidades de vecinos.
- Instaladores locales o regionales que generan propuestas rápidas con datos reales de radiación.
- Equipo interno de operaciones y soporte.

## 4. Requerimientos Funcionales
- Autenticación y verificación de email (`auth`, `verified`).
- Flujo de cálculo solar: vista `/calculadora` → POST `/calculadora/procesar`.
- Almacenado y visualización de simulaciones (`/resultados/{id}`).
- Dashboard personal con KPIs y curvas mensuales (`SolarController@dashboard`).
- Estadísticas globales y exportación CSV para admins (`/admin/gestion`, `/admin/exportar/csv`).
- Generación de informe PDF por simulación (DomPDF).

## 5. Requerimientos No Funcionales
- Stack TALL: Laravel 12 / PHP 8.2, Blade, Tailwind, Alpine; MySQL.
- Integraciones: PVGIS (radiación), MapLibre + Nominatim (mapas).
- Rendimiento: consultas paginadas, scopes y casts Eloquent; evitar N+1.
- Seguridad: validación estricta, middleware `admin`, control de propiedad en descargas.

## 6. Arquitectura
Patrón MVC Laravel.
- Rutas (`routes/web.php`): públicas (`/`), protegidas (`/dashboard`, `/calculadora`, admin prefix).
- Controlador principal: `app/Http/Controllers/SolarController.php` gestiona cálculo, dashboards, CSV, PDF y roles.
- Modelo clave: `app/Models/Resultado.php` con `fillable`, `casts`, scope `altoAhorro` y relación `usuario`.

## 7. Modelado de Datos (simplificado)
- `users`: `id_usuario`, `nombre`, `email`, `rol`, ...
- `resultados`: `id_resultado`, `usuario_fr`, `ubicacion`, `latitud`, `longitud`, `consumo_anual`, `superficie_disponible`, `orientacion`, `inclinacion`, `paneles_sugeridos`, `potencia_instalacion_kwp`, `produccion_anual_kwh`, `ahorro_estimado_eur`, `roi_anyos`, `estado`.

## 8. Flujo Principal de Cálculo (skill: laravel-specialist)
1) Validación de entrada en español con límites de negocio.  
2) Llamada PVGIS con lat/long seleccionados en el mapa para obtener `E_y` específica del punto; fallback provincial si la API falla.  
3) Dimensionamiento: potencia requerida → paneles (450 Wp) limitados por superficie; producción anual y ahorro (€).  
4) Persistencia con `Resultado::create` (mass assignment protegido).  
5) Redirección a vista de resultados y opción de PDF.

## 9. Buenas Prácticas Eloquent Aplicadas (skill: eloquent-best-practices)
- Eager loading en panel admin (`Resultado::with('usuario')`).  
- `withCount` de resultados por usuario.  
- `fillable`/`casts` completos para tipos seguros.  
- Scope `altoAhorro` y accesor monetario.  
- Paginación consistente en dashboards.

## 10. Rendimiento y Calidad
- Se evita N+1 en listados críticos; recomendado añadir índices en `estado`, `created_at`, `usuario_fr`, `ubicacion`.
- Método auxiliar `calcularCurvaMensual` centraliza la distribución energética.
- CSV con streaming y BOM UTF-8 para compatibilidad Excel.

## 11. Seguridad
- Middleware `auth|verified` y `admin`; validación en cada acción sensible.
- Bloqueo de cambio de rol sobre uno mismo; control de ownership al descargar PDF.
- Entradas geográficas acotadas; sin credenciales en código.

## 12. UX/UI
- Diseño responsive “premium” con Tailwind, transiciones suaves y mapas táctiles.
- Dashboard con KPIs (ahorro total, kWh, CO₂ evitado, árboles equivalentes) y gráficos mensuales.

## 13. Pruebas y Observabilidad
- Infra de PHPUnit lista (`phpunit.xml`).  
- Pendiente: tests de cálculo (mock HTTP PVGIS), control de roles, CSV/PDF y vistas protegidas.

## 14. Despliegue y Operaciones
- Build frontend con Vite/Tailwind; PHP 8.2+; MySQL 8.  
- `.env` con DB, MAIL; PVGIS sin clave; tokens opcionales para MapLibre.  
- Colas opcionales (no configuradas) para tareas pesadas.

## 15. Roadmap Sugerido
1) Añadir suite de tests (Pest/PHPUnit) para cálculos y roles.  
2) Cachear respuestas PVGIS por coordenada para reducir latencia.  
3) Exponer endpoint API con Sanctum para apps móviles.  
4) Auditoría de accesibilidad (WCAG) y métricas Core Web Vitals.  
5) Índices DB y `withCount` adicionales en dashboards con >10k registros.

## 16. Conclusión
SolarCalc ofrece una solución lista para producción que acerca la ingeniería fotovoltaica al usuario final, con bases sólidas en Laravel, buenas prácticas Eloquent y una experiencia móvil cuidada. Quedan como siguientes pasos las pruebas automatizadas y optimizaciones de rendimiento a gran escala.
