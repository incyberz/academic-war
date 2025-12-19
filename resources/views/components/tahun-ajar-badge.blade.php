@php $ta = session('tahun_ajar_id'); @endphp

@if ($ta)
<div class="fixed top-20 right-4 z-50 group">

    {{-- Badge --}}
    <div class="bg-indigo-600 text-white px-3 py-1 rounded-full shadow-lg
                text-xs font-semibold flex items-center gap-2 cursor-pointer">

        <span class="opacity-80">TA</span>
        <span>{{ $ta }}</span>

        <svg class="w-3 h-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    {{-- Dropdown --}}
    <div class="absolute right-0 mt-2 w-36 bg-white text-gray-700
                rounded-lg shadow-xl text-xs overflow-hidden
                opacity-0 scale-95
                group-hover:opacity-100 group-hover:scale-100
                transition">

        <div class="px-3 py-2 text-[10px] text-gray-500 uppercase">
            Pilih Tahun Ajar
        </div>

        @foreach ($listTahunAjar as $item)
        <a href="{{ route('tahun-ajar.set', $item->id) }}" class="block px-3 py-2 hover:bg-indigo-50
                      {{ $ta == $item->id ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">

            TA {{ $item->id }}

            @if ($item->aktif)
            <span class="text-[10px] ml-1 text-green-600">(Aktif)</span>
            @endif
        </a>
        @endforeach
    </div>

</div>
@endif