<x-app-layout>
  <x-page-header title="Super Create Peserta Bimbingan" subtitle="Back to My Bimbingan :: {{$jenisBimbingan->nama}}"
    route="{{route('bimbingan.show',$bimbinganId)}}" />

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
        <x-card-header>1. Akun User 🧑‍💻</x-card-header>
        <x-card-body class="space-y-4">

          {{-- NAMA PANGGILAN --}}
          <div>
            <x-label class="required" for="user-name">
              Nama Panggilan
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
            <x-label class="required" for="user-email">
              Email
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
            <x-label class="required" for="user-username">
              Username | Password
            </x-label>

            <x-input id="user-username" name="user[username]" required minlength="3" maxlength="20" autocomplete="off"
              placeholder="ahmad123" />

            <p class="text-xs text-gray-500 mt-1">
              Huruf kecil a–z dan angka 0–9 (3–20 karakter), password = username
            </p>

            @error('user.username')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- WHATSAPP --}}
          <div>
            <x-label class="required" for="user-whatsapp">
              Whatsapp
            </x-label>

            <x-input id="user-whatsapp" name="user[whatsapp]" required minlength="11" maxlength="14" autocomplete="off"
              placeholder="08..." />

            <p class="text-xs text-gray-500 mt-1">
              antara 11 s.d 14 digit
            </p>

            @error('user.whatsapp')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

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
        <x-card-header>
          2. Data Mahasiswa 🎓
        </x-card-header>

        <x-card-body class="space-y-4">

          {{-- NAMA LENGKAP --}}
          <div>
            <x-label class="required" for="nama_lengkap">
              Nama Lengkap (Sesuai KTP)
            </x-label>

            <x-input id="nama_lengkap" name="mhs[nama_lengkap]" required autocomplete="off"
              placeholder="Contoh: AHMAD FAUZI" />

            <p class="text-xs text-amber-600 mt-1">
              ⚠️ Wajib sesuai dengan KTP atau Kartu Keluarga.
            </p>

            @error('mhs.nama_lengkap')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- ANGKATAN --}}
          <div>
            <x-label class="required" for="angkatan">
              Angkatan
            </x-label>

            <x-input id="angkatan" name="mhs[angkatan]" required inputmode="numeric" maxlength="4" autocomplete="off"
              placeholder="Contoh: 2024" />

            <p class="text-xs text-gray-500 mt-1">
              Tahun pertama masuk kuliah (PMB).
            </p>

            @error('mhs.angkatan')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <script>
            $(function () {
          
              // NAMA LENGKAP (KTP)
              $('#nama_lengkap').on('keyup', function () {
                  let val = $(this).val();
          
                  val = val
                      .replace(/'/g, '`')          // petik tunggal → backtick
                      .toUpperCase()               // uppercase
                      .replace(/[^A-Z`\s]/g, '')   // hanya A-Z, backtick, spasi
                      .replace(/\s+/g, ' ')        // spasi ganda → satu
                      .trimStart();                // hilangkan spasi awal
          
                  $(this).val(val);
              });
          
              // ANGKATAN
              $('#angkatan').on('keyup', function () {
                  let val = $(this).val();
          
                  val = val
                      .replace(/[^0-9]/g, '')   // hanya angka
                      .slice(0, 4);             // maksimal 4 digit
          
                  // optional: validasi range tahun
                  const yearNow = new Date().getFullYear();
                  const minYear = yearNow - 5;
          
                  if (val.length === 4) {
                      const year = parseInt(val);
                      if (year < minYear || year > yearNow) {
                          $(this)[0].setCustomValidity(
                              `Angkatan harus antara ${minYear} – ${yearNow}`
                          );
                      } else {
                          $(this)[0].setCustomValidity('');
                      }
                  } else {
                      $(this)[0].setCustomValidity('');
                  }
          
                  $(this).val(val);
              });
          
          });
          </script>

        </x-card-body>
      </x-card>


      {{-- ================= ELIGIBLE BIMBINGAN ================= --}}
      <x-card class="mb-6">
        <x-card-header>
          3. Eligible Bimbingan ✅
        </x-card-header>

        <x-card-body class="space-y-4">

          {{-- PERINGATAN --}}
          <div class="p-3 rounded-md bg-amber-50 border border-amber-300 text-amber-800 text-sm">
            ⚠️ <b>Perhatian!</b> Pastikan mhs di atas tercantum pada
            <b>Surat Tugas Bimbingan</b> yang Anda upload.
          </div>

          {{-- INFO PEMBIMBING --}}
          <div>
            <p class="text-xs text-gray-500">Nama Pembimbing</p>
            <p class="font-semibold text-gray-900 dark:text-gray-100">
              {{ $bimbingan->pembimbing->dosen->namaGelar() }}
            </p>
          </div>

          {{-- SURAT TUGAS --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <p class="text-xs text-gray-500">Nomor Surat Tugas</p>
              <p class="font-medium">
                {{ $bimbingan->nomor_surat_tugas ?? '-' }}
              </p>
            </div>

            <div>
              <p class="text-xs text-gray-500">File Surat Tugas</p>

              @if($bimbingan->file_surat_tugas)
              <a href="{{ Storage::url($bimbingan->file_surat_tugas) }}" target="_blank"
                class="text-blue-600 hover:underline text-sm">
                📄 Lihat Surat Tugas
              </a>
              @else
              <p class="text-sm text-gray-400">Belum tersedia</p>
              @endif
            </div>

          </div>

          {{-- META ELIGIBLE --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <x-label>Tahun Ajar</x-label>
              <x-input value="{{ $tahunAjar->nama ?? $tahunAjarId }}" disabled />

              <p class="text-xs text-gray-500 mt-1">
                Auto dari sistem. Gunakan menu <b>Ubah Tahun Ajar</b> jika diperlukan.
              </p>
            </div>

            <div>
              <x-label>Jenis Bimbingan</x-label>
              <x-input value="{{ $jenisBimbingan->nama ?? 'Jenis Bimbingan' }}" disabled />
            </div>

          </div>

          {{-- HIDDEN FIELDS --}}
          <input type="hidden" name="eligible[tahun_ajar_id]" value="{{ $tahunAjarId }}">
          <input type="hidden" name="eligible[jenis_bimbingan_id]" value="{{ $jenisBimbinganId }}">
          <input type="hidden" name="eligible[assign_by]" value="{{ auth()->id() }}">

        </x-card-body>
      </x-card>

      {{-- ================= PESERTA BIMBINGAN ================= --}}
      <x-card class="mb-6 hidden">
        <x-card-header>4. Peserta Bimbingan 🎯</x-card-header>
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
        <x-button btn="primary" class="w-full">
          Super Create Peserta Bimbingan
        </x-button>
      </div>

    </form>

  </x-page-content>
</x-app-layout>