<div {{ $attributes->merge([
    'class' => '
    font-semibold
    text-indigo-700 dark:text-indigo-400
    px-3 md:px-4 lg:px-5
    py-2.5 md:py-3
    border-b border-gray-200 dark:border-slate-700
    bg-gray-50 dark:bg-slate-700/40
    '
    ]) }}>
    {{ $slot }}
</div>