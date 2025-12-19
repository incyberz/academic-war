<div {{ $attributes->merge([
    'class' => 'p-3 rounded-lg
    border border-gray-200 dark:border-gray-700
    hover:bg-gray-50 dark:hover:bg-gray-800 transition
    bg-red-50 dark:bg-red-900/30 text-sm text-gray-600 dark:text-gray-400 mb-2 italic'
    ]) }}>
    {{ $slot }}
</div>