@props([
'label' => 'Progress',
'value' => 0,
'color' => 'indigo',
'info' => null,
'animated' => false,
])

@php
$value = max(0, min(100, (int) $value));

// Jika selesai 100%
if ($value === 100) {
$animated = false;
$info = 'Completed ✅';
} else {
$info ??= $value . '% selesai';
}

$barClass = collect([
'h-3',
'rounded-full',
"bg-{$color}-600",
'transition-all',
'duration-300',
$animated ? 'progress-striped progress-animated' : null,
])->filter()->implode(' ');
@endphp

<style>
    @keyframes progress-bar-stripes {
        0% {
            background-position-x: 1rem;
        }

        100% {
            background-position-x: 0;
        }
    }

    .progress-striped {
        background-image: linear-gradient(45deg,
                rgba(255, 255, 255, .15) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, .15) 50%,
                rgba(255, 255, 255, .15) 75%,
                transparent 75%,
                transparent);
        background-size: 1rem 1rem;
    }

    .progress-animated {
        animation: progress-bar-stripes 1s linear infinite;
    }
</style>

<div {{ $attributes->merge([
    'class' => 'p-4 rounded-lg border bg-white dark:bg-slate-800 border-gray-200 dark:border-gray-700'
    ]) }}>
    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
    </p>

    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
        <div class="{{ $barClass }}" style="width: {{ $value }}%">
        </div>
    </div>

    <p class="text-xs text-gray-500 mt-1">
        {{ $info }}
    </p>
</div>