<div {{ $attributes->merge([
    'class' => '
    font-semibold text-indigo-700
    pb-3 md:pb-4
    border-b
    bg-gray-50
    '
    ]) }}>
    {{ $slot }}
</div>