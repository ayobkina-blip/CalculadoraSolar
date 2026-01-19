<x-main-layout>
    {{-- Eliminamos el link al CSS externo --}}

    <div class="bg-white dark:bg-gray-800 shadow-2xl sm:rounded-3xl overflow-hidden mb-20">
        {{-- .report-container --}}
        <div class="max-w-[900px] mx-auto leading-[1.8] text-gray-700 dark:text-gray-300 px-6">
            
            {{-- .report-header --}}
            <header class="pt-20 pb-[60px] border-b border-gray-100 dark:border-gray-700 mb-[60px]">
                {{-- .section-label --}}
                <span class="block text-[0.75rem] font-[900] uppercase tracking-[0.3em] text-yellow-600 dark:text-yellow-500 mb-5">
                    Documentación Técnica
                </span>
                {{-- .report-title --}}
                <h1 class="text-5xl md:text-[3rem] font-light leading-[1.1] text-gray-900 dark:text-white tracking-[-0.02em]">
                    Análisis de Viabilidad y 
                    <b class="font-[800] block">Sostenibilidad Fotovoltaica</b>
                </h1>
            </header>

            {{-- .report-section (Introducción) --}}
            <section class="mb-20">
                <span class="block text-[0.75rem] font-[900] uppercase tracking-[0.3em] text-yellow-600 dark:text-yellow-500 mb-5">
                    01. Introducción
                </span>
                {{-- .lead-text --}}
                <p class="text-2xl font-semibold leading-[1.4] text-gray-800 dark:text-gray-100 mb-[30px]">
                    La optimización de los recursos renovables en el sector residencial de la Comunidad Valenciana representa el eje central de este estudio técnico.
                </p>
                {{-- .body-text --}}
                <div class="text-lg text-justify [hyphens:auto] text-gray-600 dark:text-gray-400">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </section>

            {{-- .report-section (Metodología) --}}
            <section class="mb-20">
                <span class="block text-[0.75rem] font-[900] uppercase tracking-[0.3em] text-yellow-600 dark:text-yellow-500 mb-5">
                    02. Marco Metodológico
                </span>
                <div class="text-lg text-justify [hyphens:auto] text-gray-600 dark:text-gray-400 space-y-6">
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                    </p>
                    <p>
                        Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur.
                    </p>
                </div>
            </section>

            {{-- .highlight-box --}}
            <div class="bg-gray-900 dark:bg-black text-gray-50 p-[50px] rounded-[24px] my-[60px]">
                <span class="block text-[0.75rem] font-[900] uppercase tracking-[0.3em] text-yellow-500 mb-5">
                    03. Contexto Local
                </span>
                <h3 class="text-2xl font-bold mb-4 text-white">Proyección de datos en Algemesí</h3>
                <p class="text-gray-300">
                    Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                </p>
            </div>

            <section class="mb-20">
                <div class="text-lg text-justify [hyphens:auto] text-gray-600 dark:text-gray-400">
                    <p>
                        Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.
                    </p>
                </div>
            </section>

            {{-- .quote-section --}}
            <footer class="text-center py-[60px] italic text-[1.25rem] text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700">
                <p>"Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur."</p>
                <div class="mt-8 text-xs font-black tracking-[0.5em] text-gray-400 uppercase">
                    SolarCalc — Algemesí, Valencia
                </div>
            </footer>

        </div>
    </div>
</x-main-layout>