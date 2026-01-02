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
            <x-label for="tahapan_bimbingan_id">Tahapan Bimbingan</x-label>
            <x-select required name="tahapan_bimbingan_id" id="tahapan_bimbingan_id">
              <option value="">--pilih--</option>
              {{-- foreach $tahapanBimbingan as $tahap --}}
              @foreach ($tahapanBimbingan as $tahap)
              <option value="{{$tahap->id}}">{{$tahap->urutan}} - {{$tahap->tahap}}</option>
              @endforeach
            </x-select>
          </div>

          <div>
            <x-label for="topik">Topik</x-label>
            <x-input name="topik" id="topik" />
          </div>

          <div>
            <x-label for="is_offline">Mode Bimbingan</x-label>
            <x-select required name="is_offline" id="is_offline">
              <option value="">Bimbingan Online</option>
              <option value="1">Bimbingan Offline pada tanggal</option>
            </x-select>
            <div id="blok_opsi_offline" class="hidden">
              <x-input class=opsi_offline type=date name="tanggal_offline" id="tanggal_offline" />
              <x-input class=opsi_offline name="lokasi_bimbingan" id="lokasi_bimbingan"
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
            <x-label for='pesan_mhs'>
              Pesan untuk Dosen
            </x-label>
            <x-textarea name="pesan_mhs" id=pesan_mhs rows="4"
              placeholder="Tuliskan kendala, progres, atau pertanyaan bimbingan...">
              {{ old('pesan_mhs') }}</x-textarea>
            @error('pesan_mhs')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- file bimbingan --}}
          <div>
            <x-label for='file_bimbingan'>
              File Bimbingan (opsional)
            </x-label>
            <input type="file" name="file_bimbingan" id="file_bimbingan" class="block w-full text-sm " accept=".docx" />
            <p class="text-xs  mt-1">
              DOCX (maks. 5MB)
            </p>
            @error('file_bimbingan')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- action --}}
          <div class="flex justify-end gap-3 pt-4">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg text-sm bg-gray-100 hover:bg-gray-200">
              Batal
            </a>

            <button type="submit" class="px-5 py-2 rounded-lg text-sm bg-blue-600 text-white hover:bg-blue-700">
              Ajukan Bimbingan
            </button>
            <x-button class="bg-blue-600  hover:bg-blue-700">Ajukan Bimbingan</x-button>
          </div>

        </form>

      </x-card-body>


    </x-card>

  </x-page-content>
</x-app-layout>