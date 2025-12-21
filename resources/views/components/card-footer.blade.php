<div {{ $attributes->merge([
    'class' => '
    pt-3
    border-t
    bg-gray-50
    flex flex-col md:flex-row
    gap-2
    justify-end
    '
    ]) }}>
    {{ $slot }}
</div>