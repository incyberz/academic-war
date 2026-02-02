@include('stm.item.nav-prodi')
@include('stm.item.nav-semester')

{{-- Kurikulum MK --}}
{{-- <p class="font-medium text-gray-700 dark:text-gray-200 mb-2">
  Mata Kuliah yang tersedia:
</p> --}}

<div id="kurmk-container" class="grid grid-cols-1 gap-2">
  @forelse($kurMks as $kurMk)
  <label class="kmk kmk--{{ $kurMk->kurikulum->prodi_id }} kmk--{{ $kurMk->kurikulum->prodi_id }}--{{$kurMk->semester}} kurmk-item hiddena items-center space-x-2 rounded cursor-pointer px-2 py-1
             hover:bg-gray-100 dark:hover:bg-yellow-900" data-prodi-id="{{ $kurMk->kurikulum->prodi_id }}">
    <input type="radio" name="kur_mk_id" value="{{ $kurMk->id }}" data-nama="{{ $kurMk->mk->nama }}" class="h-4 w-4 border-gray-300 text-blue-600
             focus:ring-2 focus:ring-blue-500
             dark:border-gray-600 dark:bg-gray-900 dark:text-blue-500
             dark:focus:ring-blue-400">

    <span class="text-sm text-gray-700 dark:text-gray-200">
      {{ $kurMk->mk->nama }}
      <span class="text-xs text-gray-500 dark:text-gray-400">
        ({{ $kurMk->mk->sks }} SKS)
      </span>
    </span>
  </label>
  @empty
  <div class="flex items-center justify-center h-full text-sm text-gray-500 dark:text-gray-400 italic">
    Tidak ada MK yang tersedia
  </div>
  @endforelse
</div>

{{-- placeholder saat belum pilih prodi --}}
<div id="kurmk-empty" class="mt-3 text-sm text-gray-500 dark:text-gray-400 italic">
  Silahkan pilih prodi terlebih dahulu.
</div>






















<script>
  $(document).ready(function () {

    let semester = null;
    let prodiId = null;
    let fakultasId = null;
    let target = null;
    let jumlah_kelas = 0;
    let arr_kelas = [];

    const clsActive  = 'bg-yellow-500 text-black border-yellow-500';
    const clsDefault = 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-700';

    function showMe(){
      // reset pilihan mk/kelas
      $('input[name="kur_mk_id"]').prop('checked', false);
      $('.cb_kelas').prop('checked', false);
      
      $('.kmk').hide();
      $('.fakultas').hide();
      $('.label_kelas').hide();
      $('#kurmk-empty').hide()

      $('#fakultas--'+fakultasId).show();
      
      if(semester){
        $('.label_kelas--'+prodiId+'--'+semester).show();
        target = $('.kmk--'+prodiId+'--'+semester);
        if(target.length){
          target.show()
        }else{
          $('#kurmk-empty').text(`MK belum tersedia, silahkan pilih Prodi/Semester lainnya.`)
          $('#kurmk-empty').show()
        }
      }else{
        $('.kmk--'+prodiId).show();
        $('.label_kelas--'+prodiId).show();
      }

      $("#selected_mk_box").stop(true, true).slideUp(160);
      // console.log('showMe',' - semester: ',semester,' - prodiId: ',prodiId, ' - fakultasId: ',fakultasId);

    }

    $('.btn-prodi').on('click', function () {
      prodiId = $(this).data('prodi-id');
      fakultasId = $(this).data('fakultas-id');
      $('.btn-prodi').removeClass(clsActive).addClass(clsDefault);
      $(this).removeClass(clsDefault).addClass(clsActive);
      showMe();
    });

    $('.btn-semester').on('click', function () {
      semester = $(this).data('semester');
      $('.btn-semester').removeClass(clsActive).addClass(clsDefault);
      $(this).removeClass(clsDefault).addClass(clsActive);
      showMe();
    });


    $('.label_kelas').on('click', function () {
      jumlah_kelas = 0;
      arr_kelas = []; // reset setiap klik

      $('.cb_kelas').each((index, el) => {
        if ($(el).is(':checked')) {
          jumlah_kelas++;

          // ambil label dari data attribute
          arr_kelas.push($(el).data('kelas-label'));
        }
      });

      $("#selected_kelas").text(arr_kelas.join(', '));
      console.log('jumlah_kelas', jumlah_kelas);
      console.log('arr_kelas', arr_kelas);
    });


    // $('.cb_kelas').click(function () {
    //   let jumlah_kelas = $('.cb_kelas:checked').length;
    //   console.log('jumlah_kelas2', jumlah_kelas);
    // });


    $('.btn-semester').first().trigger('click');
  });
</script>