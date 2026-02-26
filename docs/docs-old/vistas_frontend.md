# Análisis de Vistas y Frontend - SolarCalc

Este documento detalla la estructura de la interfaz de usuario, los componentes reactivos y la lógica de frontend de la aplicación Calculadora Solar.

## 1. Estructura de Layouts y Navegación

### [app.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/layouts/app.blade.php)
Layout base principal que utiliza **Alpine.js** para la gestión del estado global.
- **Funcionalidades**:
    - **Gestión de Temas**: Implementa un interruptor de modo oscuro (`darkMode`) que persiste en `localStorage`.
    - **Inyección de Assets**: Utiliza `@vite` para cargar CSS y JS compilados.
    - **Stacks**: Define `@stack('styles')` y `@stack('js')` para inyectar recursos específicos por página (usado en estadísticas y calculadora).
- **Variables**: Recibe `$header` para el título de la sección y `$slot` para el contenido.

### [navigation.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/layouts/navigation.blade.php)
Barra de navegación responsiva con Alpine.js.
- **Lógica Frontend**:
    - `open`: Booleano para el menú móvil.
    - `atTop`: Booleano para cambiar la opacidad de la barra al hacer scroll.
- **Contenido**:
    - Enlaces dinámicos basados en autenticación y roles (`admin`, `premium`).
    - Menú desplegable para el perfil del usuario utilizando el componente `<x-dropdown>`.
    - Interruptor de modo oscuro integrado.

---

## 2. Vistas Principales (Core Solar)

### [calculadora.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/calculadora.blade.php)
Componente central para la creación de simulaciones.
- **Alpine.js (`x-data`)**:
    - Gestiona el estado del formulario: `consumo`, `superficie`, `orientacion`, `inclinacion`.
    - Cálculos en tiempo real: Determina `ahorroEstimado` y `panelesSugeridos` conforme el usuario ajusta los deslizadores.
- **Integración de Mapas (MapLibre GL JS)**:
    - Inicializa un mapa interactivo para seleccionar la ubicación.
    - **Búsqueda (Geocoding)**: Utiliza `fetch` hacia el endpoint de **Nominatim (OpenStreetMap)** para convertir direcciones en coordenadas.
    - Al mover el marcador, actualiza los inputs ocultos de `latitud` y `longitud`.
- **Variables Blade**:
    - `$plan`: Información del plan actual para mostrar límites de cuota (simulaciones restantes).

### [resultados.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/resultados.blade.php)
Visualización técnica de una simulación guardada.
- **Contenido**:
    - Gráfico resumen de producción (vía Chart.js).
    - Desglose de KPIs: Potencia (kWp), Superficie necesaria, Retorno de inversión (ROI).
    - Botón de descarga PDF (supeditado a permisos Premium).
- **Variables Blade**:
    - `$resultado`: Instancia del modelo `Resultado` con todos los parámetros técnicos.
    - `$canDownloadPdf`: Booleano calculado en el servicio de suscripción.

### [presupuestos.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/presupuestos.blade.php)
Dashboard histórico del usuario.
- **Funcionalidades**:
    - Fitros de búsqueda por ubicación y ordenación.
    - Lista paginada con vista dual (Cards en móvil, Tabla en desktop).
    - **Comparador Premium**: Formulario con un `<select multiple>` de Alpine/HTML para elegir simulaciones y compararlas.
- **Variables Blade**:
    - `$presupuestos`: Colección paginada de simulaciones del usuario.
    - `$currentPlan`, `$remainingSimulations`: Datos de suscripción para banners informativos.

---

## 3. Administración y Estadísticas

### [admin.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/admin.blade.php)
Panel de gestión operativa.
- **Auditoría de Simulaciones**: Lista global con filtros por estado (pendiente, aprobado, rechazado) y cambio de estado vía formulario inline.
- **Gestión de Usuarios**:
    - **Alpine.js**: Modales de confirmación para promover/degradar editores o activar planes Premium manualmente.
    - Usa `x-teleport` para inyectar los modales al final del `body`.
- **Variables Blade**:
    - `$todosLosPresupuestos`: Simulaciones de todos los usuarios.
    - `$usuarios`: Listado de cuentas registradas.
    - `$subscriptionPlans`: Catálogo de planes para el modal de asignación manual.

### [estadisticas.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/estadisticas.blade.php)
Dashboard público de métricas solares para Algemesí.
- **Frontend (Chart.js)**:
    - **Gráfico de Producción**: Línea de tiempo mensual con gradientes, adaptada a modo oscuro.
    - **Gráfico de Actividad**: Histograma de simulaciones realizadas en los últimos 30 días.
- **Variables Blade**:
    - `$datosGrafico`: Array de valores mensuales.
    - `$presupuestosPorDia`: Datos agrupados para el histograma de actividad.

---

## 4. Componentes Transversales y Exportación

### [pdf.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/pdf.blade.php)
Plantilla para la generación de informes técnicos.
- **Diseño**: Utiliza CSS "inline" optimizado para motores de renderizado PDF como Dompdf o Browsershot.
- **Estructura**:
    - Cabecera corporativa con ID de proyecto único.
    - Secciones tabulares de geoposicionamiento, dimensionamiento técnico y análisis financiero.
    - Nota técnica sobre certificación de datos (PVGIS v5.2).

### [premium.blade.php](file:///home/ayob/Escritorio/CalculadoraSolar/resources/views/solarcalc/premium.blade.php)
Landing de suscripción y herramientas avanzadas.
- **Componentes**:
    - Comparador de resultados (activable si `isPremiumActive` es true).
    - Tarjetas de planes con cálculo de precios (formateados vía PHP closure).
    - Bloqueo visual de funciones con razones dinámicas (`simulation_quota`, `pdf_export`, etc.).

---

## 5. Resumen de Tecnologías Frontend

| Tecnología | Uso en la Aplicación |
| :--- | :--- |
| **Alpine.js** | Reactividad de formularios, modales, menús y gestión de temas. |
| **Tailwind CSS** | Styling responsivo y sistema de diseño unitario (Amber/Red/Slate). |
| **Chart.js** | Visualización de datos técnicos y KPIs de rendimiento. |
| **MapLibre GL** | Mapa interactivo en la calculadora solar. |
| **Fetch API** | Geocodificación con Nominatim y búsqueda de direcciones. |
| **Blade** | Motor de plantillas para la composición de vistas y control de acceso UI. |
