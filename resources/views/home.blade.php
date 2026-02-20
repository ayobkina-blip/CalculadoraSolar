<x-main-layout>
    {{-- Actualización: se mejoró estructura semántica y responsive del home (hero, features, metodología y CTA). --}}

    {{-- 1. HERO --}}
    <section class="relative min-h-screen flex items-center justify-center pt-24 sm:pt-28 md:pt-32 lg:pt-40 pb-16 bg-white dark:bg-gray-900">
        <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="inline-flex items-center px-4 py-1.5 mb-8 rounded-full text-sm font-semibold tracking-wide uppercase border border-amber-200 dark:border-amber-800 text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40">
                Tecnología Solar de Precisión
            </span>

            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                Tu tejado es una
                <span class="block bg-clip-text text-transparent bg-gradient-to-r from-amber-500 to-orange-500">
                    mina de oro.
                </span>
            </h1>

            <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl md:text-2xl text-gray-600 dark:text-gray-400">
                Calcula en 30 segundos el potencial fotovoltaico de tu vivienda en Algemesí con datos reales de irradiancia y ahorro garantizado.
            </p>

            <div class="mt-10 flex flex-col gap-3 w-full max-w-xs mx-auto sm:max-w-none sm:flex-row sm:justify-center sm:gap-4">
                <a href="{{ route('solar.calculadora') }}"
                    class="inline-flex items-center justify-center gap-2 py-3 px-8 sm:py-4 sm:px-10 text-base sm:text-lg font-semibold rounded-xl bg-amber-600 text-white hover:bg-amber-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    Comenzar cálculo gratuito
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>

                <a href="#metodologia"
                    class="inline-flex items-center justify-center py-3 px-8 sm:py-4 sm:px-10 text-base sm:text-lg font-semibold rounded-xl border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    Ver metodología
                </a>
            </div>
        </div>
    </section>

    {{-- 2. FEATURES --}}
    <section class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <article
                    class="p-6 md:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 ease-in-out">
                    <div class="w-10 h-10 md:w-12 md:h-12 mb-5 rounded-xl flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Hiper-localizado</h3>
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                        No usamos promedios nacionales. Utilizamos coordenadas exactas de la Ribera Alta.
                    </p>
                </article>

                <article
                    class="p-6 md:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 ease-in-out">
                    <div class="w-10 h-10 md:w-12 md:h-12 mb-5 rounded-xl flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">ROI Realista</h3>
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                        Incluimos la degradación de los paneles y el precio actual de la luz.
                    </p>
                </article>

                <article
                    class="p-6 md:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 ease-in-out">
                    <div class="w-10 h-10 md:w-12 md:h-12 mb-5 rounded-xl flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Exportación PDF</h3>
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                        Obtén un informe técnico detallado listo para presentar a instaladores.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- 3. METODOLOGÍA --}}
    <section id="metodologia" class="py-16 md:py-24 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 md:space-y-16">
            <article class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="w-full md:w-1/2">
                    <span class="text-amber-500 font-bold text-sm tracking-[0.2em] uppercase">Paso 01</span>
                    <h2 class="mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        Análisis de Superficie
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-400 italic">"No todo el tejado sirve."</p>
                    <p class="mt-3 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                        Nuestro sistema calcula el área útil descontando obstáculos y optimizando la inclinación.
                    </p>
                </div>
                <div
                    class="w-full md:w-1/2 h-56 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                    </svg>
                </div>
            </article>

            <article class="flex flex-col md:flex-row-reverse items-center gap-8 md:gap-12">
                <div class="w-full md:w-1/2">
                    <span class="text-amber-500 font-bold text-sm tracking-[0.2em] uppercase">Paso 02</span>
                    <h2 class="mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        Simulación Energética
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-400 italic">"Energía real, no teórica."</p>
                    <p class="mt-3 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                        Cruzamos tus datos con el histórico de radiación mensual de la Comunidad Valenciana.
                    </p>
                </div>
                <div
                    class="w-full md:w-1/2 h-56 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </article>
        </div>
    </section>

    {{-- 4. CTA FINAL --}}
    <section class="py-16 md:py-24 px-4 bg-white dark:bg-gray-900">
        <div class="max-w-5xl mx-auto rounded-2xl border border-amber-200 dark:border-amber-900/60 bg-amber-50 dark:bg-amber-950/30 p-8 sm:p-12 md:p-16 text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                Únete a los más de <span class="text-amber-500">{{ $conteo ?? '100+' }}</span> usuarios que ya ahorran.
            </h2>

            <a href="{{ route('solar.calculadora') }}"
                class="mt-8 inline-flex items-center justify-center gap-3 py-3 px-8 sm:py-4 sm:px-10 text-base sm:text-lg font-semibold rounded-xl bg-amber-600 text-white hover:bg-amber-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                Empezar ahora
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>

            <p class="mt-6 text-sm text-gray-600 dark:text-gray-400">
                Sin registros obligatorios · Resultados instantáneos · 100% gratuito
            </p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 text-center text-gray-500 dark:text-gray-400">
        <p class="text-xs font-semibold uppercase tracking-[0.35em] mb-4">SolarCalc Algemesí</p>
        <div class="w-12 h-1 bg-amber-500 mx-auto rounded-full mb-6"></div>
        <p class="text-sm">Desarrollado para la optimización energética residencial.</p>
    </footer>
</x-main-layout>
