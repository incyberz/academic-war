<x-app-layout>
  <x-page-header title="Create Sesi Bimbingan" subtitle="Ajukan sesi bimbingan kepada dosen pembimbing" />

  <x-page-content>

    <x-card>
      <x-card-header>Pengajuan Bimbingan</x-card-header>
      <x-card-body>
        {{-- info bimbingan --}}
        <div class="mb-6 border-b pb-4">
          <p class="text-sm ">
            Jenis: {{ $pesertaBimbingan->bimbingan->jenisBimbingan->nama }}
          </p>
          <p class="text-sm ">
            Pembimbing: {{ $pesertaBimbingan->bimbingan->pembimbing->dosen->nama }}
          </p>
        </div>


        {{-- form --}}
        <form action="{{ route('sesi-bimbingan.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-5">
          @csrf

          <input type="hidden" name="peserta_bimbingan_id" value="{{ $pesertaBimbingan->id }}" />

          <div>
            <x-label for="bab_laporan_id">Apa yang ingin kamu bahas?</x-label>
            <x-select required name="bab_laporan_id" id="bab_laporan_id">
              <option value="">--pilih--</option>
              @foreach ($babLaporan as $bab)
              <option value="{{$bab->id}}">{{$bab->nama}}</option>
              @endforeach
            </x-select>
          </div>

          <div>
            <x-label for="topik">Topik detail / sub-bab (jika ada)</x-label>
            <x-input name="topik" id="topik" />
          </div>

          <div>
            <x-label for="nama_dokumen">Nama Dokumen (auto/manual)</x-label>
            <x-input required name="nama_dokumen" id="nama_dokumen" />
            <script>
              $(function () {
            
              function generateNamaDokumen() {
                // ambil teks option bab yang dipilih
                let nama_bab = $('#bab_laporan_id option:selected').text().toLowerCase();
            
                // ambil topik
                let topik = $('#topik').val().toLowerCase();
            
                // normalisasi teks
                nama_bab = nama_bab.trim().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '_');
                topik = topik.trim().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '_');
            
                // timestamp otomatis (YYMMDD)
                let now = new Date();
                let timestamp = String(now.getFullYear()).slice(2) +
                                String(now.getMonth() + 1).padStart(2, '0') +
                                String(now.getDate()).padStart(2, '0');
            
                // gabungkan
                let nama_dokumen = `${nama_bab}-${topik}-${timestamp}`;
            
                $('#nama_dokumen').val(nama_dokumen);
              }
            
              // trigger saat mengetik topik
              $('#topik').on('keyup', generateNamaDokumen);
            
              // trigger saat ganti bab
              $('#bab_laporan_id').on('change', generateNamaDokumen);
            
            });
            </script>
          </div>

          <div>
            <x-label for="is_offline">Mode Bimbingan</x-label>
            <x-select required name="is_offline" id="is_offline">
              <option value="0">Cukup Bimbingan Online</option>
              <option value="1">Saya ingin Bimbingan Offline tanggal</option>
            </x-select>
            <div id="blok_opsi_offline" class="hidden">
              <x-input class=opsi_offline type=date name="tanggal_offline" id="tanggal_offline" />
              <x-input class=opsi_offline type=time name="jam_offline" id="jam_offline" />
              <x-input class=opsi_offline name="lokasi_offline" id="lokasi_offline"
                placeholder='Lokasi bimbingan offline...' />
            </div>
            <script>
              $(function(){
                $('#is_offline').change(function(){
                  let is_offline = parseInt(this.value);
                  if(parseInt(this.value)){
                    $('#blok_opsi_offline').slideDown();
                    $('.opsi_offline').prop('required',true);
                  }else{
                    $('#blok_opsi_offline').slideUp();
                    $('.opsi_offline').val('');
                    $('.opsi_offline').prop('required',false);
                  }
                })
              })
            </script>
          </div>


          {{-- pesan mahasiswa --}}
          <div>
            <x-label for='pesan_mhs'>Pesan untuk Dosen</x-label>
            <x-textarea required name="pesan_mhs" id=pesan_mhs rows="4"
              placeholder="Tuliskan kendala, progres, atau pertanyaan bimbingan...">
              {{ old('pesan_mhs') }}</x-textarea>
            @error('pesan_mhs')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- file bimbingan --}}
          <div>
            <x-label for='file_bimbingan'>
              File Bimbingan
            </x-label>
            <x-input required type="file" name="file_bimbingan" id="file_bimbingan" accept=".docx"
              class="text-xs p-3" />
            <p class="text-xs  mt-1">
              DOCX (maks. 2MB)
            </p>
            @error('file_bimbingan')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- action --}}
          <div class="flex justify-end gap-3 pt-4">
            <a href="{{ url()->previous() }}">
              <x-btn-back>Batal</x-btn-back>
            </a>

            <x-btn-primary>Ajukan</x-btn-primary>
          </div>

        </form>

      </x-card-body>


    </x-card>

  </x-page-content>
</x-app-layout>