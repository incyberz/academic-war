<x-button {{ $attributes->merge([
  'class' => '
  text-white
  bg-indigo-500
  hover:bg-indigo-700
  focus:ring-indigo-500

  dark:text-white
  dark:bg-indigo-600
  dark:hover:bg-indigo-700
  dark:focus:ring-indigo-500
  '
  ]) }}
  >
  {{ $slot }}
</x-button>