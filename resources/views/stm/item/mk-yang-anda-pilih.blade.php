{{-- Floating Selected MK (Top Center) --}}
<div id="selected_mk_box" class="hidden fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-lg">

  {{-- <div class="rounded-2xl border border-gray-200 bg-white shadow-lg p-4
              dark:border-gray-700 dark:bg-gray-900"> --}}

    <div class="rounded-2xl border-2 border-yellow-500 bg-white shadow-lg p-4
               dark:bg-gray-900">

      <div class="flex items-start justify-between gap-3">
        <div class="space-y-1">
          <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            MK yang Anda pilih
          </div>

          <div id="selected_mk" class="text-sm font-bold text-gray-900 dark:text-gray-100">
            MK ?
          </div>

          <div class="pt-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            Kelas:
          </div>

          <div id="selected_kelas" class="text-sm font-bold text-gray-900 dark:text-gray-100">
            <i>Ceklis salah satu Kelas...</i>
          </div>
        </div>

        <button type="button" id="btn_close_selected_mk" class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-xl
               text-gray-500 hover:text-gray-800 hover:bg-gray-100
               dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
          ✕
        </button>
      </div>

    </div>
  </div>

  <script>
    $(function() {
    function showSelectedMK(text) {
      $("#selected_mk").text(text ?? "MK ?");
      $("#selected_mk_box").stop(true, true).slideDown(160);
    }

    function hideSelectedMK() {
      $("#selected_mk_box").stop(true, true).slideUp(160);
    }

    // Saat pilih MK (radio)
    $(document).on("change", "input[type=radio][name=kur_mk_id]", function() {
      // Ambil label MK (rekomendasi: taruh data-nama di radio)
      const mkName = $(this).data("nama") ?? $(this).closest("label").text().trim();
      showSelectedMK(mkName);
    });

    // tombol close
    $("#btn_close_selected_mk").on("click", function() {
      hideSelectedMK();
    });
  });
  </script>