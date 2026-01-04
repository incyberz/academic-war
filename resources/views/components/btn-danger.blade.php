<x-button {{ $attributes->merge([
  'class' => '
  text-white
  bg-rose-600
  hover:bg-rose-700
  focus:ring-rose-500

  dark:text-white
  dark:bg-red-600
  dark:hover:bg-red-700
  dark:focus:ring-red-500
  '
  ]) }}
  >
  {{ $slot }}
</x-button>