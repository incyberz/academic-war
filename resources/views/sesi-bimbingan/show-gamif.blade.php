@if ($pb->isMe())
<x-card>
  <x-card-header>
    🎯 Kontribusi Anda pada Sesi Ini
  </x-card-header>

  <x-card-body class="space-y-4 text-sm">

    {{-- Progress Bar Total --}}
    <div>
      <div class="flex items-center justify-between mb-1">
        <span class="text-gray-600 dark:text-gray-400">
          Progress Sesi
        </span>
        <span class="font-semibold text-indigo-600 dark:text-indigo-400">
          {{ $pb->sessionProgressPercent($sesi) }}%
        </span>
      </div>
      <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-2">
        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $pb->sessionProgressPercent($sesi) }}%">
        </div>
      </div>
    </div>

    {{-- Checklist Kontribusi --}}
    <ul class="space-y-2">

      {{-- 1. Upload + Pesan --}}
      <li class="flex items-start gap-2">
        <span>
          {!! $pb->checkIcon($pb->hasUploadAndMessage($sesi)) !!}
        </span>
        <div>
          <div class="font-medium">
            Upload laporan & pesan mahasiswa
            <span class="text-xs text-gray-500">( +125 XP )</span>
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Maks. 2 sesi valid per pekan
          </div>
        </div>
      </li>

      {{-- 2. Feedback Review --}}
      <li class="flex items-start gap-2">
        <span>
          {!! $pb->checkIcon($pb->hasFeedbackReview($sesi)) !!}
        </span>
        <div>
          <div class="font-medium">
            Memberi feedback atas review dosen
            <span class="text-xs text-gray-500">( +50 XP )</span>
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Setelah dosen memberi tanggapan
          </div>
        </div>
      </li>

      {{-- 3. Rating --}}
      <li class="flex items-start gap-2">
        <span>
          {!! $pb->checkIcon($pb->hasRating($sesi)) !!}
        </span>
        <div>
          <div class="font-medium">
            Memberi rating sesi (wajib)
            <span class="text-xs text-gray-500">( +25 XP )</span>
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Masukan bersifat opsional
          </div>
        </div>
      </li>

    </ul>

    {{-- Motivational / Guidance --}}
    <div class="pt-2 text-xs text-gray-500 dark:text-gray-400">
      {{ $pb->sessionMotivation($sesi) }}
    </div>

  </x-card-body>
</x-card>
@endif