@props([
'avatar',
'nama',
'progress' => 0,
'terakhir_topik'=>null,
'terakhir_bimbingan'=>null,
'terakhir_reviewed'=>null,
'status'=>null,
'wa'=>null,
'isTelatBimbingan'=>false,
'isKritisBimbingan'=>false,
])


@php
$isBelumBimbingan = empty($terakhir_topik);
$cardBgRed = 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800 hover:bg-red-100
dark:hover:bg-red-900/30';
$cardBgYellow = 'bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800 hover:bg-yellow-100
dark:hover:bg-yellow-900/30';
$cardBgNormal = 'bg-white dark:bg-slate-800 border-gray-200 dark:border-gray-700 hover:bg-gray-50
dark:hover:bg-gray-800';

if($isBelumBimbingan) {
$cardBgClass = $cardBgRed;
} elseif ($isKritisBimbingan) {
$cardBgClass = $cardBgRed;
} elseif ($isTelatBimbingan) {
$cardBgClass = $cardBgYellow;
} else {
$cardBgClass = $cardBgNormal;
}

@endphp

<div {{ $attributes->merge([
    'class' => '
    flex items-center p-2 md:p-3
    rounded-lg
    border
    transition
    gap-3
    ' .
    $cardBgClass
    ]) }}>
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

        {{-- Terakhir Update --}}
        <div class="mt-2 space-y-0.5 text-xs text-gray-500 dark:text-gray-400">

            @if(!$terakhir_topik)
            <p class="truncate">
                <span class="inline-block text-xs text-red-700 dark:text-red-300
                                 bg-red-100 dark:bg-red-900/40
                                 px-2 pt-1 pb-1.5 rounded">
                    ⚠️ Belum Bimbingan
                </span>
            </p> @else
            {{-- Topik terakhir --}}
            <p class="truncate">
                📝 <span class="font-medium text-gray-600 dark:text-gray-300 py-1">
                    {{ $terakhir_topik }}
                </span>
            </p>

            {{-- Kritis | Telat Bimbingan --}}
            @if ($isKritisBimbingan)
            <p class="truncate">
                <span class="inline-block text-xs text-red-700 dark:text-red-300
                                                 bg-red-100 dark:bg-red-900/40
                                                 px-2 pt-1 pb-1.5 rounded">
                    ⚠️ Kritis Bimbingan
                </span>
            </p>
            @elseif ($isTelatBimbingan)
            <p class="truncate">
                <span class="inline-block text-xs text-yellow-700 dark:text-yellow-300
                                 bg-yellow-100 dark:bg-yellow-900/40
                                 px-2 pt-1 pb-1.5 rounded">
                    ⏰ Telat Bimbingan
                </span>
            </p>
            @endif

            {{-- Terakhir bimbingan --}}
            <p>
                👨‍🎓 Bimbingan:
                <span class="font-medium">
                    {{ $terakhir_bimbingan
                    ? \Carbon\Carbon::parse($terakhir_bimbingan)->diffForHumans()
                    : 'Belum ada' }}
                </span>
            </p>

            {{-- Terakhir direview --}}
            <p>
                👨‍🏫 Review:
                <span class="font-medium">
                    {{ $terakhir_reviewed
                    ? \Carbon\Carbon::parse($terakhir_reviewed)->diffForHumans()
                    : 'Belum direview' }}
                </span>
            </p>
            @endif


        </div>



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