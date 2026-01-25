<section>
  <header class="mb-6">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Update Alamat') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Untuk kebutuhan Kurir Akademik, statistik, dan fitur gamifikasi My Neighboor.') }}
    </p>
  </header>

  @if ($user->kec_id)
  <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg text-sm">
    <div class="font-medium text-gray-700 dark:text-gray-200 mb-1">
      Alamat Anda saat ini
    </div>
    <div class="text-gray-600 dark:text-gray-400">
      {{ $user->alamat_lengkap }},
      KEC {{ $user->kec->nama_kec }},
      {{ $user->kec->nama_kab }}
    </div>
  </div>
  @endif



  <form method="post" action="{{ route('user.update-alamat') }}" class="space-y-6">
    @csrf
    @method('put')

    {{-- Kecamatan --}}
    <div>
      <x-label for="kec_id">Pilih Kecamatan</x-label>
      <x-select required name="kec_id" id="kec_id" class="mt-1 w-full">
        <option value="">-- Pilih Kecamatan --</option>

        @foreach ($kecs as $kec)
        <option value="{{ $kec->id }}" @selected(old('kec_id', $user->kec_id ?? null) == $kec->id)>
          Kec. {{ $kec->nama_kec }} – {{ $kec->nama_kab }}
        </option>
        @endforeach

        <option value="new" @selected(old('kec_id')==='new' )>
          -- Kecamatan Baru --
        </option>
      </x-select>
      <p class="text-xs text-gray-500 mt-1">
        Tidak menemukan kecamatan Anda? Pilih <b>Kecamatan Baru</b>
      </p>
    </div>

    {{-- Blok Kecamatan Baru --}}
    <div id="blok_kec_baru" class="hidden space-y-4 mt-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
      <div class="font-medium text-sm text-gray-700 dark:text-gray-200">
        Tambah Kecamatan Baru
      </div>
      <div>
        <x-label>Kecamatan Baru Anda</x-label>
        <x-input id="kec_baru" name="kec_baru" class="mt-1 w-full" />
        <p class="text-xs text-gray-500 mt-1">* input kecamatan baru membutuhkan verifikasi dari admin akademik</p>
      </div>

      <div>
        <x-label>Kode Kecamatan Baru (opsional)</x-label>
        <x-input id="id_kec_baru" name="id_kec_baru" minlength="6" maxlength="6" class="mt-1 w-full" />
        <p class="text-xs text-gray-500 mt-1">* masukan 6 digit pertama nomor KTP/KK Anda</p>
      </div>

      <div>
        <x-label>Kabupaten</x-label>
        <x-input id="kab_baru" name="kab_baru" class="mt-1 w-full" />
      </div>
    </div>

    {{-- Alamat --}}
    <div class="space-y-4">
      <div>
        <x-label>Alamat Jalan/Dusun</x-label>
        <x-input required id="alamat_jalan" name="alamat_jalan" class="mt-1 w-full" />
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <x-label>RT</x-label>
          <x-input required id="rt" name="rt" inputmode="numeric" maxlength="3" />
        </div>
        <div class="flex-1">
          <x-label>RW</x-label>
          <x-input required id="rw" name="rw" inputmode="numeric" maxlength="3" />
        </div>
        <div class="flex-1">
          <x-label>Desa</x-label>
          <x-input required id="desa" name="desa" class="mt-1 w-full" />
        </div>
      </div>
    </div>

    {{-- Checkbox --}}
    <div class="flex items-center gap-2">
      <input type="checkbox" id="cek1" name="cek1"
        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
      <x-label for="cek1" class="cursor-pointer">
        Saya ingin join grup teman se-kecamatan (My Neighboors)
      </x-label>
    </div>

    {{-- Submit --}}
    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'alamat-updated')
      <p class="text-sm text-gray-600 dark:text-gray-400" id="saved-msg">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>

<script>
  $(document).ready(function() {
    // Toggle Blok Kecamatan Baru
    $('#kec_id').on('change', function() {
        const isNew = $(this).val() === 'new';
        $('#blok_kec_baru').toggle(isNew);
        $('#kec_baru, #kab_baru').prop('required', isNew);
    });


    // Hide saved message setelah 2 detik
    setTimeout(function() {
        $('#saved-msg').fadeOut();
    }, 2000);
});
</script>