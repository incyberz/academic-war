<script>
  $(function() {
    if ($('#whatsapp').length === 0) {
      alert('Belum ada id [whatsapp] untuk input form');
      return;
    }

    if ($('#btn_submit').length === 0) {
      alert('Belum ada id [btn_submit] untuk input form');
      return;
    }

    $('#whatsapp').on('input', function() {
      let val = $(this).val();

      val = val.replace(/[^0-9]/g, '');

      if (val.length >= 2) {
        if (val.startsWith('08')) {
          val = '628' + val.slice(2);
        } else if (!val.startsWith('62')) {
          val = '';
        }
      }

      $(this).val(val);

      if (val.length >= 11 && val.length <= 14) {
        $('#btn_submit').prop('disabled', false);
      } else {
        $('#btn_submit').prop('disabled', true);
      }
    });

  });
</script>