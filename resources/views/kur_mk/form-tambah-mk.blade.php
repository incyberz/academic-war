<form method="POST" action="{{ route('kur-mk.store') }}" class="mt-4 space-y-3 p-4 rounded border
         bg-gray-50 border-gray-200
         dark:bg-gray-900 dark:border-gray-700">

  <h3 class="my-3 font-semibold text-xl">Form Tambah MK di Semester {{$i}}</h3>

  @csrf

  {{-- KURIKULUM (FIX) --}}
  <input type="hidden" name="kurikulum_id" value="{{ $kurikulum->id }}">

  {{-- SEMESTER (FIX dari parent loop) --}}
  <input type="hidden" name="semester" value="{{ $i }}">

  {{-- MATA KULIAH --}}
  <div>
    <x-select required name="mk_id" id="mk_id_{{ $i }}" class="w-full">
      <option value="">-- Pilih Mata Kuliah <i>unassign</i> --</option>

      @forelse($unassignMks as $mk)
      <option value="{{ $mk->id }}">
        {{ $mk->nama }} ({{ $mk->sks }} SKS)
      </option>
      @empty
      <option disabled>
        Semua mata kuliah sudah ter-assign ke kurikulum
      </option>
      @endforelse

    </x-select>
  </div>

  {{-- JENIS --}}
  <div>
    <x-select required name="jenis" id="jenis_{{ $i }}">
      <option value="wajib">MK Wajib</option>
      <option value="pilihan">MK Pilihan</option>
    </x-select>
  </div>

  {{-- PRASYARAT --}}
  @php
  $prasyaratMks = $kurikulum->kurMks->where('semester','<',$i); @endphp <div>
    <x-select name="prasyarat_mk_id" id="prasyarat_{{ $i }}">
      <option value="">-- Tidak Ada Prasyarat MK --</option>
      @foreach($prasyaratMks as $kmk)
      <option value="{{ $kmk->mk_id }}">{{ $kmk->mk->nama }}</option>
      @endforeach
    </x-select>
    </div>

    {{-- AKSI --}}
    <div class="flex justify-end gap-2 pt-2">
      <x-button size="sm">
        Simpan
      </x-button>

      <x-button type="button" size="sm" :outline="true" onclick="$(this).closest('form').parent().slideUp()">
        Batal
      </x-button>
    </div>

</form>