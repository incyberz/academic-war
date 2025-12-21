<div {{ $attributes->merge([
  'class' => 'w-full md:w-auto inline-flex items-center justify-center gap-2
  px-4 py-2 rounded-lg
  bg-red-600 text-white
  font-semibold text-sm
  border border-red-700
  hover:bg-red-700
  active:bg-red-800
  focus:outline-none focus:ring-2 focus:ring-red-400
  transition'
  ]) }}>
  {{ $slot }}
</div>