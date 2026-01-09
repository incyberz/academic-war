@props([
'peserta',
'isTelat' => false,
'isKritis' => false,
])

@php
/**
* Normalisasi data (single source of truth)
*/
$avatar = $peserta->mahasiswa->user->avatar ?? null;
$wa = $peserta->mahasiswa->user->avatar ?? null;
$nama = $peserta->mahasiswa->nama_lengkap ?? '-';
$nim = $peserta->mahasiswa->nim ?? '-';
$progress = $peserta->progress ?? 0;
$status = $peserta->status ?? 1; // default aktif
$status = namaStatusPesertaBimbingan($status);
$id = $peserta->id ?? 0;
$tahun_ajar = $peserta->tahun_ajar ?? session('tahun_ajar_id');

$terakhir_topik = $peserta->terakhir_topik ?? null;
$terakhir_bimbingan = $peserta->terakhir_bimbingan ?? null;
$terakhir_reviewed = $peserta->terakhir_reviewed ?? null;

$total_sesi_count = $peserta->total_sesi;
$perlu_review_count = $peserta->perlu_review;
$perlu_revisi_count = $peserta->perlu_revisi;
$disetujui_count = $peserta->disetujui;

$revisiCount = $peserta->revisiCount();
$reviewCount = $peserta->reviewCount();

// dd($peserta->total_sesi, $nama, $avatar);
$isBelumBimbingan = $total_sesi_count ? 0 : 1;

/**
* Styling logic
*/
$cardBgRed = 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800 hover:bg-red-100
dark:hover:bg-red-900/30';
$cardBgYellow = 'bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800 hover:bg-yellow-100
dark:hover:bg-yellow-900/30';
$cardBgNormal = 'bg-white dark:bg-slate-800 border-gray-200 dark:border-gray-700 hover:bg-gray-50
dark:hover:bg-gray-800';

if ($isBelumBimbingan || $isKritis) {
$cardBgClass = $cardBgRed;
} elseif ($isTelat) {
$cardBgClass = $cardBgYellow;
} else {
$cardBgClass = $cardBgNormal;
}
@endphp







<div {{ $attributes->merge([
    'class' => "flex items-center p-2 md:p-3 rounded-lg border transition gap-3 $cardBgClass"
    ]) }}>

    {{-- Avatar --}}
    <img src="{{ $avatar ? asset('storage/'.$avatar) : asset('img/roles/mhs.png') }}" alt="{{ $nama }}"
        class="w-12 h-12 rounded-full border border-gray-300 dark:border-gray-600 object-cover">

    <div class="flex-1">

        {{-- Header --}}
        <div class="flex items-center justify-between gap-2">
            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                {{ $nama }}
            </span>

            <span class="text-[11px] px-2 py-0 rounded-md
                         bg-indigo-100 text-indigo-700
                         dark:bg-indigo-900/40 dark:text-indigo-300">
                {{ $tahun_ajar }}
            </span>
        </div>

        {{-- Progress --}}
        <div class="my-1">
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="h-2 rounded-full bg-indigo-600 dark:bg-indigo-500" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $progress }}% completed
            </p>
        </div>

        {{-- Konten --}}
        <div class="mt-2 space-y-1 text-xs text-gray-500 dark:text-gray-400">

            @if($isBelumBimbingan)
            <span class="inline-block text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/40 px-2 py-1 rounded">
                ⚠️ Belum Bimbingan
            </span>
            @else
            <p class="truncate">📝 <span class="font-medium">{{ $terakhir_topik }}</span></p>

            @if ($isKritis)
            <span class="inline-block text-red-700 bg-red-100 dark:bg-red-900/40 px-2 py-1 rounded">
                ⚠️ Kritis Bimbingan
            </span>
            @elseif ($isTelat)
            <span class="inline-block text-yellow-700 bg-yellow-100 dark:bg-yellow-900/40 px-2 py-1 rounded">
                ⏰ Telat Bimbingan
            </span>
            @endif

            <p>👨‍🎓 Bimbingan:
                <span class="font-medium">
                    {{ $terakhir_bimbingan ? \Carbon\Carbon::parse($terakhir_bimbingan)->diffForHumans() : 'Belum ada'
                    }}
                </span>
            </p>

            <p>👨‍🏫 Review:
                <span class="font-medium">
                    {{ $terakhir_reviewed ? \Carbon\Carbon::parse($terakhir_reviewed)->diffForHumans() : 'Belum
                    direview' }}
                </span>
            </p>
            @endif

            {{-- Status --}}
            <div class="mt-2">
                <span class="text-xs px-2 py-1 rounded
                    {{ $status === 'Selesai' ? 'text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-300'
                       : ($status === 'Hari Ini'
                           ? 'text-indigo-600 bg-indigo-100 dark:bg-indigo-900/30'
                           : 'text-yellow-600 bg-yellow-100 dark:bg-yellow-900/30') }}">
                    {{ $status }}
                </span>

                <div class="inline-flex items-center gap-1">
                    @if($reviewCount > 0)
                    <span class="inline-flex items-center justify-center 
                     min-w-[1.25rem] h-5 px-1 
                     text-xs font-semibold text-white
                     bg-rose-500 rounded-full">
                        {{ $reviewCount }}
                    </span>
                    @endif

                    @if($revisiCount > 0)
                    <span class="inline-flex items-center justify-center 
                     min-w-[1.25rem] h-5 px-1 
                     text-xs font-semibold text-white
                     bg-amber-500 rounded-full">
                        {{ $revisiCount }}
                    </span>
                    @endif
                </div>

                <a href="{{ route('peserta-bimbingan.show', $id) }}"
                    class="ml-2 text-sm font-medium text-indigo-600 hover:underline">
                    Detail →
                </a>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col items-center gap-2">
        <a href="https://wa.me/{{ $wa }}" target="_blank" title="WhatsApp">
            @include('components.whatsapp-icon')
        </a>

        @if ($status !== 'Selesai')
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="text-red-600">
            @include('components.whatsapp-icon')
        </a>
        @endif

        <form action="{{ route('peserta-bimbingan.destroy', $id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus peserta bimbingan ini?')">
            @csrf @method('DELETE')
            <button type="submit">@include('components.trash-icon')</button>
        </form>
    </div>
</div>