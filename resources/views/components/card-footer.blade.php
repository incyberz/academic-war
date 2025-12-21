<div {{ $attributes->merge([
    'class' => '
    px-3 md:px-4 lg:px-5
    py-2.5 md:py-3
    border-t border-gray-200 dark:border-slate-700
    bg-gray-50 dark:bg-slate-700/40
    flex flex-col md:flex-row
    gap-2
    justify-end
    '
    ]) }}>
    {{ $slot }}
</div>