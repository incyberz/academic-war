<div {{ $attributes->merge([
    'class' => 'w-full md:w-auto inline-flex items-center gap-2 px-4 py-2 mt-4
    bg-emerald-600 text-white text-sm font-medium
    rounded-md hover:bg-emerald-700 transition'
    ]) }}>
    ➕ {{ $slot }}
</div>