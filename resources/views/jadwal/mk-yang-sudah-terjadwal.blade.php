<x-card class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-card-header class="border-b border-gray-200 dark:border-gray-700">
    <span class="font-semibold">
      Mata Kuliah yang Sudah Terjadwal
    </span>
  </x-card-header>

  <x-card-body>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-{{count($weekdays)}} gap-4">

      @foreach ($weekdays as $w => $namaHari)
      <div class="border rounded-lg overflow-hidden
                  border-gray-200 dark:border-gray-700
                  bg-white dark:bg-gray-800">

        {{-- HEADER HARI --}}
        <div class="px-3 py-2 text-center font-semibold
                    bg-gray-100 dark:bg-gray-700
                    text-gray-800 dark:text-gray-100">
          {{$namaHari}}
        </div>

        {{-- LOOP SHIFT (Reguler / Non Reguler) --}}
        @foreach ($shifts as $shift)
        <div class="px-3 py-2 border-t border-gray-200 dark:border-gray-700 space-y-2">

          <div class="text-xs text-gray-500 dark:text-gray-400">
            {{$shift->nama}}
          </div>

          @if(!empty($arrStmItemsSigned[$w][$shift->id]))
          @foreach ($arrStmItemsSigned[$w][$shift->id] as $item)
          <div class="item_jadwal p-3 rounded-lg
                   bg-gray-50 dark:bg-gray-900
                   border border-gray-200 dark:border-gray-700
                   hover:border-blue-400 dark:hover:border-blue-500
                   transition" data-jadwal_id="{{$item->jadwal->id}}" id="item_jadwal--{{$item->jadwal->id}}">

            {{-- HEADER --}}
            <div class="flex justify-between items-start gap-2">
              <div>
                <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                  {{$item->kurMk->mk->singkatan}}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                  {{$item->kelas->label}} •
                  {{$item->kelas->ruang?->kode ?? 'Ruang ? ⚠️'}}
                </div>
              </div>

              <div class="text-xs font-medium text-gray-700 dark:text-gray-200">
                {{$item->jadwal->jam_awal->format('H:i')}}–{{$item->jadwal->jam_akhir->format('H:i')}}
              </div>
            </div>

            {{-- TOGGLE --}}
            <div class="edit_jadwal text-xs text-right text-gray-400 cursor-pointer"
              data-jadwal_id="{{$item->jadwal->id}}">
              ⬇️
            </div>

            {{-- CRUD --}}
            <div class="hidden crud_jadwal mt-3 pt-3 border-t
                     border-gray-200 dark:border-gray-700
                     space-y-3" id="crud_jadwal--{{$item->jadwal->id}}">

              <div class="text-sm font-medium text-gray-700 dark:text-gray-200">
                Penyesuaian Jadwal
              </div>

              {{-- ===================================== --}}
              {{-- FORM PENYESUAIAN JADWAL --}}
              {{-- ===================================== --}}
              <form method="POST" action="{{route('jadwal.update', $item->jadwal->id)}}" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                  <x-label>Jam Mulai</x-label>
                  <x-input name="jam_awal" type="time" value="{{$item->jadwal->jam_awal->format('H:i')}}" />
                  <div class="text-xs text-gray-500">
                    Maksimal dimajukan 30 menit
                  </div>
                </div>

                <div>
                  <x-label>Jam Selesai</x-label>
                  <x-input name="jam_akhir" type="time" value="{{$item->jadwal->jam_akhir->format('H:i')}}" />
                  <div class="text-xs text-gray-500">
                    Maksimal dimundurkan 30 menit
                  </div>
                </div>

                @if($item->kurMk->sks >= 3)
                <div class="border rounded-md p-2
                            bg-gray-100 dark:bg-gray-800
                            border-gray-200 dark:border-gray-700">
                  <div class="text-xs font-medium mb-1">
                    Penyesuaian SKS Jadwal
                  </div>
                  <div class="text-xs text-gray-500 mb-2">
                    SKS MK: {{$item->kurMk->sks}} SKS
                  </div>
                  <x-label>Tatap Muka</x-label>
                  <x-input name="sks_jadwal" type="number" min="1" max="{{$item->kurMk->sks}}" />
                </div>
                @endif

                <div class="flex gap-2">
                  <x-button size="sm" btn="primary" class="w-full">
                    Simpan
                  </x-button>
                </div>
              </form>

              {{-- ===================================== --}}
              {{-- FORM DROP JADWAL --}}
              {{-- ===================================== --}}
              <form method="POST" action="{{route('jadwal.destroy', $item->jadwal->id)}}">
                @csrf
                @method('DELETE')
                <x-button size="sm" btn="danger" class="w-full">
                  Drop Jadwal
                </x-button>
              </form>

              <x-button size="sm" class="batal w-full" data-jadwal_id="{{$item->jadwal->id}}">
                Batal
              </x-button>

            </div>
          </div>
          @endforeach
          @else
          <div class="text-sm italic text-gray-400 dark:text-gray-500">
            —
          </div>
          @endif

        </div>
        @endforeach

      </div>
      @endforeach

    </div>
  </x-card-body>
</x-card>

<script>
  $(function(){
    let jadwal_id = null;
    $('.edit_jadwal').click(function(){
      if(jadwal_id == $(this).data('jadwal_id')) return;
      jadwal_id = $(this).data('jadwal_id');
      $('.crud_jadwal').slideUp();
      $('#crud_jadwal--'+jadwal_id).slideDown();
      console.log('edit jadwal',jadwal_id);
    });

    $('.batal').click(function(){
      jadwal_id = $(this).data('jadwal_id');
      $('#crud_jadwal--'+jadwal_id).slideUp();
      jadwal_id = null;
      console.log('batal',jadwal_id);
      
    });
  })
</script>