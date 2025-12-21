<div {{ $attributes->merge([
    'class' => '
    px-3 md:px-4 lg:px-5
    py-3 md:py-4
    flex-1
    space-y-3
    text-sm md:text-base
    '
    ]) }}>
    {{ $slot }}
</div>