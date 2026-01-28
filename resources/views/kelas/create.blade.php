<x-app-layout>
  <x-page-header title="Buat Kelas Baru" subtitle="TA {{$taAktif}}" />

  <x-page-content>
    <form method="POST" action="{{ route('kelas.store') }}">
      @csrf

      <input type="hidden" id="kode" name="kode" required>
      <input type="hidden" id="label" name="label" required>

      <x-card>
        <x-card-header>
          <div class="flex items-center justify-between gap-3">
            <div>
              <div class="text-lg font-semibold">Form Kelas</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">
                Kode & Label akan dibuat otomatis berdasarkan input.
              </div>
            </div>

            <div class="flex gap-2">
              <a href="{{ route('kelas.index') }}">
                <x-button btn="secondary" type="button">Kembali</x-button>
              </a>
              <x-button btn="primary" type="submit" id="btn_simpan">Simpan</x-button>
            </div>
          </div>
        </x-card-header>

        <x-card-body>
          {{-- Preview Kode / Label --}}
          <div class="mb-5 grid gap-3 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
              <div class="text-xs text-gray-500 dark:text-gray-400">Preview Label</div>
              <div id="preview_label" class="text-xl font-bold mt-1 text-gray-900 dark:text-gray-100">-</div>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
              <div class="text-xs text-gray-500 dark:text-gray-400">Preview Kode</div>
              <div id="preview_kode" class="text-xl font-bold mt-1 text-gray-900 dark:text-gray-100">-</div>
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            {{-- Tahun Ajar --}}
            <div>
              <x-label>Tahun Ajar (Aktif)</x-label>
              <x-input id="ta_aktif" value="{{ $taAktif }}" disabled />
              <input type="hidden" name="tahun_ajar_id" id="tahun_ajar_id" value="{{ session('tahun_ajar_id') }}">
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Tahun ajar diambil dari session.
              </div>
            </div>

            {{-- Semester --}}
            <div>
              <x-label class="required">Semester</x-label>

              <div id="blok_radio_semester" class="mt-2 flex flex-wrap gap-2">
                @php
                $tahun_ajar_id = $tahun_ajar_id ?? session('tahun_ajar_id');

                // digit terakhir: 1=ganjil, 2=genap
                $semesterTA = (int) substr((string) $tahun_ajar_id, -1);

                $listSemester = $semesterTA === 1
                ? [1, 3, 5, 7]
                : [2, 4, 6, 8];
                @endphp

                <div class="flex flex-wrap gap-2 mt-2" id="blok_radio_semester">
                  @foreach ($listSemester as $i)
                  <label for="semester{{ $i }}" id="label_semester{{ $i }}" class="label_semester cursor-pointer select-none rounded-xl border px-4 py-2 font-semibold
                             border-gray-200 bg-white text-gray-700
                             hover:bg-gray-50 hover:border-gray-300
                             dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                    <input class="radio_semester sr-only peer" required autocomplete="off" type="radio" name="semester"
                      id="semester{{ $i }}" value="{{ $i }}">

                    <span class="peer-checked:text-white">
                      {{ $i }}
                    </span>
                  </label>
                  @endforeach
                </div>
              </div>

            </div>

            {{-- Prodi --}}
            <div>
              <x-label class="required">Program Studi</x-label>
              <x-select required name="prodi_id" id="prodi_id" autocomplete=off>
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis as $prodi)
                <option value="{{ $prodi->id }}">
                  {{ $prodi->jenjang->kode }} - {{ $prodi->prodi }} - {{ $prodi->nama }}
                </option>
                @endforeach
              </x-select>

              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <span class="font-semibold">kode prodi</span> akan menjadi bagian dari kode kelas
              </div>
            </div>

            {{-- Shift --}}
            <div>
              <x-label class="required">Kelas (Shift)</x-label>
              <x-select required name="shift_id" id="shift_id" autocomplete=off>
                <option value="">-- Pilih Shift --</option>
                @foreach ($shifts as $shift)
                <option value="{{ $shift->id }}">
                  {{ $shift->kode }} - {{ $shift->nama }}
                </option>
                @endforeach
              </x-select>
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Contoh kode shift: R / NR.
              </div>
            </div>

            {{-- Rombel --}}
            <div>
              <x-label class="required">Rombel pada prodi <span class="span_kode_prodi">SI</span>-<span
                  class="span_kode_shift">NR</span> </x-label>
              <x-select required id="select_jumlah_rombel" autocomplete=off>
                <option value="">-- Pilih Jumlah Rombel --</option>
                <option value="1">hanya 1 rombel saja</option>
                <option value="2">2 rombel (kelas A dan B)</option>
                <option value="3">3 rombel (A, B, C)</option>
                <option value="4">4 rombel</option>
                <option value="5">5 rombel</option>
                <option value="6">lebih dari 5 rombel...</option>
              </x-select>
              <div id="blok_jumlah_rombel" class="hidden">
                <x-label class="required">Jumlah Rombel</x-label>
                <x-input id="jumlah_rombel" required name="jumlah_rombel" value="{{ old('jumlah_rombel') }}"
                  placeholder="jumlah rombel..." type=number min=1 max=20 />
              </div>
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Akan dibuat kelas sebanyak <span class="span_jumlah_rombel">1</span> rombel
              </div>
            </div>

            {{-- Kapasitas --}}
            <div class="grid gap-4 grid-cols-2">
              <div>
                <x-label>Max Peserta</x-label>
                <x-input type="number" min="1" name="max_peserta"
                  value="{{ old('max_peserta', $kelas->max_peserta ?? 40) }}" />
              </div>

              <div>
                <x-label>Min Peserta</x-label>
                <x-input type="number" min="1" name="min_peserta"
                  value="{{ old('min_peserta', $kelas->min_peserta ?? 5) }}" />
              </div>
            </div>
          </div>

          <div class="mt-6">
            <x-alert type="hint" title="Catatan">
              Kode kelas bersifat unik. Sistem akan mencegah duplikasi rombel pada kombinasi:
              Tahun Ajar + Prodi + Shift + Semester.
            </x-alert>
          </div>
        </x-card-body>
      </x-card>
    </form>

  </x-page-content>
</x-app-layout>








<style>
  .selected_semester {
    background: rgb(38, 7, 177) !important;
    color: #fff !important;
    border-color: rgb(38, 7, 177) !important;
  }
</style>

<script>
  $(function(){
    let kodeProdi = null;
    let kodeShift = null;
    let jumlahRombel = 0;
    let semester = null;
    let jenjang = null;
    let tahun_ajar_id = $('#tahun_ajar_id').val();

    function updateUI(){
      $('.span_kode_prodi').text(kodeProdi ?? '?')
      $('.span_kode_shift').text(kodeShift ?? '?')
      $('.span_jumlah_rombel').text(jumlahRombel)

      let kodeKelas = `${jenjang ?? '?'}-${kodeProdi ?? '?'}-A-${kodeShift ?? '?'}-${semester ?? '?'}-${tahun_ajar_id}`;
      let rombelA = jumlahRombel==1 ? '-' : '-A-';
      let labelKelas = `${kodeProdi ?? '?'}${rombelA}${kodeShift ?? '?'}${semester ?? '?'}`;
      // contoh S1-SI-A-R-4-20251
      $('#preview_kode').text(kodeKelas)
      $('#preview_label').text(labelKelas)

      if(kodeProdi && kodeShift && jumlahRombel && semester){
        $('#btn_simpan').prop('disabled',false);
        $('#kode').val(kodeKelas)
        $('#label').val(labelKelas)
      }else{
        $('#btn_simpan').prop('disabled',true);
        $('#kode').val('')
        $('#label').val('')
      }
      
    }


    $('#prodi_id').change(function(){
      if(this.value){
        let arr = $(this).find('option:selected').text().trim().split(' - ');
        jenjang = arr[0];
        kodeProdi = arr[1];
        updateUI();
      }
    })

    $('#shift_id').change(function(){
      if(this.value){
        kodeShift = $(this).find('option:selected').text().trim().split(' - ')[0];
        updateUI();
      }
    })

    $('#select_jumlah_rombel').change(function(){

      jumlahRombel = parseInt(this.value || 0) ;

      if (jumlahRombel > 5) {
        $('#blok_jumlah_rombel').slideDown();
        $('#jumlah_rombel').prop('required', true);
      } else {
        $('#blok_jumlah_rombel').slideUp();
        $('#jumlah_rombel').prop('required', false);
      }

      updateUI();
      $('#jumlah_rombel').val(this.value)
    })

    $('.radio_semester').click(function(){
      semester = this.value;
      let activeClass = 'selected_semester';
      $('.label_semester').removeClass(activeClass);
      $('#label_semester'+semester).addClass(activeClass);
      updateUI();
    })

    $('#jumlah_rombel').keyup(function(){
      jumlahRombel = parseInt(this.value || 0) ;
      updateUI();
    })

    updateUI();
  })
</script>