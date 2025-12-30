@props(['sesi', 'highlight' => false])

<div class="p-4 rounded-lg border
  {{ $highlight
      ? 'border-red-300 bg-red-50 dark:bg-red-950/30'
      : 'border-gray-200 bg-white dark:bg-slate-800' }}">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm text-gray-500">
            {{ $sesi->created_at->format('d M Y · H:i') }}
        </span>

        @if ($sesi->status)
        @php
        $statusId = $sesi->status_sesi_bimbingan_id;

        if ($statusId == 1) {
        $badgeClass = 'bg-rose-600 text-white';
        } elseif (in_array($statusId, [-1, -2])) {
        $badgeClass = 'bg-amber-500 text-white';
        } elseif (in_array($statusId, [2, 3, 4])) {
        $badgeClass = 'bg-emerald-600 text-white';
        } else {
        $badgeClass = 'bg-slate-500 text-white';
        }
        @endphp

        <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
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