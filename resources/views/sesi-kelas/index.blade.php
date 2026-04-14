{{-- resources/views/sesi_kelas/index.blade.php --}}
<x-app-layout>
  <x-page-header title="Sesi Kelas" subtitle="Daftar sesi/pertemuan kelas Anda" />

  <x-page-content>

    <x-card>
      <x-card-header>Info Tahun Ajar {{$taAktif}}</x-card-header>
      <x-card-body>
        <div>Pekan Pertama: Senin, 11 Feb 2026 | {{$tahunAjar->senin_pertama_kuliah}}</div>
        <div>
          <div class="mb-2">Minggu #2 - Feb 2026</div>
          <table>
            <tr>
              <td>Kelas</td>
              <td>Senin</td>
              <td>Selasa</td>
              <td>Rabu</td>
              <td>Kamis</td>
              <td>Jumat</td>
              <td>Sabtu</td>
            </tr>
            <tr>
              <td>R</td>
              <td>WEB2 (IF-R4) - 07:30</td>
              <td>
                <div>WEB1 (IF-R1) - 07:30</div>
                <div>IMK (IF-R2) - 07:30</div>
              </td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>NR</td>
              <td>PWM (SI-R4) - 07:30</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
            </tr>
          </table>

        </div>
      </x-card-body>
    </x-card>

    <x-card>
      <x-card-header>Daftar Sesi Kelas</x-card-header>
      <x-card-body>

        <div>
          @php
          $firstMkId = null;
          $firstKelasId = null;
          @endphp

          <div class="flex gap-2 justify-center mb-3">
            @foreach ($arrMkId as $mk_id => $label_mk)
            @php
            $firstMkId = $firstMkId ?? $mk_id;
            @endphp
            <x-button size=sm outline=true class="nav nav_mk" data-mk_id="{{$mk_id}}">{{$label_mk}}</x-button>
            @endforeach
          </div>

          <div class="flex gap-2 justify-center mb-3">
            @foreach ($arrKelasId as $kelas_id=> $item)
            @php
            $firstKelasId = $firstKelasId ?? $kelas_id;
            $hide_nav_kelas = $item['mk_id'] == $firstMkId ? '' : 'hidden';
            @endphp
            <x-button size=sm class="{{$hide_nav_kelas}} nav_kelas nav_kelas--{{$item['mk_id']}}"
              data-kelas_id="{{$kelas_id}}">
              {{$item['label']}}</x-button>
            @endforeach
          </div>

          <div class="hidden">
            $firstMkId <span id=firstMkId>{{$firstMkId}}</span>
            $firstKelasId <span id=firstKelasId>{{$firstKelasId}}</span>
          </div>
          <script>
            $(function(){
              let firstKelasId = $('#firstKelasId').text();
              let firstMkId = $('#firstMkId').text();
              let mk_id = null;

              $('.nav_mk').click(function(){
                mk_id = $(this).data('mk_id');
                $('.nav_kelas').hide();
                $('.nav_kelas--'+mk_id).show();

                let first_loop = 1;
                $('.nav_kelas--'+mk_id).each((index, el) => {
                  if(first_loop) show_tr($(el).data('kelas_id'));
                  first_loop = false;
                })
              })

              $('.nav_kelas').click(function(){
                show_tr($(this).data('kelas_id'));
              })
            })

            function show_tr(kelas_id){
              $('.tr').hide();
              $('.tr--'+kelas_id).show();
            }
          </script>
        </div>


        <style>
          .tr--uts,
          .tr--uas {
            background: rgb(109, 82, 9);
            color: white;
          }
        </style>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Unit</th>
              <th>Kelas</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            @forelse($sesiKelass as $sesiKelas)
            @php
            $hidden_tr = $sesiKelas->stmItem->kelas_id == $firstKelasId ? '' : 'hidden';
            @endphp
            <tr class="tr tr--{{$sesiKelas->stmItem->kelas_id}} tr--{{$sesiKelas->fase}} {{$hidden_tr}}">
              <td>{{ $sesiKelas->unit->urutan }}</td>
              <td>{{ $sesiKelas->unit->nama }} - {{$sesiKelas->stmItem->kurMk->mk->singkatan}}</td>
              <td>{{$sesiKelas->stmItem->kelas->label}}</td>

              <td>{{$sesiKelas->tanggal_rencana->format('D, d-M-Y')}} </td>

              <td>
                {{ optional($sesiKelas->start_at)->format('H:i') }}-
                {{ optional($sesiKelas->end_at)->format('H:i') }}
              </td>



              <td>
                {{-- jika tanggal terlewat dan status==0 maka ZZZ --}}



                @php
                $status = (int) ($sesiKelas->status);
                $statusLabel = match($status) {
                0 => 'Draft',
                1 => 'Aktif',
                2 => 'Selesai',
                default => 'Unknown',
                };
                @endphp
                {{ $statusLabel }}
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="9">Tidak ada data sesi kelas.</td>
            </tr>
            @endforelse
          </tbody>
        </table>


      </x-card-body>
    </x-card>

  </x-page-content>
</x-app-layout>