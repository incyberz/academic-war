{{-- caller: BimbinganController --}}
{{-- ress: $myJenisBimbingan --}}
{{-- current: $bimbingan->jenis_bimbingan_id --}}

<div class="mb-3">
  {{-- Tabs --}}
  <div class="flex flex-wrap gap-2" id="jenis-tabs">
    @foreach ($myJenisBimbingan as $jenis)
    <button type="button" data-target="#tab-{{ $jenis->id }}" class="tab-btn px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $jenis->id == $bimbingan->jenis_bimbingan_id
                    ? 'bg-blue-600 text-white shadow active'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }}">
      {{ $jenis->nama }}
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
            .removeClass('bg-blue-600 text-white shadow active')
            .addClass('bg-gray-100 text-gray-700');

        // Activate clicked tab
        $(this)
            .addClass('bg-blue-600 text-white shadow active')
            .removeClass('bg-gray-100 text-gray-700');

        // Hide all contents
        $('.tab-content').slideUp();

        // Show selected content
        $(target).slideDown();
    });

});
</script>