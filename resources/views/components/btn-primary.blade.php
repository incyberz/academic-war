<div {{ $attributes->merge([
  'class' => 'w-full md:w-auto inline-flex items-center justify-center gap-2
  px-4 py-2 rounded-lg
  bg-indigo-600 text-white
  font-semibold text-sm
  hover:bg-indigo-700
  active:bg-indigo-800
  focus:outline-none focus:ring-2 focus:ring-indigo-400
  transition'
  ]) }}>
  {{ $slot }}
</div>