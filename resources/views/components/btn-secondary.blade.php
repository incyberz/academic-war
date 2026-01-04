<x-button {{ $attributes->merge([
  'class' => '
  text-indigo-700
  bg-indigo-100
  border border-indigo-200
  hover:bg-indigo-200
  focus:ring-indigo-400

  dark:text-indigo-200
  dark:bg-slate-700
  dark:border-slate-600
  dark:hover:bg-slate-600
  dark:focus:ring-indigo-500
  '
  ]) }}
  >
  {{ $slot }}
</x-button>