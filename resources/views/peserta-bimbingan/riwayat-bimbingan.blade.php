<div id="sesiBimbinganWrapper" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

  @foreach ($riwayatBimbingan as $index => $sesi)
  <div class="sesi-item {{ $index >= 3 ? 'hidden' : '' }}">
    <x-card-sesi-bimbingan :sesi="$sesi" />
  </div>
  @endforeach

  @if ($riwayatBimbingan->count() > 3)
  <div id="showAllWrapper" class="col-span-full text-center mt-2">
    <button id="btnShowAll" class="inline-flex items-center gap-2 px-3 py-1.5
                   text-sm font-medium
                   text-gray-700 dark:text-gray-300
                   rounded-lg
                   hover:bg-gray-100
                   dark:hover:bg-indigo-900/30
                   dark:hover:text-indigo-300
                   transition">
      <span>Show all</span>
      <span class="text-xs text-gray-400 dark:text-gray-500">
        ({{ $riwayatBimbingan->count() }})
      </span>
    </button>
  </div>
  @endif
</div>


<script>
  $(document).ready(function () {
    $('#btnShowAll').on('click', function () {
      $('.sesi-item.hidden').slideDown(300, function () {
        $(this).removeClass('hidden');
      });

      $('#showAllWrapper').fadeOut(200);
    });
  });
</script>