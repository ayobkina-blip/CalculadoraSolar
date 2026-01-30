<section>
    {{-- CABECERA ESTILO PROTOCOLO --}}
    <header class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h3 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="relative">
                    <div class="w-2 h-5 bg-amber-500 rounded-full shadow-[0_0_12px_rgba(245,158,11,0.6)]"></div>
                    <div class="absolute inset-0 w-2 h-5 bg-amber-500 rounded-full animate-ping opacity-20"></div>
                </div>
                {{ __('Identidad de Acceso') }}
            </h3>
            <p class="mt-2 text-[11px] text-slate-400 font-medium italic max-w-md">
                {{ __("Configura los parámetros de comunicación, biometría visual y el nombre que se mostrará en el sistema.") }}
            </p>
        </div>
        <div class="hidden sm:block">
            <span class="text-[9px] font-black uppercase tracking-widest text-slate-300 dark:text-slate-600 border border-slate-100 dark:border-slate-800 px-3 py-1 rounded-full">
                Protocolo v.2.6
            </span>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- IMPORTANTE: enctype="multipart/form-data" para permitir subir la foto --}}
    <form method="post" action="{{ route('profile.update') }}" class="space-y-10" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- SECCIÓN DE CARGA DE AVATAR --}}
        <div x-data="{ photoName: null, photoPreview: null }" class="flex flex-col items-center sm:items-start mb-12">
            <input type="file" class="hidden" x-ref="photo" name="avatar"
                   @change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => { photoPreview = e.target.result; };
                        reader.readAsDataURL($refs.photo.files[0]);
                   ">

            <div class="relative group">
                {{-- Contenedor de la Imagen con Estilo "Sensor" --}}
                <div class="w-32 h-32 rounded-[2.5rem] p-1 bg-gradient-to-tr from-amber-500 to-slate-200 dark:to-slate-700 shadow-2xl transition-all duration-500 group-hover:rotate-2">
                    <div class="w-full h-full rounded-[2.3rem] overflow-hidden bg-white dark:bg-slate-950 border-4 border-white dark:border-slate-900">
                        {{-- Foto actual (Si existe en el modelo User, si no usa UI Avatars) --}}
                        <img x-show="!photoPreview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                             class="w-full h-full object-cover">
                        
                        {{-- Vista previa de la nueva foto --}}
                        <img x-show="photoPreview" :src="photoPreview" class="w-full h-full object-cover" x-cloak>
                    </div>
                </div>

                {{-- Botón de Acción Flotante --}}
                <button type="button" @click.prevent="$refs.photo.click()" 
                        class="absolute -bottom-2 -right-2 bg-slate-900 dark:bg-amber-500 text-white dark:text-slate-900 p-3 rounded-2xl shadow-xl hover:scale-110 active:scale-90 transition-all border-4 border-white dark:border-slate-950 group-hover:rotate-12">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <p class="mt-4 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Carga Biométrica (.JPG, .PNG)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
            {{-- Campo: Nombre --}}
            <div class="group">
                <div class="flex items-center justify-between mb-2 px-1">
                    <x-input-label for="name" :value="__('Nombre Completo')" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 transition-colors group-focus-within:text-amber-500" />
                    <span class="text-[9px] font-mono text-slate-300 dark:text-slate-600 uppercase tracking-tighter">Editable</span>
                </div>
                <div class="relative">
                    <x-text-input id="name" name="name" type="text" 
                        class="block w-full border-slate-100 dark:border-slate-800 dark:bg-slate-900/50 rounded-2xl shadow-sm focus:ring-amber-500/20 focus:border-amber-500 h-16 pl-6 pr-12 transition-all group-hover:border-slate-200 dark:group-hover:border-slate-700 focus:-translate-y-1 font-bold text-slate-700 dark:text-slate-200" 
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-600 transition-colors group-focus-within:text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-tight text-rose-500" :messages="$errors->get('name')" />
            </div>

            {{-- Campo: Email --}}
            <div class="group">
                <div class="flex items-center justify-between mb-2 px-1">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 transition-colors group-focus-within:text-amber-500" />
                    <span class="text-[9px] font-mono text-slate-300 dark:text-slate-600 uppercase tracking-tighter">Canal Principal</span>
                </div>
                <div class="relative">
                    <x-text-input id="email" name="email" type="email" 
                        class="block w-full border-slate-100 dark:border-slate-800 dark:bg-slate-900/50 rounded-2xl shadow-sm focus:ring-amber-500/20 focus:border-amber-500 h-16 pl-6 pr-12 transition-all group-hover:border-slate-200 dark:group-hover:border-slate-700 focus:-translate-y-1 font-bold text-slate-700 dark:text-slate-200" 
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-600 transition-colors group-focus-within:text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-tight text-rose-500" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-amber-50/50 dark:bg-amber-900/10 rounded-2xl border border-amber-100/50 dark:border-amber-800/30 flex items-center gap-3">
                        <div class="p-1.5 bg-amber-500 rounded-lg text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <p class="text-[11px] text-amber-800 dark:text-amber-400 font-bold uppercase tracking-tighter">
                            {{ __('Verificación requerida.') }}
                            <button form="send-verification" class="ml-2 underline hover:text-amber-600 dark:hover:text-amber-300 transition-colors">
                                {{ __('Reactivar enlace') }}
                            </button>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-6 pt-6 border-t border-slate-50 dark:border-slate-800/50">
            <x-primary-button class="w-full sm:w-auto bg-slate-900 dark:bg-amber-500 hover:bg-slate-800 dark:hover:bg-amber-600 text-white dark:text-slate-950 rounded-[1.2rem] px-10 py-5 text-[10px] font-black uppercase tracking-[0.25em] transition-all shadow-2xl shadow-slate-200 dark:shadow-amber-500/10 active:scale-95 border-none">
                {{ __('Sincronizar Protocolo') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-init="setTimeout(() => show = false, 4000)" 
                    class="flex items-center gap-3 text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/10 px-5 py-3 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    {{ __('Registros actualizados') }}
                </div>
            @endif
        </div>
    </form>
</section>