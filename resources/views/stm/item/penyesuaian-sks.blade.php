<x-card>
  <x-card-header class="flex items-center justify-between">
    <span class="flex items-center gap-3">
      <span class="step-no">3</span>
      <span class="step leading-tight">Penyesuaian SKS (opsional)</span>
    </span>

    <a href="{{ route('mk.index') }}" class="shrink-0" onclick="return confirm(`Menuju daftar MK?`)">
      <x-button type="button" :outline="true" size="sm">Daftar MK</x-button>
    </a>
  </x-card-header>

  <x-card-body class="h-80 overflow-y-auto space-y-4">

    {{-- Info --}}
    <div class="rounded-xl border border-blue-200 bg-blue-50 p-3
                dark:border-blue-900/60 dark:bg-blue-950/30">
      <div class="flex items-start justify-between gap-3">
        <p class="text-sm text-blue-900 dark:text-blue-100 leading-relaxed">
          SKS pada MK terpilih adalah
          <span id="sks_mk" class="font-bold">?</span> SKS.
          Jika ada penyesuaian, silakan klik tombol di samping.
        </p>

        <button type="button" id="btn_toggle_sks" class="shrink-0 inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold
                 bg-blue-600 text-white hover:bg-blue-700
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                 dark:focus:ring-offset-gray-900">
          Sesuaikan
        </button>
      </div>
    </div>

    {{-- Panel Penyesuaian --}}
    <div id="blok_penyesuaian_sks" class="hidden rounded-xl border border-gray-200 bg-white p-4 space-y-4
             dark:border-gray-700 dark:bg-gray-900">

      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
            Penyesuaian SKS
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Opsional. Jika kosong, sistem akan mengikuti SKS default dari MK.
          </div>
        </div>

        <button type="button" id="btn_batal_sks" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold
                 border border-gray-300 text-gray-700 hover:bg-gray-50
                 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
          Batal
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- SKS Tugas --}}
        <div class="space-y-1">
          <x-label for="sks_tugas">SKS Tugas</x-label>
          <x-input id="sks_tugas" type="number" name="sks_tugas" min="0" value="{{ old('sks_tugas') }}" />
          <p class="text-xs text-gray-500 dark:text-gray-400">
            SKS yang tertera pada STM yang akan disahkan.
          </p>
        </div>

        {{-- SKS Beban --}}
        <div class="space-y-1">
          <x-label for="sks_beban">SKS Beban</x-label>
          <x-input id="sks_beban" type="number" name="sks_beban" min="0" value="{{ old('sks_beban') }}" />
          <p class="text-xs text-gray-500 dark:text-gray-400">
            SKS penyesuaian untuk input BKD.
          </p>
        </div>

        {{-- SKS Honor --}}
        <div class="space-y-1">
          <x-label for="sks_honor">SKS Honor</x-label>
          <x-input id="sks_honor" type="number" name="sks_honor" min="0" value="{{ old('sks_honor') }}" />
          <p class="text-xs text-gray-500 dark:text-gray-400">
            SKS untuk perhitungan honor/insentif.
          </p>
        </div>

      </div>

      <div class="flex justify-end pt-2">
        <button type="button" id="btn_simpan_sks" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                 bg-emerald-600 text-white hover:bg-emerald-700">
          Simpan Penyesuaian
        </button>
      </div>
    </div>

    <script>
      $(function() {
        function togglePanel(open = null) {
          const $panel = $("#blok_penyesuaian_sks");
          const isOpen = $panel.is(":visible");
          const next = (open === null) ? !isOpen : open;
  
          if (next) {
            $panel.slideDown(180);
            $("#btn_toggle_sks").text("Sembunyikan");
          } else {
            $panel.slideUp(180);
            $("#btn_toggle_sks").text("Sesuaikan");
          }
        }
  
        $("#btn_toggle_sks").on("click", function() {
          togglePanel();
        });
  
        $("#btn_batal_sks").on("click", function() {
          togglePanel(false);
        });
      });
    </script>

  </x-card-body>
</x-card>