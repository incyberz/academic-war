<x-app-layout>
  <x-page-header title="Charter Jadwal Perkuliahan "
    subtitle="Pilih mata kuliah, hari, dan jam untuk memulai penjadwalan." />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    <x-card>
      <x-card-header>
        Charter Jadwal di TA {{$taAktif}}
      </x-card-header>

      <x-card-body>

        {{-- ============================================= --}}
        {{-- NAVIGASI SHIFT --}}
        {{-- ============================================= --}}
        <div>
          @php
          $first_shift_id = null;
          @endphp
          @foreach ($shifts as $shift )
          @php
          $first_shift_id = $first_shift_id ?? $shift->id;
          $checked = $first_shift_id==$shift->id ? 'checked' : '';
          @endphp
          <label>
            <input class="pilihan pilihan_shift" data-jenis_pilihan=shift data-shift_id={{$shift->id}} type="radio"
            value="{{$shift->id}}"
            name=shift_id autocomplete=off {{$checked}}>
            {{$shift->nama}}
          </label>
          @endforeach
        </div>


        {{-- ============================================= --}}
        {{-- NAVIGASI SEMESTERS --}}
        {{-- ============================================= --}}
        <div>
          @php
          $first_semester = null;
          @endphp
          @foreach ($arrSemesters as $semester )
          @php
          $first_semester = $first_semester ?? $semester;
          $checked = $first_semester==$semester ? 'checked' : '';
          @endphp
          <label>
            <input class="pilihan pilihan_semester" data-jenis_pilihan="semester" data-semester="{{$semester}}"
              value="{{$semester}}" type="radio" name=semester_id autocomplete=off {{$checked}}>
            {{$semester}}
          </label>
          @endforeach
        </div>




        {{-- ============================================= --}}
        {{-- NAVIGASI STM ITEMS PER SHIFT PER SEMESTER --}}
        {{-- ============================================= --}}
        {{-- @dd($arrStmItemsUnsigned) --}}
        <div class="flex gap-3" id="nav_mk">
          @foreach ($shifts as $shift )
          <div class="flex gap-3">
            {{-- <div>loop shift {{$shift->nama}}</div> --}}

            @foreach ($arrSemesters as $semester )


            @php
            $navMks = $arrStmItemsUnsigned[$shift->id][$semester];
            @endphp

            @foreach ($navMks as $navMk)
            <div>
              {{-- <div>shift_id {{$shift->id}} + semester {{$semester}}</div> --}}

              @php
              $hidden =
              ($navMk->kelas->shift_id == $first_shift_id && $semester == $first_semester)
              ? ''
              : 'hiddena';
              @endphp
              <label class="{{$hidden}} blok_mk" id="blok_mk--{{$shift->id}}--{{$semester}}">
                <input class="pilihan pilihan_mk" data-jenis_pilihan="mk" type="radio" name="nav_mk"
                  data-stm_item_id="{{$navMk->id}}" data-semester="{{$semester}}" data-shift_id="{{$shift->id}}"
                  autocomplete="off">
                {{$hidden}}
                {{$navMk->kurMk->Mk->singkatan}} -
                {{$navMk->kelas->label}}
              </label>
            </div>
            @endforeach

            @endforeach
          </div>
          @endforeach
        </div>
        <div class="hidden" id="no_mk">
          Tidak ada MK
        </div>




        {{-- ============================================= --}}
        {{-- KONTEN --}}
        {{-- ============================================= --}}
        <hr>
        <div class="blok_shift" id="blok_shift--1">
          Kelas Reguler
          <div>
            ZZZ
          </div>
        </div>
        <div class="blok_shift" id="blok_shift--2">
          Kelas NR
          <div>
            ZZZ
          </div>
        </div>

      </x-card-body>
    </x-card>


  </x-page-content>
</x-app-layout>
<script>
  $(function(){
    let jenis_pilihan = null;
    let shift_id = $('.pilihan_shift').val();
    let semester = $('.pilihan_semester').val();
    let stm_item_id = null;

    function show_mk(shift_id, semester){
      if(shift_id && semester){
        $('.blok_mk').hide();
        let target = $('#blok_mk--'+shift_id+'--'+semester);
        if(target.length){
          target.show();
          $('#no_mk').text('');
          $('#no_mk').hide();
          $('#nav_mk').show();
        }else{
          $('#no_mk').text(`Tidak ada MK untuk shift [shift_id] semester [semester] di STM Anda.`);
          $('#no_mk').show();
          $('#nav_mk').hide();
        }
      }
    }

    $('.pilihan').click(function(){
      jenis_pilihan = $(this).data('jenis_pilihan');
      
      if(jenis_pilihan=='shift'){
        shift_id = parseInt($(this).data('shift_id'));
        $('.blok_shift').hide();
        $('#blok_shift--'+shift_id).show();
        show_mk(shift_id, semester);
      }else if(jenis_pilihan=='semester'){
        semester = parseInt($(this).data('semester'));
        show_mk(shift_id, semester);
      }else if(jenis_pilihan=='mk'){
        // mk = $(this).data('mk');
        // show_mk(shift_id, mk);
        
      }else{
        alert(`Belum ada handler untuk jenis_pilihan [${jenis_pilihan}].` );
      }
      console.log(jenis_pilihan, shift_id, semester, stm_item_id);

    })
  })
</script>