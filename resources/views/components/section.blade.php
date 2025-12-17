<section {{ $attributes->merge([
    'class' => 'bg-white dark:bg-gray-800 shadow-sm rounded-lg py-6 px-2 md:px-4 lg:px-6 text-gray-900
    dark:text-gray-100'
    ]) }}>
    {{ $slot }}
</section>