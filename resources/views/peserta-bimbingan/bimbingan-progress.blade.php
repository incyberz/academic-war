@php $infoTahapan = $pesertaBimbingan->tahapanBimbingan->nama_tahapan ?? 'Baru Bimbingan'@endphp
<x-progress-bar animated label='Progress Bimbingan' value='{{$pesertaBimbingan->progress}}' info='{{$infoTahapan}}'
  class="pbar_toggle cursor-pointer transition-all duration-300 opacity-90 hover:opacity-100 hover:tracking-[0.5px]" />


<div id="info_tahapan" class="hidden cursor-not-allowed pbar_toggle">
  @php
  $currentTahapanId = $pesertaBimbingan->current_tahapan_bimbingan_id ?? null;
  @endphp

  <div class="space-y-3">
    @forelse ($tahapanBimbingan as $item)
    @php
    if (!$currentTahapanId) {
    $status = 'pending';
    } elseif ($item->id == $currentTahapanId) {
    $status = 'current';
    } elseif ($item->urutan < optional( $tahapanBimbingan->firstWhere('id', $currentTahapanId)
      )->urutan) {
      $status = 'done';
      } else {
      $status = 'pending';
      }
      @endphp

      <div class=" flex items-center gap-3 p-3 rounded-lg border
                    @if($status === 'done')
                        bg-emerald-50 border-emerald-300 dark:bg-emerald-900/30 dark:border-emerald-700
                    @elseif($status === 'current')
                        bg-amber-50 border-amber-300 dark:bg-amber-900/30 dark:border-amber-700
                    @else
                        bg-gray-50 border-gray-200 dark:bg-gray-900 dark:border-gray-700
                    @endif
                ">
        {{-- Icon --}}
        <div class="flex-shrink-0">
          @if($status === 'done')
          <span class="text-emerald-600 dark:text-emerald-400">✔</span>
          @elseif($status === 'current')
          <span class="text-amber-600 dark:text-amber-400">▶</span>
          @else
          <span class="text-gray-400">○</span>
          @endif
        </div>

        {{-- Content --}}
        <div>
          <div class="font-medium">
            Tahap {{ $item->urutan }} — {{ $item->nama_tahapan }}
          </div>

          <div class="text-xs text-gray-500 dark:text-gray-400">
            @if($status === 'done')
            Tahapan telah diselesaikan
            @elseif($status === 'current')
            Tahapan aktif saat ini
            @else
            Menunggu tahapan sebelumnya
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="text-sm text-gray-500 italic">
        Informasi tahapan bimbingan belum tersedia.
      </div>
      @endforelse
  </div>
</div>


<script>
  $('.pbar_toggle').click(function(){
    $('#info_tahapan').slideToggle()
  })
</script>