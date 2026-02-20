{{-- Mejoras: diseño unificado, buscador/mapa robusto con vanilla JS, accesibilidad, persistencia old(), responsive. --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Calculadora Fotovoltaica
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Introduce tu ubicación y parámetros para calcular tu instalación solar</p>
            </div>
        </div>
    </x-slot>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-300 mb-1.5">Corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('solar.procesar') }}" method="POST"
          x-data="{ consumo: {{ old('consumo', 350) }}, superficie: {{ old('superficie', 40) }} }">
        @csrf

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">

            {{-- ══════════════════════════════════════
                 COLUMNA IZQUIERDA — Mapa
            ══════════════════════════════════════ --}}
            <div class="flex-1 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col min-h-[520px] lg:min-h-[680px]">

                {{-- Cabecera del panel mapa --}}
                <div class="px-4 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between gap-3 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">1. Geoposicionamiento</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Busca tu dirección o haz clic en el mapa</p>
                        </div>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold uppercase tracking-wide border border-amber-200 dark:border-amber-800/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        WebGL activo
                    </span>
                </div>

                {{-- Buscador — gestionado 100% por vanilla JS, sin Alpine --}}
                <div class="px-4 sm:px-6 py-4 flex-shrink-0">
                    <label for="buscador-direccion" class="sr-only">Buscar dirección</label>
                    <div class="relative" id="search-wrapper">
                        <div class="relative">
                            <input
                                type="text"
                                id="buscador-direccion"
                                autocomplete="off"
                                placeholder="Busca tu ciudad o dirección en España..."
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-2.5 pl-11 pr-10 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                            >
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            {{-- Spinner de carga --}}
                            <svg id="search-spinner" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </div>

                        {{-- Dropdown de resultados (gestionado por JS) --}}
                        <div
                            id="search-dropdown"
                            class="hidden absolute z-[9999] w-full mt-1.5 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden"
                            role="listbox"
                            aria-label="Sugerencias de dirección"
                        ></div>
                    </div>
                    <p id="search-feedback" class="mt-2 text-xs text-gray-500 dark:text-gray-400 min-h-[1rem]" aria-live="polite"></p>

                    {{-- Indicador de coordenadas activas --}}
                    <div id="coords-indicator" class="hidden mt-2 items-center gap-2 text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="coords-text">Ubicación seleccionada</span>
                    </div>
                </div>

                {{-- Contenedor del mapa --}}
                <div class="relative flex-grow mx-4 sm:mx-6 mb-4 sm:mb-6 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 min-h-[300px]">
                    <div id="main-map" class="absolute inset-0 w-full h-full"></div>
                    {{-- Tooltip hint --}}
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 pointer-events-none">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-900/70 backdrop-blur-sm text-white text-[10px] font-medium whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
                            </svg>
                            Clic o arrastra el marcador para ajustar
                        </div>
                    </div>
                </div>

                {{-- Hidden inputs de coordenadas --}}
                <input type="hidden" name="latitud"   id="latitud"   value="{{ old('latitud',   '39.1867') }}">
                <input type="hidden" name="longitud"  id="longitud"  value="{{ old('longitud',  '-0.4367') }}">
                <input type="hidden" name="provincia" id="provincia" value="{{ old('provincia', 'valencia') }}">
            </div>

            {{-- ══════════════════════════════════════
                 COLUMNA DERECHA — Parámetros
            ══════════════════════════════════════ --}}
            <div class="w-full lg:w-[400px] xl:w-[420px] bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">2. Parámetros técnicos</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Configura tu instalación solar</p>
                        </div>
                    </div>
                </div>

                <div class="flex-grow px-4 sm:px-6 py-5 space-y-6">

                    {{-- Consumo mensual --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-consumo" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Consumo mensual
                            </label>
                            <span class="text-sm font-bold text-amber-500" x-text="consumo + ' kWh'"></span>
                        </div>
                        <input
                            type="number" name="consumo" id="input-consumo"
                            x-model="consumo" min="50" max="10000"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                        >
                        <input
                            type="range" x-model="consumo" min="50" max="2500" step="10"
                            aria-label="Consumo mensual en kWh"
                            class="w-full mt-3 h-2 rounded-lg cursor-pointer accent-amber-500 bg-gray-100 dark:bg-gray-700"
                        >
                        <div class="flex justify-between text-[10px] text-gray-400 dark:text-gray-500 mt-1 font-medium">
                            <span>50 kWh</span><span>2.500 kWh</span>
                        </div>
                    </div>

                    {{-- Superficie disponible --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-superficie" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Superficie disponible
                            </label>
                            <span class="text-sm font-bold text-amber-500" x-text="superficie + ' m²'"></span>
                        </div>
                        <input
                            type="number" name="superficie" id="input-superficie"
                            x-model="superficie" min="10" max="10000"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                        >
                        <input
                            type="range" x-model="superficie" min="10" max="1000" step="5"
                            aria-label="Superficie disponible en metros cuadrados"
                            class="w-full mt-3 h-2 rounded-lg cursor-pointer accent-amber-500 bg-gray-100 dark:bg-gray-700"
                        >
                        <div class="flex justify-between text-[10px] text-gray-400 dark:text-gray-500 mt-1 font-medium">
                            <span>10 m²</span><span>1.000 m²</span>
                        </div>
                    </div>

                    {{-- Orientación --}}
                    <div>
                        <label for="input-orientacion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Orientación del tejado
                        </label>
                        <select
                            name="orientacion" id="input-orientacion"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition cursor-pointer"
                        >
                            <option value="0"   {{ (string) old('orientacion', 0) === '0'   ? 'selected' : '' }}>⭐ Sur (Óptimo)</option>
                            <option value="-45" {{ (string) old('orientacion') === '-45'     ? 'selected' : '' }}>Sureste</option>
                            <option value="45"  {{ (string) old('orientacion') === '45'      ? 'selected' : '' }}>Suroeste</option>
                            <option value="-90" {{ (string) old('orientacion') === '-90'     ? 'selected' : '' }}>Este</option>
                            <option value="90"  {{ (string) old('orientacion') === '90'      ? 'selected' : '' }}>Oeste</option>
                        </select>
                    </div>

                    {{-- Inclinación --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-inclinacion" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Inclinación del tejado
                            </label>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Recomendado: 30°–35°</span>
                        </div>
                        <input
                            type="number" name="inclinacion" id="input-inclinacion"
                            value="{{ old('inclinacion', 30) }}" min="0" max="90"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                        >
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Rango válido: 0° (plano) – 90° (vertical)</p>
                    </div>

                </div>

                {{-- Botón submit --}}
                <div class="px-4 sm:px-6 pb-5 flex-shrink-0">
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2.5 py-3.5 px-6 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-sm sm:text-base hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Iniciar Simulación
                        </button>
                        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-2.5">
                            Resultados calculados con datos reales de PVGIS
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </form>

    @push('styles')
        <link href="https://unpkg.com/maplibre-gl@4.1.3/dist/maplibre-gl.css" rel="stylesheet">
        <style>
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
            input[type=number] { -moz-appearance: textfield; }

            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 18px; width: 18px; border-radius: 50%;
                background: #f59e0b; border: 3px solid #fff;
                cursor: pointer; box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            }
            input[type=range]::-moz-range-thumb {
                height: 18px; width: 18px; border-radius: 50%;
                background: #f59e0b; border: 3px solid #fff; cursor: pointer;
            }

            .maplibregl-canvas { outline: none !important; }
            .maplibregl-ctrl-bottom-left { display: none !important; }
        </style>
    @endpush

    @push('js')
        <script src="https://unpkg.com/maplibre-gl@4.1.3/dist/maplibre-gl.js"></script>
        <script>
        // ══════════════════════════════════════════════════════════════
        // CALCULADORA — Lógica robusta de mapa y búsqueda (vanilla JS)
        // Objetivo: que el buscador responda siempre aunque falle el
        // mapa o el servicio externo.
        // ══════════════════════════════════════════════════════════════
        (function () {

            function init() {
                // ── Elementos del DOM ─────────────────────────────────
                const latInput    = document.getElementById('latitud');
                const lngInput    = document.getElementById('longitud');
                const provInput   = document.getElementById('provincia');
                const searchInput = document.getElementById('buscador-direccion');
                const dropdown    = document.getElementById('search-dropdown');
                const spinner     = document.getElementById('search-spinner');
                const coordsBox   = document.getElementById('coords-indicator');
                const coordsText  = document.getElementById('coords-text');
                const feedback    = document.getElementById('search-feedback');

                if (!latInput || !searchInput || !dropdown) return;

                // ── Coordenadas iniciales (respetan old() de Blade) ───
                const initLat = parseFloat(latInput.value)  || 39.1867;
                const initLon = parseFloat(lngInput.value)  || -0.4367;

                // ── Mapa MapLibre (defensivo) ─────────────────────────
                let map = null;
                let marker = null;
                try {
                    if (typeof maplibregl !== 'undefined') {
                        map = new maplibregl.Map({
                            container: 'main-map',
                            style: {
                                version: 8,
                                sources: {
                                    carto: {
                                        type: 'raster',
                                        tiles: ['https://a.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'],
                                        tileSize: 256,
                                        attribution: '© CartoDB'
                                    }
                                },
                                layers: [{ id: 'carto-layer', type: 'raster', source: 'carto' }]
                            },
                            center: [initLon, initLat],
                            zoom: 13,
                            trackResize: true
                        });

                        marker = new maplibregl.Marker({ draggable: true, color: '#f59e0b' })
                            .setLngLat([initLon, initLat])
                            .addTo(map);
                    } else {
                        console.warn('[SolarCalc] MapLibre no disponible.');
                    }
                } catch (err) {
                    console.warn('[SolarCalc] Error inicializando mapa:', err.message);
                    map = null;
                    marker = null;
                }

                // ── Helpers ───────────────────────────────────────────
                function updateCoords(lng, lat) {
                    if (!Number.isFinite(lng) || !Number.isFinite(lat)) return;
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    if (coordsBox && coordsText) {
                        coordsText.textContent = lat.toFixed(4) + '°N  ·  ' + Math.abs(lng).toFixed(4) + '°O';
                        coordsBox.classList.remove('hidden');
                        coordsBox.classList.add('flex');
                    }
                }

                function setFeedback(message, error) {
                    if (!feedback) return;
                    feedback.textContent = message || '';
                    feedback.classList.toggle('text-red-500', !!error);
                    feedback.classList.toggle('dark:text-red-400', !!error);
                    feedback.classList.toggle('text-gray-500', !error);
                    feedback.classList.toggle('dark:text-gray-400', !error);
                }

                function setSpinner(on) {
                    if (spinner) spinner.classList.toggle('hidden', !on);
                }

                function escHtml(str) {
                    const d = document.createElement('div');
                    d.appendChild(document.createTextNode(str));
                    return d.innerHTML;
                }

                function showDropdown(results) {
                    dropdown.innerHTML = '';
                    if (!results || results.length === 0) {
                        const empty = document.createElement('div');
                        empty.className = 'px-4 py-3 text-sm text-gray-500 dark:text-gray-400';
                        empty.textContent = 'No se encontraron resultados para esa búsqueda.';
                        dropdown.appendChild(empty);
                        dropdown.classList.remove('hidden');
                        setFeedback('Sin coincidencias, prueba con otra dirección.');
                        return;
                    }

                    results.forEach(function (res) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 '
                            + 'hover:bg-amber-50 dark:hover:bg-gray-700 transition-colors duration-150 '
                            + 'flex items-start gap-3 border-b border-gray-100 dark:border-gray-700 last:border-0';

                        btn.innerHTML =
                            '<svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                            + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>'
                            + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                            + '<span class="flex-1 min-w-0 line-clamp-2 leading-snug">' + escHtml(res.display_name) + '</span>';

                        btn.addEventListener('click', function () { selectLocation(res); });
                        dropdown.appendChild(btn);
                    });

                    dropdown.classList.remove('hidden');
                    setFeedback('Selecciona una dirección de la lista.');
                }

                function hideDropdown() {
                    dropdown.classList.add('hidden');
                    dropdown.innerHTML = '';
                }

                // ── Selección de ubicación ────────────────────────────
                function selectLocation(result) {
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);
                    if (isNaN(lat) || isNaN(lon)) return;

                    if (map) {
                        map.flyTo({ center: [lon, lat], zoom: 15, duration: 900 });
                    }
                    if (marker) {
                        marker.setLngLat([lon, lat]);
                    }
                    updateCoords(lon, lat);

                    // Extracción robusta de provincia desde el objeto address
                    const addr = result.address || {};
                    const prov = (
                        addr.county         ||
                        addr.state_district ||
                        addr.municipality   ||
                        addr.city           ||
                        addr.town           ||
                        addr.village        ||
                        addr.state          ||
                        (result.display_name
                            ? result.display_name.split(',').slice(-3, -1).join(',').trim()
                            : 'valencia')
                    ).toLowerCase().trim();
                    provInput.value = prov;

                    // Nombre corto en el input de búsqueda
                    const shortName = [
                        addr.road || addr.pedestrian,
                        addr.city || addr.town || addr.village || addr.municipality,
                        addr.state
                    ].filter(Boolean).join(', ') || result.display_name;

                    searchInput.value = shortName;
                    hideDropdown();
                    setFeedback('Ubicación aplicada al formulario.');
                }

                // ── Eventos del mapa ──────────────────────────────────
                if (map && marker) {
                    marker.on('dragend', function () {
                        const p = marker.getLngLat();
                        updateCoords(p.lng, p.lat);
                        setFeedback('Coordenadas actualizadas desde el marcador.');
                    });

                    map.on('click', function (e) {
                        marker.setLngLat(e.lngLat);
                        updateCoords(e.lngLat.lng, e.lngLat.lat);
                        setFeedback('Coordenadas actualizadas desde el mapa.');
                    });

                    map.on('load', function () { map.resize(); });
                    window.addEventListener('resize', function () { map.resize(); });
                }

                // ── Búsqueda con debounce ─────────────────────────────
                var debounce = null;
                var activeController = null;

                function fetchLocations(q) {
                    if (activeController) activeController.abort();
                    activeController = new AbortController();

                    var url = 'https://nominatim.openstreetmap.org/search'
                        + '?format=json'
                        + '&addressdetails=1'
                        + '&accept-language=es'
                        + '&limit=6'
                        + '&countrycodes=es'
                        + '&q=' + encodeURIComponent(q);

                    setSpinner(true);
                    setFeedback('Buscando direcciones...');

                    return fetch(url, {
                        headers: { 'Accept': 'application/json' },
                        signal: activeController.signal
                    })
                    .then(function (r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function (data) {
                        setSpinner(false);
                        showDropdown(data);
                    })
                    .catch(function (err) {
                        setSpinner(false);
                        if (err.name === 'AbortError') return;
                        hideDropdown();
                        setFeedback('No se pudo buscar ahora. Inténtalo de nuevo.', true);
                        console.warn('[SolarCalc] Nominatim:', err.message);
                    });
                }

                searchInput.addEventListener('input', function () {
                    var q = searchInput.value.trim();
                    clearTimeout(debounce);

                    if (q.length < 3) {
                        hideDropdown();
                        setSpinner(false);
                        setFeedback('Escribe al menos 3 caracteres para buscar.');
                        return;
                    }

                    debounce = setTimeout(function () {
                        fetchLocations(q);
                    }, 500);
                });

                // Enter busca sin enviar el formulario completo
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        var q = searchInput.value.trim();
                        if (q.length >= 3) fetchLocations(q);
                        return;
                    }
                    if (e.key === 'Escape') {
                        hideDropdown();
                        searchInput.blur();
                    }
                });

                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function (e) {
                    var wrapper = document.getElementById('search-wrapper');
                    if (wrapper && !wrapper.contains(e.target)) hideDropdown();
                });

                // Mostrar indicador si venía de old()
                if (latInput.value && latInput.value !== '39.1867') {
                    updateCoords(parseFloat(lngInput.value), parseFloat(latInput.value));
                    setFeedback('Se cargó tu última ubicación seleccionada.');
                } else {
                    setFeedback('Busca una dirección o haz clic en el mapa para fijar zona.');
                }

            } // fin init()

            // Ejecutar cuando el DOM y los scripts anteriores estén listos
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

        })();
        </script>
    @endpush

</x-app-layout>
