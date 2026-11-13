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
            'bg' => 'bg-white text-[#524B66] border border-[#181528]/30 shadow-[1px_1px_0_#181528]',
        ],
        2 => [
            'label' => 'Level 2: Phone Verified',
            'short' => 'Lvl 2',
            'icon' => 'smartphone',
            'bg' => 'bg-[#EAF5FE] text-[#0E4875] border border-[#181528] shadow-[1.5px_1.5px_0_#181528]',
        ],
        3 => [
            'label' => 'Level 3: ID Verified',
            'short' => 'Lvl 3',
            'icon' => 'shield-check',
            'bg' => 'bg-[#FFF9AA] text-[#181528] border border-[#181528] shadow-[1.5px_1.5px_0_#181528]',
        ],
        4 => [
            'label' => 'Level 4: Portfolio Pro',
            'short' => 'Lvl 4',
            'icon' => 'star',
            'bg' => 'bg-[#BDB0FC] text-[#181528] border border-[#181528] shadow-[1.5px_1.5px_0_#181528]',
        ],
        5 => [
            'label' => 'Level 5: Platform Elite',
            'short' => 'Lvl 5 Elite',
            'icon' => 'crown',
            'bg' => 'bg-[#E2F163] text-[#181528] border-2 border-[#181528] shadow-[2px_2px_0_#181528] font-black',
        ],
    ];

    $current = $levels[$level] ?? $levels[1];
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full font-bold font-mono {{ $sizeClass }} {{ $current['bg'] }}" title="{{ $current['label'] }}">
    <i data-lucide="{{ $current['icon'] }}" class="w-3.5 h-3.5 inline-block shrink-0"></i>
    <span class="truncate">{{ $current['label'] }}</span>
</span>
