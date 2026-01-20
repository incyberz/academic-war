<script>
  $(function() {
    $('#whatsapp').on('input', function() {
      let val = $(this).val();

      // 1️⃣ hanya angka 0-9
      val = val.replace(/[^0-9]/g, '');

      // 2️⃣ validasi awalan jika sudah >= 2 digit
      if (val.length >= 2) {

        // jika awalan 08 → ubah ke 628
        if (val.startsWith('08')) {
          val = '628' + val.slice(2);
        }

        // jika bukan 62 → reset
        else if (!val.startsWith('62')) {
          val = '';
        }
      }

      $(this).val(val);
    });
  });
</script>