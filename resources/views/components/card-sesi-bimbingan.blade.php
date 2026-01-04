@props(['sesi', 'highlight' => false])
@php
$namaDokumen = $sesi->nama_dokumen
? $sesi->nama_dokumen
: basename($sesi->file_bimbingan);

if (strlen($namaDokumen) > 18) {
$namaDokumen = substr($namaDokumen, 0, 15).'...';
}
@endphp
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
        $status = $sesi->status_sesi_bimbingan;
        $config_status = array_keys(config('status_sesi_bimbingan'));


        if(!in_array($status, $config_status)) {
        dd("Status id [$status] belum ada di config.");
        }

        if ($status == 1) { // sedang direview
        $badgeClass = 'bg-amber-500';
        } elseif ( 0 == $status ) { // baru diajukan
        $badgeClass = (isRole('dosen') ? 'bg-rose-600' : 'bg-amber-500');
        } elseif ( 0 > $status ) {
        $badgeClass = (isRole('dosen') ? 'bg-amber-500' : 'bg-rose-600');
        }elseif ($status> 1 ) {
        $badgeClass = 'bg-emerald-600';
        } else {
        $badgeClass = 'bg-slate-500';
        }
        $badgeClass .= ' text-white';
        @endphp

        <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
            {{ namaStatusSesiBimbingan($sesi->status_sesi_bimbingan) }}
        </span>
    </div>

    {{-- Info Online/Offline at ... lokasi ... --}}
    @if($sesi->is_offline)
    <div class="text-xs my-3">
        <x-badge type="warning" text="Request Offline" class="mb-2" />

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

        {{-- Ubah UI ke style whatsapp-file --}}
        @if ($sesi->file_bimbingan)
        <div class="flex justify-start">
            <div class="max-w-sm bg-gray-100 dark:bg-gray-800 rounded-lg p-3 shadow">
                <div class="flex items-center gap-3">
                    <div class="text-blue-500 text-2xl">📄</div>

                    <div class="flex-1">
                        <a href="{{ asset('storage/' . $sesi->file_bimbingan) }}" target="_blank"
                            class="font-semibold text-sm text-gray-800 dark:text-gray-100 hover:underline">
                            {{ $namaDokumen }}.docx
                        </a>

                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $sesi->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Pesan Dosen --}}
        @if($sesi->pesan_dosen)
        <x-chat chatter='Dosen' pos='right' text='{{$sesi->pesan_dosen}}' date="{{$sesi->updated_at->format('d M, ') }}"
            time="{{ $sesi->updated_at->format('H:i') }}" />
        @endif

        {{-- Ubah UI ke style whatsapp-file --}}
        @if ($sesi->file_review)
        <div class="flex justify-end">
            <div class="max-w-sm bg-green-100 dark:bg-green-900 rounded-lg p-3 shadow">
                <div class="flex items-center gap-3">
                    <div class="text-green-600 text-2xl">✅</div>

                    <div class="flex-1 text-right">
                        <a href="{{ asset('storage/' . $sesi->file_review) }}" target="_blank"
                            class="font-semibold text-sm text-gray-800 dark:text-gray-100 hover:underline">
                            {{ $namaDokumen }}_reviewed.docx
                        </a>

                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ optional($sesi->tanggal_review)->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Tanggal Review --}}
    @if ($sesi->tanggal_review)
    <p class="mt-2 text-xs text-gray-500 right">
        Direview pada {{ $sesi->tanggal_review->format('d M Y · H:i') }} ✅
    </p>
    @endif

    @if (2>$status)

    @php
    $arrAksi = [];

    /** =========================
    * ROLE: DOSEN
    * ========================= */
    if (isRole('dosen')) {

    if ($status === 0) {
    // baru diajukan → dosen perlu download & review
    $arrAksi = [
    'review' => [
    'label' => '🔍 Review',
    'route' => 'sesi-bimbingan.show',
    'type' => 'danger',
    ],
    ];
    } elseif ($status === 1) {
    // sudah didownload → sedang direview
    $arrAksi = [
    'reviewing' => [
    'label' => '🧐 Lanjut Review',
    'route' => 'sesi-bimbingan.show',
    'type' => 'warning',
    ],
    ];
    } elseif (0 > $status) { // perlu revisi → dosen opsional beri warning $arrAksi=[ 'notif'=> [
    $arrAksi = [
    'reviewing' => [
    'label' => 'Notif Revisi',
    'route' => 'whatsapp.send',
    ],
    ];
    }

    /** =========================
    * ROLE: MAHASISWA
    * ========================= */
    } elseif (isRole('mhs')) {

    if ($status === 0) {
    // sudah submit, menunggu dosen
    $arrAksi = [
    'wait' => [
    'label' => '⏳ Menunggu Review',
    'route' => 'sesi-bimbingan.show',
    'type' => 'warning',
    ],
    ];
    } elseif (1 == $status) {
    $arrAksi = [
    'wait' => [
    'label' => '🔍 Sedang Direview',
    'route' => 'sesi-bimbingan.show',
    'type' => 'warning',
    ],
    ];
    } elseif (0 > $status) { // diminta revisi $arrAksi=[ 'revisi'=> [
    $arrAksi = [
    'reviewing' => [

    'label' => 'Upload Revisi',
    'route' => 'sesi-bimbingan.show',
    'type' => 'danger',

    ],
    ];
    }

    /** =========================
    * ROLE: AKADEMIK
    * ========================= */
    } elseif (isRole('akademik')) {

    // akademik hanya monitoring
    $arrAksi = [
    'monitor' => [
    'label' => 'Lihat Detail',
    'route' => 'sesi-bimbingan.show',
    'type' => 'primary',
    ],
    ];
    }
    @endphp
    <hr class="my-3 border-gray-200 dark:border-gray-700">
    <div class="blok_aksi mt-3 space-y-2">

        {{-- UI links aksi --}}
        @foreach ($arrAksi as $aksi)
        @php $type = $aksi['type'] ?? 'secondary'; @endphp
        <a href="{{ route($aksi['route'], $sesi) }}">
            <x-button type="{{$type}}" class="w-full"> {{ $aksi['label'] }} </x-button>
        </a> @endforeach

    </div>
    @endif
</div>