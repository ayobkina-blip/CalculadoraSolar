{{-- Actualización: dropdown más robusto en móvil (sin overflow), con ring/sombra y transiciones suaves. --}}
@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-slate-800'])

@php
$alignmentClasses = match ($align) {
    'left' => 'origin-top-left start-0',
    'top' => 'origin-top',
    default => 'origin-top-right end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    '72' => 'w-72',
    '80' => 'w-80',
    default => $width,
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" @keydown.escape.window="open = false">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-cloak x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        class="absolute z-50 mt-2 {{ $width }} max-w-[calc(100vw-1rem)] sm:max-w-none rounded-xl shadow-lg ring-1 ring-black/5 dark:ring-white/10 {{ $alignmentClasses }} border border-gray-200 dark:border-gray-700 backdrop-blur-sm"
        style="display: none;"
        @click="open = false">
        <div class="rounded-xl {{ $contentClasses }} overflow-hidden">
            {{ $content }}
        </div>
    </div>
</div>
