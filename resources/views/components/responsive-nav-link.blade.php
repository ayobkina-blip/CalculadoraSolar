{{-- Actualización: enlace responsive con padding generoso, activo con border-l-4 amber y foco visible. --}}
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full py-3 px-4 border-l-4 border-amber-600 text-start text-sm font-semibold text-amber-500 bg-amber-50 dark:bg-amber-950/30 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2'
            : 'block w-full py-3 px-4 border-l-4 border-transparent text-start text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
