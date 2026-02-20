{{-- Actualización: estados normal/hover/activo con foco accesible y color primario amber coherente con navegación. --}}
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-amber-600 text-amber-500 font-semibold leading-5 transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2'
            : 'inline-flex items-center border-b-2 border-transparent text-gray-500 dark:text-gray-400 font-medium leading-5 hover:text-gray-900 dark:hover:text-white hover:border-amber-500 transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
