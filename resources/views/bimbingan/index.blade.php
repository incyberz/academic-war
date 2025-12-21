<x-app-layout>
  <div class="max-w-7xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">
          Bimbingan Saya
        </h1>
        <p class="text-sm text-gray-600">
          Daftar bimbingan yang Anda kelola sebagai dosen
        </p>
      </div>

      <a href="{{ route('jenis-bimbingan.index') }}">
        <x-btn-add>
          Tambah Bimbingan
        </x-btn-add>
      </a>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      @forelse ($bimbingan as $item)
      <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between p-3">

        {{-- TOP --}}
        <div class="space-y-2">
          <h2 class="text-lg font-semibold text-indigo-700">
            {{ $item->jenisBimbingan->nama ?? '-' }}
          </h2>

          <p class="text-sm text-gray-600">
            Tahun Ajar: <span class="font-medium">{{ $item->tahun_ajar_id }}</span>
          </p>

          {{-- STATUS --}}
          <span class="inline-block text-xs px-2 py-1 rounded
            {{ $item->status === 'aktif'
                ? 'bg-green-100 text-green-700'
                : 'bg-gray-200 text-gray-600' }}">
            {{ ucfirst($item->status) }}
          </span>
        </div>

        {{-- MIDDLE --}}
        <div class="mt-4 space-y-2 text-sm text-gray-700">

          {{-- HARI AVAILABLE --}}
          <div>
            <span class="font-medium">Hari Tersedia:</span>
            <div class="mt-1 flex flex-wrap gap-1">
              @foreach (($item->hari_availables ?? []) as $hari)
              <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs">
                {{ $hari }}
              </span>
              @endforeach
            </div>
          </div>

          {{-- WAG --}}
          @if ($item->wag)
          <div>
            <span class="font-medium">WAG:</span>
            <a href="{{ $item->wag }}" target="_blank" class="text-indigo-600 hover:underline text-xs block truncate">
              {{ $item->wag }}
            </a>
          </div>
          @endif

          {{-- AKHIR MASA --}}
          @if ($item->akhir_masa_bimbingan)
          <div>
            <span class="font-medium">Akhir Masa:</span>
            {{ \Carbon\Carbon::parse($item->akhir_masa_bimbingan)->format('d M Y') }}
          </div>
          @endif

          {{-- CATATAN --}}
          @if ($item->catatan)
          <div class="text-xs text-gray-500 italic">
            "{{ $item->catatan }}"
          </div>
          @endif
        </div>

        {{-- FOOTER --}}
        <div class="mt-5 flex flex-wrap gap-2">
          <a href="#">
            <x-btn-primary class="text-xs px-3 py-1">
              Peserta
            </x-btn-primary>
          </a>

          <a href="{{ route('bimbingan.edit', $item->id) }}">
            <x-btn-secondary class="text-xs px-3 py-1">
              Edit
            </x-btn-secondary>
          </a>

          @if ($item->status === 'aktif')
          <form action="#" method="POST" onsubmit="return confirm('Nonaktifkan bimbingan ini?')">
            @csrf
            @method('PATCH')
            <x-btn-danger class="text-xs px-3 py-1">
              Arsipkan
            </x-btn-danger>
          </form>
          @endif
        </div>

      </div>
      @empty
      <div class="col-span-full text-center text-gray-500 py-12">
        Anda belum memiliki bimbingan.
      </div>
      @endforelse

    </div>
  </div>
</x-app-layout>