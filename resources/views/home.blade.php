<x-main-layout>
    {{-- 1. HERO SECTION --}}
    <section class="relative overflow-hidden bg-white dark:bg-gray-900 pt-16 pb-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-black uppercase tracking-widest bg-amber-500/10 text-amber-600 dark:text-amber-500 mb-8 border border-amber-500/20">
                    Tecnología Solar de Precisión
                </span>

                <h1 class="text-6xl md:text-8xl font-black text-gray-900 dark:text-white tracking-tighter mb-8">
                    Tu tejado es una <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-yellow-600">
                        mina de oro.
                    </span>
                </h1>

                <p class="max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-400 leading-relaxed mb-12">
                    Calcula en 30 segundos el potencial fotovoltaico de tu vivienda en Algemesí con datos reales de irradiancia y ahorro garantizado.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('solar.calculadora') }}" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black uppercase tracking-widest transition-all hover:scale-105 shadow-xl shadow-amber-500/25 flex items-center justify-center gap-2">
                        Comenzar cálculo gratuito
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#metodologia" class="px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-2xl font-bold transition-all hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center">
                        Ver metodología
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. FEATURES GRID --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-amber-500/50 transition-colors">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-black dark:text-white mb-3">Hiper-localizado</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">No usamos promedios nacionales. Utilizamos coordenadas exactas de la Ribera Alta.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-amber-500/50 transition-colors">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-black dark:text-white mb-3">ROI Realista</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Incluimos la degradación de los paneles y el precio actual de la luz.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-amber-500/50 transition-colors">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-black dark:text-white mb-3">Exportación PDF</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Obtén un informe técnico detallado listo para presentar a instaladores.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. INTERACTIVE SECTION --}}
    <section id="metodologia" class="py-24 max-w-[900px] mx-auto px-6">
        <div class="space-y-20">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                <div class="flex-1">
                    <span class="text-amber-500 font-black text-4xl opacity-20">01</span>
                    <h2 class="text-3xl font-black dark:text-white mt-2 mb-4 text-gray-900">Análisis de Superficie</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 italic">"No todo el tejado sirve."</p>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Nuestro sistema calcula el área útil descontando obstáculos y optimizando la inclinación.</p>
                </div>
                <div class="flex-1 bg-gray-100 dark:bg-gray-800 h-48 w-full rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/></svg>
                </div>
            </div>

            <div class="flex flex-col md:flex-row-reverse gap-12 items-center">
                <div class="flex-1 text-right md:text-left">
                    <span class="text-amber-500 font-black text-4xl opacity-20">02</span>
                    <h2 class="text-3xl font-black dark:text-white mt-2 mb-4 text-gray-900">Simulación Energética</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 italic">"Energía real, no teórica."</p>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Cruzamos tus datos con el histórico de radiación mensual de la Comunidad Valenciana.</p>
                </div>
                <div class="flex-1 bg-gray-100 dark:bg-gray-800 h-48 w-full rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. FINAL CTA --}}
    <section class="max-w-7xl mx-auto px-6 mb-20">
        <div class="bg-[#1e293b] rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-64 h-64 bg-amber-500 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-64 h-64 bg-blue-500 rounded-full blur-[100px]"></div>
            </div>

            <h2 class="text-4xl md:text-5xl font-black text-white mb-8 relative z-10">
                Únete a los más de <span class="text-amber-500">{{ $conteo ?? '100+' }}</span> usuarios que ya ahorran.
            </h2>

            <div class="relative z-10">
                <a href="{{ route('solar.calculadora') }}" class="inline-flex items-center gap-4 bg-white text-gray-900 px-10 py-5 rounded-2xl font-black uppercase tracking-widest transition-all hover:bg-amber-500 hover:text-white hover:scale-105 shadow-2xl">
                    Empezar ahora
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            
            <p class="mt-8 text-gray-400 text-sm font-medium relative z-10 tracking-wide uppercase">
                Sin registros obligatorios · Resultados instantáneos · 100% Gratuito
            </p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 text-center text-gray-500 dark:text-gray-400">
        <p class="text-[10px] font-black uppercase tracking-[0.5em] mb-4">SolarCalc Algemesí</p>
        <div class="w-12 h-1 bg-amber-500 mx-auto rounded-full mb-8"></div>
        <p class="text-xs">Desarrollado para la optimización energética residencial.</p>
    </footer>
</x-main-layout>