@props([
'type' => 'text',
'error' => null,
])

<input type="{{ $type }}" {{ $attributes->merge([
'class' => '
w-full rounded-lg my-1
bg-white dark:bg-slate-800
text-gray-900 dark:text-gray-100
border
' . ($error
? 'border-red-500 dark:border-red-400'
: 'border-gray-300 dark:border-slate-600') . '
placeholder-gray-400 dark:placeholder-slate-400
focus:outline-none
focus:ring-2
' . ($error
? 'focus:ring-red-500 dark:focus:ring-red-400'
: 'focus:ring-indigo-500 dark:focus:ring-indigo-400') . '
focus:border-transparent
disabled:bg-gray-100 dark:disabled:bg-slate-700
disabled:text-gray-400 dark:disabled:text-slate-400
disabled:cursor-not-allowed
transition
'
]) }}
>