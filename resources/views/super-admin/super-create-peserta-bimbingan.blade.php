<x-app-layout>
  <x-page-header title="Super Create Peserta Bimbingan" subtitle="Dosen / Super Admin" />

  <x-page-content>

    {{-- if errors any --}}
    {{-- GLOBAL VALIDATION ERROR --}}
    @if ($errors->any())
    <x-card class="mb-4 border-red-300 bg-red-50 dark:bg-red-950">
      <x-card-header class="text-red-700 dark:text-red-300">
        Terjadi kesalahan input
      </x-card-header>
      <x-card-body>
        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-300">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </x-card-body>
    </x-card>
    @endif

    <form method="POST" action="{{ route('peserta-bimbingan.super-store', [
              'bimbingan'      => $bimbinganId,
              'jenisBimbingan' => $jenisBimbinganId,
          ]) }}">

      @csrf

      {{-- ================= USER ================= --}}
      <x-card class="mb-6">
        <x-card-header>1. User Mahasiswa</x-card-header>
        <x-card-body class="space-y-4">

          {{-- NAMA PANGGILAN --}}
          <div>
            <x-label for="user-name">
              Nama Panggilan <span class="text-red-500">*</span>
            </x-label>

            <x-input id="user-name" name="user[name]" required minlength="3" maxlength="50" autocomplete="off"
              placeholder="Contoh: Ahmad Fauzi" />

            <p class="text-xs text-gray-500 mt-1">
              Nama di LMS. Huruf A–Z, boleh spasi tunggal, petik tunggal akan diubah ke backtick.
            </p>

            @error('user.name')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- EMAIL --}}
          <div>
            <x-label for="user-email">
              Email <span class="text-red-500">*</span>
            </x-label>

            <x-input id="user-email" name="user[email]" type="email" required autocomplete="off"
              placeholder="nama@gmail.com" />

            <p class="text-xs text-gray-500 mt-1">
              Disarankan menggunakan Gmail.
            </p>

            @error('user.email')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- USERNAME --}}
          <div>
            <x-label for="user-username">
              Username <span class="text-red-500">*</span>
            </x-label>

            <x-input id="user-username" name="user[username]" required minlength="3" maxlength="20" autocomplete="off"
              placeholder="ahmad123" />

            <p class="text-xs text-gray-500 mt-1">
              Huruf kecil a–z dan angka 0–9 (3–20 karakter).
            </p>

            @error('user.username')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- ROLE MAHASISWA --}}
          <input type="hidden" name="user[role_id]" value="6">

          <script>
            $(function () {
          
              // NAMA PANGGILAN
              $('#user-name').on('keyup', function () {
                  let val = $(this).val();
          
                  val = val
                      .replace(/'/g, '`')          // ganti petik tunggal ke backtick
                      .toUpperCase()               // uppercase
                      .replace(/[^A-Z`\s]/g, '')   // hanya A-Z, backtick, spasi
                      .replace(/\s+/g, ' ')        // spasi ganda → satu spasi
                      .trimStart();                // hilangkan spasi di awal
          
                  $(this).val(val);
              });
          
              // USERNAME
              $('#user-username').on('keyup', function () {
                  let val = $(this).val();
          
                  val = val
                      .toLowerCase()              // lowercase
                      .replace(/[^a-z0-9]/g, ''); // hanya a-z dan 0-9
          
                  $(this).val(val);
              });
          
          });
          </script>

        </x-card-body>
      </x-card>

      {{-- ================= MAHASISWA ================= --}}
      <x-card class="mb-6">
        <x-card-header>2. Data Mahasiswa</x-card-header>
        <x-card-body>

          <div>
            <x-label>Nama Lengkap (Sesuai KTP)</x-label>
            <x-input name="mahasiswa[nama_lengkap]" required />
            <div>Perhatian! Wajib sesuai dengan KTP atau Kartu Keluarga</div>
          </div>

          <div>
            <x-label>Angkatan</x-label>
            <x-input name="mahasiswa[angkatan]" required />
            <div>Tahun kapan kamu masuk? (PMB)</div>
          </div>

        </x-card-body>
      </x-card>

      {{-- ================= ELIGIBLE BIMBINGAN ================= --}}
      <x-card class="mb-6">
        <x-card-header>3. Eligible Bimbingan</x-card-header>
        <x-card-body>

          <div>
            <x-label>Tahun Ajar</x-label>
            <x-input value="{{ $tahunAjarId }}" disabled />
            <div>Auto! Pilih menu Ubah Tahun Ajar jika diperlukan</div>
          </div>

          <div>
            <x-label>Jenis Bimbingan</x-label>
            <x-input value="{{ $jenisBimbingan->nama ?? 'Jenis Bimbingan' }}" disabled />
          </div>

          <input type="hidden" name="eligible[tahun_ajar_id]" value="{{ $tahunAjarId }}">

          <input type="hidden" name="eligible[jenis_bimbingan_id]" value="{{ $jenisBimbinganId }}">

          <input type="hidden" name="eligible[assign_by]" value="{{ auth()->id() }}">

        </x-card-body>
      </x-card>

      {{-- ================= PESERTA BIMBINGAN ================= --}}
      <x-card class="mb-6">
        <x-card-header>4. Peserta Bimbingan</x-card-header>
        <x-card-body>

          <div>
            <x-label>Jenis Bimbingan</x-label>
            <x-input value="{{ $bimbingan->jenisBimbingan->nama ?? 'Bimbingan' }}" disabled />
          </div>

          <input type="hidden" name="peserta[bimbingan_id]" value="{{ $bimbinganId }}">

          <input type="hidden" name="peserta[ditunjuk_oleh]" value="{{ auth()->id() }}">

          <input type="hidden" name="peserta[keterangan]" value="Create by Super Admin at {{ now() }}">

        </x-card-body>
      </x-card>

      {{-- ================= SUBMIT ================= --}}
      <div class="">
        <x-button type="primary" class="w-full">
          Super Create Peserta Bimbingan
        </x-button>
      </div>

    </form>

  </x-page-content>
</x-app-layout>