<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                    Checkout — Plan {{ $plan->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Proceso de pago seguro simulado</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                
                {{-- Columna izquierda: Resumen del pedido --}}
                <div class="lg:sticky lg:top-24 h-fit">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Resumen del pedido</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Plan</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $plan->name }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Precio</span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($plan->price_cents / 100, 2) }}€ / 
                                    {{ $plan->interval === 'month' ? 'mes' : 'año' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Renovación</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Automática</span>
                            </div>
                            
                            <div class="py-4">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Incluye:</p>
                                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simulaciones ilimitadas
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Descarga de informes PDF
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Estadísticas avanzadas
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Comparador de simulaciones
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Exportación CSV
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mt-6 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Entorno de demostración</p>
                                    <p class="text-xs text-amber-700/90 dark:text-amber-300/90 mt-1">
                                        Esto es un entorno de demo. No se realizará ningún cargo real.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: Formulario de pago --}}
                <div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Información de pago</h3>
                        
                        <form method="POST" action="{{ route('subscription.subscribe', $plan->code) }}"
                              x-data="checkoutForm()"
                              @submit.prevent="submitForm"
                              class="space-y-6">
                            @csrf

                            {{-- Número de tarjeta --}}
                            <div>
                                <label for="card_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Número de tarjeta
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="card_number"
                                           name="card_number"
                                           x-model="cardNumber"
                                           @input="formatCard"
                                           maxlength="19"
                                           placeholder="1234 5678 9012 3456"
                                           inputmode="numeric"
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <span x-show="cardBrand === 'Visa'" class="text-blue-600 font-bold text-sm">VISA</span>
                                        <span x-show="cardBrand === 'Mastercard'" class="text-red-600 font-bold text-sm">MC</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Nombre en tarjeta --}}
                            <div>
                                <label for="card_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre en tarjeta
                                </label>
                                <input type="text" 
                                       id="card_name"
                                       name="card_name" 
                                       placeholder="NOMBRE APELLIDO"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent uppercase">
                            </div>

                            {{-- Fila: Caducidad + CVV --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Caducidad
                                    </label>
                                    <input type="text" 
                                           id="card_expiry"
                                           name="card_expiry" 
                                           placeholder="MM/AA"
                                           maxlength="5"
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="card_cvv" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        CVV
                                    </label>
                                    <input type="text" 
                                           id="card_cvv"
                                           name="card_cvv" 
                                           placeholder="CVV"
                                           maxlength="4"
                                           inputmode="numeric"
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>
                            </div>

                            {{-- Botón de pago --}}
                            <button type="submit" 
                                    :disabled="processing"
                                    :class="processing ? 'opacity-60 cursor-not-allowed' : 'hover:bg-amber-500'"
                                    class="w-full py-4 px-6 rounded-xl bg-amber-600 text-white text-sm font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <span x-show="!processing" class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Pagar {{ number_format($plan->price_cents / 100, 2) }}€
                                </span>
                                <span x-show="processing" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                    Procesando pago…
                                </span>
                            </button>

                            @error('card_number')
                                <p class="text-xs text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                            @error('card_name')
                                <p class="text-xs text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                            @error('card_expiry')
                                <p class="text-xs text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                            @error('card_cvv')
                                <p class="text-xs text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkoutForm() {
            return {
                cardNumber: '',
                processing: false,
                get cardBrand() {
                    const cleanNumber = this.cardNumber.replace(/\D/g, '');
                    if (cleanNumber.startsWith('4')) return 'Visa';
                    if (cleanNumber.startsWith('5')) return 'Mastercard';
                    return '';
                },
                formatCard() {
                    let val = this.cardNumber.replace(/\D/g, '').slice(0, 16);
                    this.cardNumber = val.replace(/(.{4})/g, '$1 ').trim();
                },
                submitForm() {
                    this.processing = true;
                    this.$el.submit();
                }
            }
        }
    </script>
</x-app-layout>
