@props([
'avatar',
'nama',
'progress' => 0,
'tanggal',
'topik',
'status',
'wa',
])

<div {{ $attributes->merge([
    'class' => '
    flex items-center p-2 md:p-3
    rounded-lg
    border border-gray-200 dark:border-gray-700
    hover:bg-gray-50 dark:hover:bg-gray-800
    transition
    gap-3
    '
    ]) }}
    >
    {{-- Avatar --}}
    <img src="{{ $avatar
            ? asset('storage/' . $avatar)
            : asset('img/roles/mhs.png') }}" alt="{{ $nama }}" class="w-12 h-12 rounded-full
             border border-gray-300 dark:border-gray-600
             object-cover">

    {{-- Info --}}
    <div class="flex-1">
        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
            {{ $nama }}
        </p>

        {{-- Progress --}}
        <div class="my-1">
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="h-2 rounded-full bg-indigo-600 dark:bg-indigo-500" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $progress }}% completed
            </p>
        </div>

        <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ \Carbon\Carbon::parse($tanggal)->format('l, d M Y H:i') }}
            {{ $topik ? " • $topik " : '' }}
        </p>

        {{-- Status --}}
        <div class="mt-2">
            @if ($status === 'Selesai')
            <span class="text-green-600 text-xs px-2 py-1 rounded
                             bg-green-100 dark:bg-green-900
                             dark:text-green-300">
                Selesai
            </span>
            @elseif ($status === 'Hari Ini')
            <span class="text-indigo-600 text-xs px-2 py-1 rounded
                             bg-indigo-100 dark:bg-indigo-900/30">
                Hari Ini
            </span>
            @else
            <span class="text-yellow-600 text-xs px-2 py-1 rounded
                             bg-yellow-100 dark:bg-yellow-900/30">
                {{ $status }}
            </span>
            @endif
        </div>
    </div>

    {{-- Action --}}
    <div class="flex flex-col items-center gap-2">
        {{-- WhatsApp Reminder --}}
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="text-green-600 hover:text-green-700 transition"
            title="WhatsApp Reminder">
            @include('components.whatsapp-icon')
        </a>

        {{-- WhatsApp Cancel --}}
        @if ($status !== 'Selesai')
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="text-red-600 hover:text-red-700 transition"
            title="Batalkan Bimbingan">
            @include('components.whatsapp-icon')
        </a>
        @endif
    </div>
</div>