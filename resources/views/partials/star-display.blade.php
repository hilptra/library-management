@props([
    'rating' => 0,
    'showScore' => false,
    'reviewsCount' => null,
    'size' => 'sm'
])

@php
    $avg = round((float) $rating, 1);
    $fullStars = floor($avg);
    $hasHalf = ($avg - $fullStars) >= 0.3 && ($avg - $fullStars) <= 0.7;
    if ($avg - $fullStars >= 0.8) {
        $fullStars += 1;
        $hasHalf = false;
    }
    $iconSize = match($size) {
        'xs' => 'w-3 h-3',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        default => 'w-4 h-4',
    };
@endphp

<div class="inline-flex items-center gap-1.5">
    <div class="flex items-center text-amber-400 shrink-0">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $fullStars)
                <svg class="{{ $iconSize }} fill-current" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            @elseif ($i == $fullStars + 1 && $hasHalf)
                <svg class="{{ $iconSize }} fill-current" viewBox="0 0 24 24">
                    <path d="M12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28z" opacity="0.3"/>
                    <path d="M12 2v15.27l6.18 3.73-1.64-7.03L22 9.24l-7.19-.61L12 2z"/>
                </svg>
            @else
                <svg class="{{ $iconSize }} text-slate-200 fill-current" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            @endif
        @endfor
    </div>
    @if ($showScore || $avg > 0)
        <span class="text-xs font-bold text-slate-700">{{ $avg > 0 ? number_format($avg, 1) : '0.0' }}</span>
    @endif
    @if ($reviewsCount !== null)
        <span class="text-xs text-slate-400 font-medium">({{ $reviewsCount }})</span>
    @endif
</div>