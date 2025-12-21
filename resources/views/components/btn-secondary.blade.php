<div {{ $attributes->merge([
  'class' => 'w-full md:w-auto inline-flex items-center justify-center gap-2
  px-4 py-2 rounded-lg
  bg-gray-100 text-gray-800
  font-semibold text-sm
  border border-gray-300
  hover:bg-gray-200
  active:bg-gray-300
  focus:outline-none focus:ring-2 focus:ring-gray-400
  transition'
  ]) }}>
  {{ $slot }}
</div>