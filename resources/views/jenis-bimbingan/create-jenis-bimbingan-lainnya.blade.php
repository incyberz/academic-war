<hr class="my-8">

<button type="button" id="toggle-create-jenis" class="inline-flex items-center justify-between gap-2
           w-full px-4 py-2 mb-6
           text-base font-semibold
           border border-gray-300 rounded-lg
           text-gray-700
           hover:bg-gray-100 transition
           focus:outline-none
           dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">

  <span>Create Jenis Bimbingan Lainnya</span>

  <span id="toggle-icon" class="text-lg transition-transform duration-200">
    ⬇️
  </span>
</button>


<div id="create-jenis-wrapper" class="hidden">

  {{-- UI khusus role dosen --}}
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($jenisBimbingan as $jenis)

    @php if(isset($myBimMap[$jenis->id])) continue; @endphp

    <x-card>

      {{-- HEADER --}}
      <x-card-header>
        <h2 class="text-base md:text-lg font-semibold">
          {{ $jenis->nama }}
        </h2>
      </x-card-header>

      {{-- BODY --}}
      <x-card-body>
        <p class="text-sm text-gray-600 mt-1">
          {{ $jenis->deskripsi ?? '' }}
        </p>
      </x-card-body>

      {{-- FOOTER --}}
      <x-card-footer style="display: block">

        @if ($jenis->status == 1)

        <div>
          @if (!$jenis->jumlah_bab_laporan)
          <x-alert type="warning">
            Tidak bisa Tambah Jenis Bimbingan ini
            <div class="text-xs">
              <i>
                Setting Bab Laporan belum siap.
              </i>
            </div>
          </x-alert>
          @else
          <a onclick="return confirm('Tambah Jenis Bimbingan ini?')"
            href="{{ route('bimbingan.create', ['jenis_bimbingan_id' => $jenis->id]) }}">
            <x-button class="w-full">
              Tambah Jenis Bimbingan Ini
            </x-button>
          </a>
          @endif
        </div>

        @else

        <x-btn-secondary class="w-full cursor-not-allowed opacity-60" disabled>
          Bimbingan ini tidak aktif
        </x-btn-secondary>

        @endif

      </x-card-footer>

    </x-card>

    @endforeach

  </div>
</div>


<script>
  $(document).ready(function () {

    $('#toggle-create-jenis').on('click', function () {

        $('#create-jenis-wrapper').slideToggle(200);

        $('#toggle-icon').toggleClass('rotate-180');
    });

});
</script>