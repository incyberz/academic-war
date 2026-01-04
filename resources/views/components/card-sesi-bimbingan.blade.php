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

        if ($status == 1) {
        $badgeClass = (isRole('dosen') ? 'bg-rose-600' : 'bg-amber-500') .' text-white';
        } elseif ( 0 > $status ) {
        $badgeClass = (isRole('dosen') ? 'bg-amber-500' : 'bg-rose-600') .' text-white';
        }elseif ($status> 1 ) {
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
    <p class="mt-2 text-xs text-gray-500">
        Direview pada {{ $sesi->tanggal_review->format('d M Y · H:i') }}
    </p>
    @endif

    <hr>

    @if (isRole('dosen'))
    <div class="blok_aksi aksi_dosen flex flex-wrap gap-2 mt-3">

        @php
        $arr_aksi = [];

        // debug
        $arr_aksi = [
        'notif'=> [
        'label'=> 'Send Notif',
        // 'route'=> 'whatsapp.send',
        'route'=> 'sesi-bimbingan.show',
        'param'=> $sesi->id,
        'icon' => '📲',
        'color'=> 'green',
        ],
        ]; // debug

        if ($status == 1) { // perlu review
        $arr_aksi = [
        'review'=> [
        'label'=> 'Download Dokumen',
        'route'=> 'sesi-bimbingan.review',
        'param'=> $sesi->id,
        'icon' => '📥',
        'color'=> 'blue',
        ],
        ];

        } elseif (0 > $status) { // perlu revisi
        $arr_aksi = [
        'notif'=> [
        'label'=> 'Send Notif',
        'route'=> 'whatsapp.send',
        'param'=> $sesi->id,
        'icon' => '📲',
        'color'=> 'green',
        ],
        ];
        }
        // status > 1 atau lainnya → tidak ada aksi
        @endphp

        {{-- UI links aksi untuk dosen --}}
        @forelse ($arr_aksi as $aksi)
        <a href="{{ route($aksi['route'], $aksi['param']) }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold
                  rounded-md shadow
                  bg-{{ $aksi['color'] }}-600 hover:bg-{{ $aksi['color'] }}-700
                  text-white
                  transition">
            <span>{{ $aksi['icon'] }}</span>
            {{ $aksi['label'] }}
        </a>
        @empty
        <span class="text-sm text-gray-500 italic">
            Tidak ada aksi
        </span>
        @endforelse

    </div>
    @endif
</div>