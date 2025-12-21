<div {{ $attributes->merge([
    'class' => '
    bg-white dark:bg-slate-800
    text-gray-800 dark:text-slate-100
    rounded-lg md:rounded-xl
    shadow-sm md:shadow
    dark:shadow-none
    flex flex-col
    transition
    hover:shadow-md dark:hover:shadow-slate-900/50
    border border-transparent dark:border-slate-700
    '
    ]) }}>
    {{ $slot }}
</div>