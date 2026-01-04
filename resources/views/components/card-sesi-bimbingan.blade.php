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

        @php
        $statusId = $sesi->status_sesi_bimbingan;
        $config_status = array_keys(config('status_sesi_bimbingan'));


        if(!in_array($statusId, $config_status)) {
        dd("Status id [$statusId] belum ada di config.");
        }

        if ($statusId == 1) {
        $badgeClass = (isRole('dosen') ? 'bg-rose-600' : 'bg-amber-500') .' text-white';
        } elseif ( 0 > $statusId ) {
        $badgeClass = (isRole('dosen') ? 'bg-amber-500' : 'bg-rose-600') .' text-white';
        }elseif ($statusId> 1 ) {
        $badgeClass = 'bg-emerald-600 text-white';
        } else {
        $badgeClass = 'bg-slate-500 text-white';
        }
        @endphp

        <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
            {{ namaStatusSesiBimbingan($sesi->status_sesi_bimbingan) }}
        </span>
    </div>

    {{-- Info Online/Offline at ... lokasi ... --}}
    @if($sesi->is_offline)
    <div class="text-xs my-3">
        <x-badge type="warning" text="Offline" class="mb-2" />

        <div class="flex flex-col gap-0">
            <div>
                <strong>Tanggal:</strong> {{ $sesi->tanggal_offline ?
                \Carbon\Carbon::parse($sesi->tanggal_offline)->format('d M Y') :
                '-' }}
            </div>
            <div>
                <strong>Jam:</strong> {{ \Carbon\Carbon::parse($sesi->jam_offline)->format('H:i') }}
            </div>
            <div>
                <strong>Lokasi:</strong> {{ $sesi->lokasi_offline ?? '-' }}
            </div>
        </div>
    </div>
    @else
    <div class="flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 mb-3">
        <x-badge type="info" text="Bimbingan Online" />
    </div>
    @endif

    <div class="space-y-2 mb-4">
        {{-- Pesan Mhs --}}
        <x-chat chatter='Mhs' pos='left' text='{{$sesi->pesan_mhs}}' date="{{$sesi->created_at->format('d M, ') }}"
            time="{{ $sesi->created_at->format('H:i') }}" />

        @if ($sesi->file_bimbingan)
        <a href="{{ asset('storage/' . $sesi->file_bimbingan) }}" target="_blank" class="text-blue-600 hover:underline">
            📄 File Mahasiswa
        </a>
        @endif

        {{-- Pesan Dosen --}}
        @if($sesi->pesan_dosen)
        <x-chat chatter='Dosen' pos='right' text='{{$sesi->pesan_dosen}}' date="{{$sesi->updated_at->format('d M, ') }}"
            time="{{ $sesi->updated_at->format('H:i') }}" />
        @endif
    </div>

    {{-- File --}}
    <div class="flex flex-wrap gap-4 text-sm mt-3">

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