@props(['level' => 1, 'size' => 'sm'])

@php
    $level = (int) $level;
    $sizes = [
        'xs' => 'text-[10px] px-2 py-0.5 space-x-1',
        'sm' => 'text-xs px-2.5 py-1 space-x-1.5',
        'md' => 'text-sm px-3 py-1.5 space-x-2',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['sm'];

    $levels = [
        1 => [
            'label' => 'Level 1: Basic',
            'short' => 'Lvl 1',
            'icon' => 'mail',
            'bg' => 'bg-slate-100 text-slate-700 border-slate-200',
        ],
        2 => [
            'label' => 'Level 2: Phone Verified',
            'short' => 'Lvl 2',
            'icon' => 'smartphone',
            'bg' => 'bg-sky-50 text-sky-700 border-sky-200',
        ],
        3 => [
            'label' => 'Level 3: ID Verified',
            'short' => 'Lvl 3',
            'icon' => 'shield-check',
            'bg' => 'bg-amber-50 text-amber-800 border-amber-200',
        ],
        4 => [
            'label' => 'Level 4: Portfolio Pro',
            'short' => 'Lvl 4',
            'icon' => 'star',
            'bg' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        ],
        5 => [
            'label' => 'Level 5: Platform Elite',
            'short' => 'Lvl 5 Elite',
            'icon' => 'crown',
            'bg' => 'bg-emerald-50 text-emerald-800 border-emerald-300 font-black ring-1 ring-emerald-400/20',
        ],
    ];

    $current = $levels[$level] ?? $levels[1];
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full font-bold border shadow-2xs {{ $sizeClass }} {{ $current['bg'] }}" title="{{ $current['label'] }}">
    <i data-lucide="{{ $current['icon'] }}" class="w-3.5 h-3.5 inline-block shrink-0"></i>
    <span class="truncate">{{ $current['label'] }}</span>
</span>
