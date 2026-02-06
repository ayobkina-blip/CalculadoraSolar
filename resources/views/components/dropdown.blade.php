@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-slate-800'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    '72' => 'w-72',
    '80' => 'w-80',
    default => $width,
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
            class="absolute z-50 mt-2 {{ $width }} rounded-xl shadow-2xl {{ $alignmentClasses }} border border-slate-200 dark:border-slate-700 backdrop-blur-sm"
            style="display: none;"
            @click="open = false">
        <div class="rounded-xl {{ $contentClasses }} overflow-hidden">
            {{ $content }}
        </div>
    </div>
</div>
