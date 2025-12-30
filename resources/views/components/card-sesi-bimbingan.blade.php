@props(['sesi'])

<div class="p-4 rounded-lg border
            bg-white dark:bg-slate-800
            border-gray-200 dark:border-gray-700">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm text-gray-500">
            {{ $sesi->created_at->format('d M Y · H:i') }}
        </span>

        @if ($sesi->status)
        <span class="px-2 py-1 rounded text-xs font-medium {{ $sesi->status->badge_class }}">
            {{ $sesi->status->nama_status }}
        </span>
        @endif
    </div>

    {{-- Pesan Mahasiswa --}}
    @if ($sesi->pesan_mhs)
    <div class="mb-2">
        <p class="text-sm text-gray-700 dark:text-gray-200">
            <span class="font-semibold">Mahasiswa:</span>
            {{ $sesi->pesan_mhs }}
        </p>
    </div>
    @endif

    {{-- Pesan Dosen --}}
    @if ($sesi->pesan_dosen)
    <div class="mb-2">
        <p class="text-sm text-gray-700 dark:text-gray-200">
            <span class="font-semibold">Dosen:</span>
            {{ $sesi->pesan_dosen }}
        </p>
    </div>
    @endif

    {{-- File --}}
    <div class="flex flex-wrap gap-4 text-sm mt-3">
        @if ($sesi->file_bimbingan)
        <a href="{{ asset('storage/' . $sesi->file_bimbingan) }}" target="_blank" class="text-blue-600 hover:underline">
            📄 File Mahasiswa
        </a>
        @endif

        @if ($sesi->file_review)
        <a href="{{ asset('storage/' . $sesi->file_review) }}" target="_blank" class="text-green-600 hover:underline">
            ✅ File Review Dosen
        </a>
        @endif
    </div>

    {{-- Tanggal Review --}}
    @if ($sesi->tanggal_review)
    <p class="mt-2 text-xs text-gray-500">
        Direview pada {{ $sesi->tanggal_review->format('d M Y · H:i') }}
    </p>
    @endif
</div>