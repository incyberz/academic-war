<x-grid id="bimbinganCounts">
  {{-- Perlu Review --}}
  @php
  $hasReview = ($bimbinganCounts['perlu_review'] ?? 0) > 0;
  @endphp

  <div id="counts-item--review" class="cursor-pointer counts-item p-4 rounded-lg border text-white
                  {{ $hasReview
                      ? 'bg-rose-600 border-rose-500'
                      : 'bg-gray-100 text-gray-500 border-gray-200
                         dark:bg-slate-800 dark:text-gray-400 dark:border-gray-700' }}">
    <p class="text-sm opacity-90">Perlu Review</p>
    <p id="perlu_review" class="mt-1 text-2xl font-semibold">
      {{ $bimbinganCounts['perlu_review'] ?? 0 }}
    </p>
  </div>

  {{-- Perlu Revisi --}}
  @php
  $hasRevisi = ($bimbinganCounts['perlu_revisi'] ?? 0) > 0;
  @endphp

  <div id="counts-item--revisi" class="cursor-pointer counts-item p-4 rounded-lg border text-white
                    {{ $hasRevisi
                        ? 'bg-amber-500 border-amber-400'
                        : 'bg-gray-100 text-gray-500 border-gray-200
                           dark:bg-slate-800 dark:text-gray-400 dark:border-gray-700' }}">
    <p class="text-sm opacity-90">Perlu Revisi</p>
    <p id="perlu_revisi" class="mt-1 text-2xl font-semibold">
      {{ $bimbinganCounts['perlu_revisi'] ?? 0 }}
    </p>
  </div>

  {{-- Laporan Disetujui --}}
  <div id="counts-item--disetujui" class="cursor-pointer counts-item p-4 rounded-lg border
              bg-emerald-600 text-white
              border-emerald-500">
    <p class="text-sm opacity-90">Laporan Disetujui</p>
    <p id="laporan_disetujui" class="mt-1 text-2xl font-semibold">
      {{ $bimbinganCounts['disetujui'] ?? 0 }}
    </p>
  </div>

  {{-- Total Laporan --}}
  <div id="counts-item--total" class="cursor-pointer counts-item p-4 rounded-lg border
              bg-indigo-600 text-white
              border-indigo-500">
    <p class="text-sm opacity-90">Total Laporan</p>
    <p id="total_laporan" class="mt-1 text-2xl font-semibold">
      {{ $bimbinganCounts['total_laporan'] ?? 0 }}
    </p>
  </div>

</x-grid>

<style>
  #bimbinganCounts .counts-item {
    transition: .3s;
    opacity: 90%;
  }

  #bimbinganCounts .counts-item:hover {
    letter-spacing: .5px;
    opacity: 100%;
  }
</style>


<script>
  $(function () {

    const map = {
      review: [1],
      revisi: [-1, -2],
      disetujui: [2, 3, 4],
      total: 'all'
    }

    $('.counts-item').on('click', function () {

      let key = $(this).prop('id').split('--')[1]
      let statuses = map[key]

      $('.card-riwayat').each(function () {
        let status = parseInt($(this).data('status'))

        if (statuses === 'all' || statuses.includes(status)) {
          $(this).stop(true, true).slideDown()
        } else {
          $(this).stop(true, true).slideUp()
        }
      })

    })

  })
</script>