<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <linearGradient id="solarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
        </linearGradient>
    </defs>
    
    <path class="fill-amber-500/30 dark:fill-amber-500/20" d="M50 5 L55 25 L75 30 L55 35 L50 55 L45 35 L25 30 L45 25 Z" />
    
    <circle cx="50" cy="30" r="15" fill="url(#solarGradient)" />
    
    <path d="M30 70 L50 90 L70 70 L50 50 Z" class="fill-slate-800 dark:fill-white" />
    <path d="M50 50 L70 70 L50 65 Z" class="fill-slate-600 dark:fill-slate-300" />
</svg>