<div {{ $attributes->merge([
    'class' => '
    bg-white
    text-gray-800
    rounded-lg md:rounded-xl
    shadow-sm md:shadow
    p-3 md:p-4 lg:p-5
    flex flex-col justify-between
    transition
    hover:shadow-md
    '
    ]) }}>
    {{ $slot }}
</div>