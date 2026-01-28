@if(isset($context) && $context)
<div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
  <div class="font-semibold mb-1 flex items-center gap-2">
    📘 Konteks Pembuatan Mata Kuliah
  </div>

  <div class="mb-4 text-sm">
    Redirect from
    <a href="{{ route('kurikulum.show', $context['kurikulum_id']) }}"
      class="font-semibold text-blue-600 hover:underline">
      {{ $context['nama_kurikulum'] }}
      @if(!empty($context['prodi']))
      (Prodi {{ $context['prodi'] }})
      @endif
    </a>
  </div>

  @if(!empty($context['semester']))
  <div class="mt-1">
    MK baru direkomendasikan untuk
    <span class="font-semibold">Semester {{ $context['semester'] }}</span>
  </div>
  @endif

  <div class="mt-2 text-xs text-blue-600">
    * Mata kuliah tetap bersifat lintas prodi dan dapat digunakan oleh prodi lain.
  </div>
</div>

{{-- keep context for redirect after store --}}
<input type="hidden" name="from" value="{{ $context['from'] }}">
<input type="hidden" name="kurikulum_id" value="{{ $context['kurikulum_id'] }}">
@if(!empty($context['semester']))
<input type="hidden" name="semester" value="{{ $context['semester'] }}">
@endif
@endif