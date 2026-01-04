<x-grid id="bimbinganCounts">
  {{-- Perlu Review --}}

  @php $hasReview = ($bimbinganCounts['perlu_review'] ?? 0) > 0; @endphp
  @php $hasRevisi = ($bimbinganCounts['perlu_revisi'] ?? 0) > 0; @endphp


  @if(isRole('dosen'))
  <x-count id="review" label="Perlu Review" :value="$bimbinganCounts['perlu_review'] ?? 0" :active="$hasReview"
    activeBg="rose-600" />

  <x-count id="revisi" label="Perlu Revisi" :value="$bimbinganCounts['perlu_revisi'] ?? 0" :active="$hasRevisi"
    activeBg="amber-500" />
  @endif

  @if(isRole('mhs'))
  <x-count id="revisi" label="Perlu Kamu Revisi" :value="$bimbinganCounts['perlu_revisi'] ?? 0" :active="$hasRevisi"
    activeBg="rose-600" />

  <x-count id="review" label="Sedang Proses" :value="$bimbinganCounts['perlu_review'] ?? 0" :active="$hasReview"
    activeBg="amber-500" />
  @endif


  <x-count id="disetujui" label="Selesai/Revised" :value="$bimbinganCounts['disetujui'] ?? 0" activeBg="emerald-600"
    :active="true" />

  <x-count id="total" label="Total Laporan" :value="$bimbinganCounts['total_laporan'] ?? 0" activeBg="indigo-600"
    :active="true" />

</x-grid>



<script>
  $(function () {

    const map = {
      review: [0,1],
      revisi: [-1, -100],
      disetujui: [2, 3, 100],
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