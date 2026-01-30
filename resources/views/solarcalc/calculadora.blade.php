<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            {{ __('Calculadora de Ingeniería Fotovoltaica') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-[#0b1120]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('solar.procesar') }}" method="POST" class="flex flex-col lg:flex-row gap-8 items-stretch" x-data="{ consumo: 350, superficie: 40 }">
                @csrf

                <div class="flex-1 bg-white dark:bg-[#111827] rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col min-h-[650px]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-amber-500 rounded-full"></span>
                            1. Geoposicionamiento
                        </h3>
                        <span class="px-2 py-0.5 bg-amber-500/10 text-amber-500 rounded-md text-[9px] font-bold uppercase tracking-tighter border border-amber-500/20">Motor WebGL Activo</span>
                    </div>

                    <div class="relative mb-6" x-data="{ results: [] }">
                        <div class="relative">
                            <input type="text" 
                                   id="search-address"
                                   placeholder="Busca tu ciudad o dirección..."
                                   class="w-full h-12 bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-700 dark:text-white pl-10 focus:ring-2 focus:ring-amber-500 transition-all outline-none"
                                   @input.debounce.500ms="
                                        if($event.target.value.length > 2) {
                                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${$event.target.value}`)
                                                .then(res => res.json())
                                                .then(data => { results = data; })
                                        } else { results = [] }
                                   ">
                            <svg class="absolute left-3 top-3.5 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/></svg>
                        </div>

                        <div x-show="results.length > 0" class="absolute z-[9999] w-full mt-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-2xl overflow-hidden" x-cloak @click.away="results = []">
                            <template x-for="res in results" :key="res.place_id">
                                <button type="button" 
                                        @click="window.selectLocation(res.lat, res.lon, res.display_name); results = [];"
                                        class="w-full text-left px-4 py-3 text-xs text-slate-600 dark:text-slate-300 hover:bg-amber-500 hover:text-white transition-colors border-b border-slate-100 dark:border-slate-800 last:border-0">
                                    <span x-text="res.display_name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="relative flex-grow rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden bg-[#0b1120]">
                        <div id="main-map" class="absolute inset-0 w-full h-full"></div>
                    </div>
                    
                    <input type="hidden" name="latitud" id="lat-input" value="39.1867">
                    <input type="hidden" name="longitud" id="lng-input" value="-0.4367">
                    <input type="hidden" name="provincia" id="prov-input" value="valencia">
                </div>

                <div class="w-full lg:w-[420px] bg-white dark:bg-[#111827] rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col h-auto min-h-full">
                    <div class="flex-grow">
                        <h3 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-widest flex items-center gap-2 mb-10">
                            <span class="w-1.5 h-4 bg-amber-500 rounded-full"></span>
                            2. Parámetros de carga
                        </h3>

                        <div class="space-y-10">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Consumo Mensual (kWh)</label>
                                    <input type="number" name="consumo" x-model="consumo" 
                                           class="w-24 h-9 bg-slate-50 dark:bg-slate-950 border-none rounded-lg text-right font-black text-amber-500 text-sm focus:ring-1 focus:ring-amber-500 outline-none">
                                </div>
                                <input type="range" x-model="consumo" min="50" max="2500" step="10" class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer accent-amber-500">
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Superficie (m²)</label>
                                    <input type="number" name="superficie" x-model="superficie" 
                                           class="w-24 h-9 bg-slate-50 dark:bg-slate-950 border-none rounded-lg text-right font-black text-amber-500 text-sm focus:ring-1 focus:ring-amber-500 outline-none">
                                </div>
                                <input type="range" x-model="superficie" min="10" max="1000" step="5" class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer accent-amber-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Orientación</label>
                                    <select name="orientacion" class="w-full h-12 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-xs font-black text-slate-600 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500 px-3">
                                        <option value="0">Sur (Óptimo)</option>
                                        <option value="-45">Sureste</option>
                                        <option value="45">Suroeste</option>
                                        <option value="-90">Este</option>
                                        <option value="90">Oeste</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Inclinación (°)</label>
                                    <input type="number" name="inclinacion" value="30" class="w-full h-12 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-xs font-black text-slate-600 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500 px-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button type="submit" class="w-full flex items-center justify-center gap-3 py-5 bg-amber-500 hover:bg-amber-600 text-white rounded-3xl font-black uppercase tracking-widest text-xs transition-all shadow-xl shadow-amber-500/20 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Iniciar Simulación Técnica
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link href='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css' rel='stylesheet' />
        <style>
            .maplibregl-canvas { outline: none !important; }
            input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; height: 18px; width: 18px; border-radius: 50%; background: #f59e0b; border: 3px solid #fff; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
            input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
            [x-cloak] { display: none !important; }
        </style>
    @endpush

    @push('js')
        <script src='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const latInput = document.getElementById('lat-input');
                const lngInput = document.getElementById('lng-input');
                const provInput = document.getElementById('prov-input');

                const map = new maplibregl.Map({
                    container: 'main-map',
                    style: {
                        "version": 8,
                        "sources": {
                            "osm-tiles": {
                                "type": "raster",
                                "tiles": ["https://a.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png"],
                                "tileSize": 256
                            }
                        },
                        "layers": [{"id": "osm-layer", "type": "raster", "source": "osm-tiles"}]
                    },
                    center: [-0.4367, 39.1867], 
                    zoom: 13,
                    trackResize: true
                });

                const marker = new maplibregl.Marker({ draggable: true, color: "#f59e0b" })
                    .setLngLat([-0.4367, 39.1867])
                    .addTo(map);

                const updateInputs = (lng, lat) => {
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                };

                marker.on('dragend', () => {
                    const lngLat = marker.getLngLat();
                    updateInputs(lngLat.lng, lngLat.lat);
                });

                map.on('click', (e) => {
                    marker.setLngLat(e.lngLat);
                    updateInputs(e.lngLat.lng, e.lngLat.lat);
                });

                window.selectLocation = (lat, lon, displayName) => {
                    const coords = [parseFloat(lon), parseFloat(lat)];
                    map.flyTo({ center: coords, zoom: 15 });
                    marker.setLngLat(coords);
                    updateInputs(coords[0], coords[1]);
                    const parts = displayName.split(',');
                    provInput.value = parts.length > 2 ? parts[parts.length - 3].trim().toLowerCase() : 'valencia';
                };

                window.addEventListener('resize', () => map.resize());
                map.on('load', () => map.resize());
            });
        </script>
    @endpush
</x-app-layout>