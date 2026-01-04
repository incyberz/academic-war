<span {{ $attributes->merge([
    'class' => '
    inline-flex items-center gap-2
    px-3 py-2
    rounded-md
    border border-gray-300 dark:border-gray-600

    bg-gray-100 text-gray-700
    hover:bg-gray-200 hover:text-gray-900

    dark:bg-gray-800 dark:text-gray-300
    dark:hover:bg-gray-700 dark:hover:text-white

    text-sm font-medium
    tracking-wide

    focus:outline-none
    focus:ring-2 focus:ring-gray-400
    dark:focus:ring-gray-600

    transition-all duration-150 ease-in-out
    '
    ]) }}>
    {{ $slot }}
</span>