<script>
  $(function(){
    let jenis_pilihan = null;
    let shift_id = null;
    let semester = null;
    let stm_item_id = null;
    let nama_mk = null;
    let singkatan_mk = null;
    let nama_shift = null;
    let kode_shift = null;
    let kode_kelas = null;
    let weekday = null;

    function update_ui(shift_id, semester,stm_item_id){
      if(shift_id && semester && stm_item_id){
        
        nama_mk = $('#nama_mk--'+stm_item_id).text();
        singkatan_mk = $('#singkatan_mk--'+stm_item_id).text();
        kode_kelas = $('#kode_kelas--'+stm_item_id).text();

        nama_shift = $('#nama_shift--'+shift_id).text();
        kode_shift = $('#kode_shift--'+shift_id).text();
        
        // update UI global
        $('.semester').text(semester);
        $('.nama_mk').text(nama_mk);
        $('.singkatan_mk').text(singkatan_mk);
        $('.nama_shift').text(nama_shift);
        $('.kode_shift').text(kode_shift);
        $('.kode_kelas').text(kode_kelas);

        // input hidden pada form
        $('.stm_item_id').val(stm_item_id);

        // show/hide pilihan sesi sesuai shift
        $('.pilihan_sesi').hide();
        $('.pilihan_sesi--'+shift_id).show();

        // show/hide section
        $('#blok_nav_mk').slideUp();
        $('#blok_selected_mk').slideDown();
        $('#blok_pilih_hari').slideDown();
        
        
        console.log('update ui',jenis_pilihan, shift_id, semester, stm_item_id,nama_mk,nama_shift
          ,kode_shift,singkatan_mk
        );
        
      }
    }

    function reset_ui(){
        $('#blok_nav_mk').slideDown();
        $('#blok_selected_mk').slideUp();
        $('#blok_pilih_hari').slideUp();
        $('.blok_sesi').hide();
        $('.pilihan_hari').prop('checked',0);
    }

    $('.pilihan').click(function(){
      jenis_pilihan = $(this).data('jenis_pilihan');
      
      if(jenis_pilihan=='mk'){
        stm_item_id = $(this).data('stm_item_id');
        semester = $(this).data('semester');
        shift_id = $(this).data('shift_id');
        update_ui(shift_id, semester,stm_item_id);
        
      }else if(jenis_pilihan=='hari'){
        weekday = $(this).data('weekday');
        $('.blok_sesi').hide();
        $('.blok_sesi--'+weekday).show();
      }else{
        alert(`Belum ada handler untuk jenis_pilihan [${jenis_pilihan}].` );
      }
    })
    $('#batalkan_mk').click(function(){reset_ui()})
  })
</script>