@props([
'pos' => 'left', // left, right
'chatter' => 'undefined chatter',
'text' => 'undefined chat text',
'date' => '',
'time' => 'undefined chat time',
])

@php
$posFlex = ($pos=='left' || $pos=='start') ? 'start' : 'end';
$blue = $posFlex=='start' ? 'blue' : 'green';
@endphp

<div class="flex justify-{{$posFlex}}">
  <div class="max-w-[70%] px-3 py-2 rounded-xl bg-{{$blue}}-100 text-gray-800 shadow
                            dark:bg-{{$blue}}-900/50 dark:text-gray-200">
    <span class="block font-semibold text-xs mb-1">{{$chatter}}</span>
    <p class="text-sm whitespace-pre-line">{{ $text }}</p>
    <span class="block text-xs text-gray-500 dark:text-gray-300 mt-1 text-right">
      {{ $date }} {{ $time }}
    </span>
  </div>
</div>