{{-- caller: BimbinganController --}}
{{-- ress: $myJenisBimbingan --}}
{{-- current: $bimbingan->jenis_bimbingan_id --}}

<div class="mb-3">
  {{-- Tabs Navigation --}}
  <div class="flex flex-wrap gap-2" id="jenis-tabs">
    @foreach ($myJenisBimbingan as $jenis)
    <button type="button" data-target="#tab-{{ $jenis->id }}" class="tab-btn
            px-3 py-2 text-xs font-semibold
            border-b-2 transition-all duration-200
            {{ $jenis->id == $bimbingan->jenis_bimbingan_id
                ? 'border-blue-600 text-blue-600
                   dark:border-blue-400 dark:text-blue-400 '
                : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-300
                   dark:text-gray-300 dark:hover:text-blue-400'
            }}">

      {{ strtoupper($jenis->kode) }}
    </button>
    @endforeach
  </div>

</div>


<script>
  $(document).ready(function () {

    $('.tab-btn').on('click', function () {

        let target = $(this).data('target');

        // Reset all tabs
        $('.tab-btn')
            .removeClass('border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400')
            .addClass('border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-300 dark:text-gray-300 dark:hover:text-blue-400');

        // Activate clicked tab
        $(this)
            .addClass('border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400')
            .removeClass('border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-300 dark:text-gray-300 dark:hover:text-blue-400');

        // Hide all contents
        $('.tab-content').slideUp();

        // Show selected content
        $(target).slideDown();
    });

});
</script>