@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge([
    'class' => 'w-full my-1
    rounded-md shadow-sm
    border border-gray-300 dark:border-slate-600
    bg-white dark:bg-slate-800
    text-gray-900 dark:text-slate-100
    placeholder-gray-400 dark:placeholder-slate-400

    focus:outline-none
    focus:border-indigo-500 dark:focus:border-indigo-400
    focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400

    disabled:bg-gray-100 dark:disabled:bg-slate-700
    disabled:text-gray-400 dark:disabled:text-slate-400
    disabled:cursor-not-allowed

    transition
    '
    ]) }}
    >{{$slot}}</select>