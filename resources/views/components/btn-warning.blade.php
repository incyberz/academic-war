<x-button {{ $attributes->merge([
    'class' => '
    text-white
    bg-amber-500
    hover:bg-amber-600
    focus:ring-amber-400

    dark:text-white
    dark:bg-yellow-500
    dark:hover:bg-yellow-600
    dark:focus:ring-yellow-400
    '
    ]) }}
    >
    {{ $slot }}
</x-button>