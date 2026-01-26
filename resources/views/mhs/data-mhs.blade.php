@php
$detailMhs = [
[
'label' => 'Nama Lengkap',
'value' => $mhs->nama_lengkap,
],
[
'label' => 'NIM',
'value' => $mhs->nim,
],
[
'label' => 'Program Studi',
'value' => $mhs->prodi->nama ?? '-- belum pilih prodi --',
],
[
'label' => 'Angkatan',
'value' => $mhs->angkatan,
],
[
'label' => 'Semester Awal',
'value' => $mhs->semester_awal ?? 1,
],
[
'label' => 'Kelas (Shift)',
'value' => $mhs->shift->nama ?? 'Pagi',
],
[
'label' => 'Kampus',
'value' => $mhs->kampus->nama ?? '-',
],
];
@endphp



<x-card class="x_card">

  <x-card-header>
    <div class="flex justify-between items-center">
      <span>My Data Mahasiswa</span>
      <x-button class="toggle">Ubah</x-button>
    </div>
  </x-card-header>

  <x-card-body class="card_body">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @foreach($detailMhs as $item)
      <div>
        <span class="text-gray-500">{{ $item['label'] }}</span>
        <div class="font-semibold">
          {{ $item['value'] }}
        </div>
      </div>
      @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

      <div>
        <span class="text-gray-500">Nama Lengkap</span>
        <div class="font-semibold">{{ $mhs->nama_lengkap }}</div>
      </div>

      <div>
        <span class="text-gray-500">NIM</span>
        <div class="font-semibold">{{ $mhs->nim }}</div>
      </div>

      <div>
        <span class="text-gray-500">Program Studi</span>
        <div class="font-semibold">{{ $mhs->prodi->nama ?? '-- belum pilih prodi --' }}</div>
      </div>

      <div>
        <span class="text-gray-500">Angkatan</span>
        <div class="font-semibold">{{ $mhs->angkatan }}</div>
      </div>

      <div>
        <span class="text-gray-500">Semester Awal</span>
        <div class="font-semibold">{{ $mhs->semester_awal ?? 1}}</div>
      </div>

      <div>
        <span class="text-gray-500">Kelas (Shift)</span>
        <div class="font-semibold">{{ $mhs->shift->nama ?? 'Pagi' }}</div>
      </div>

      <div>
        <span class="text-gray-500">Kampus</span>
        <div class="font-semibold">{{ $mhs->kampus->nama ?? '-' }}</div>
      </div>

      <div>
        <span class="text-gray-500">Status Mahasiswa</span>
        <div class="font-semibold">
          <x-badge type="info" text="{{ $mhs->statusMhs->nama }}" />
        </div>
      </div>

    </div>
  </x-card-body>

</x-card>

{{-- ================== FORM UPDATE ================== --}}

<x-card class="x_card hidden">
  <x-card-header>
    <div class="flex justify-between items-center">
      <span>Update Data Mahasiswa</span>
      <x-button class="toggle">Back</x-button>
    </div>
  </x-card-header>

  <x-card-body>
    <form method="POST" action="{{ route('mhs.update', $mhs->id) }}" id="form-mhs">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
          <x-label>Nama Lengkap</x-label>
          <x-input name="nama_lengkap" value="{{ $mhs->nama_lengkap }}" />
        </div>

        <div>
          <x-label>NIM</x-label>
          <x-input name="nim" value="{{ $mhs->nim }}" />
        </div>

        <div>
          <x-label>Program Studi</x-label>
          <x-select name="prodi_id">
            @foreach($prodi as $p)
            <option value="{{ $p->id }}" @selected($mhs->prodi_id == $p->id)>
              {{ $p->nama }}
            </option>
            @endforeach
          </x-select>
        </div>

        <div>
          <x-label>Angkatan</x-label>
          <x-input name="angkatan" value="{{ $mhs->angkatan }}" />
        </div>

        <div>
          <x-label>Semester Awal</x-label>
          <x-input name="semester_awal" type="number" value="{{ $mhs->semester_awal }}" />
        </div>

        <div>
          <x-label>Shift</x-label>
          <x-select name="shift_id">
            @foreach($shift as $s)
            <option value="{{ $s->id }}" @selected($mhs->shift_id == $s->id)>
              {{ $s->nama }}
            </option>
            @endforeach
          </x-select>
        </div>

        {{-- <div>
          <x-label>Kampus</x-label>
          <x-select name="kampus_id">
            @foreach($kampus as $k)
            <option value="{{ $k->id }}" @selected($mhs->kampus_id == $k->id)>
              {{ $k->nama }}
            </option>
            @endforeach
          </x-select>
        </div> --}}

      </div>

      <div class="mt-6 flex justify-end gap-2">
        <x-button type="submit">Simpan</x-button>
      </div>
    </form>
  </x-card-body>

</x-card>

<script>
  $(function(){
    $('.toggle').on('click', function(){
      $('.x_card').slideToggle(200)
    })
  })
</script>

<script>
  $(document).ready(function () {

    $('#form-mhs').on('submit', function (e) {
        e.preventDefault(); // stop submit biasa

        let form = $(this);
        let url = form.attr('action');

        $.ajax({
            url: url,
            type: "POST", // tetap POST
            data: form.serialize(), // otomatis bawa _token & _method
            success: function (res) {

                alert('✅ Data mahasiswa berhasil disimpan');

                // contoh redirect (opsional)
                // window.location.href = "{{ route('mhs.index') }}";
            },
            error: function (xhr) {

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let pesan = '';

                    $.each(errors, function (key, value) {
                        pesan += value[0] + '\n';
                    });

                    alert('❌ Validasi gagal:\n' + pesan);
                } else {
                    alert('❌ Terjadi kesalahan server');
                }
            }
        });
    });

});
</script>