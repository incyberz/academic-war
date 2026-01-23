@php
$ta = session('tahun_ajar_id');
@endphp

@if ($ta)
<div x-data="{ open: false }" @click.outside="open = false" class="fixed bottom-4 left-4 z-50">

    {{-- Trigger --}}
    <button @click="open = !open" type="button" class="bg-indigo-600 text-white px-3 py-1 rounded-full shadow-lg
               text-xs font-semibold flex items-center gap-2">
        <span class="opacity-80">TA</span>
        <span>{{ session('tahun_ajar_id') }}</span>

        <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Dropdown --}}
    <div x-cloak x-show="open" x-transition:enter="transition transform duration-300 ease-out"
        x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0" class="absolute bottom-full left-0 mb-2 w-36
               bg-white dark:bg-gray-800
               text-gray-700 dark:text-gray-200
               rounded-lg shadow-xl text-xs overflow-hidden">

        <div class="px-3 py-2 text-[10px] text-gray-500 dark:text-gray-400 uppercase">
            Pilih Tahun Ajar
        </div>

        @foreach ($listTahunAjar as $item)
        <a href="{{ route('tahun-ajar.set', $item->id) }}"
            class="block px-3 py-2 hover:bg-indigo-50 dark:hover:bg-gray-700
                   {{ session('tahun_ajar_id') == $item->id ? 'bg-indigo-100 font-semibold dark:bg-indigo-900' : '' }}">
            TA {{ $item->id }}
        </a>
        @endforeach

    </div>
</div>
@endif