{{-- gamifikasi-profil-akun.blade.php --}}
<section class="space-y-6">
  <header>
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
      {{ __('Gamifikasi Profil Akun') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Dapatkan Profile Integrity Bonus hingga 5% dengan melengkapi data akun Anda.') }}
    </p>
  </header>

  {{-- Progress --}}
  <div class="space-y-2">
    <x-progress-bar label="Kelengkapan Akun" :value="$user->profile_integrity_progress" />

    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
      Profile Integrity Bonus saat ini:
      <span class="font-semibold text-indigo-600 dark:text-indigo-400">
        {{ $user->profile_integrity_bonus }}%
      </span>
    </p>
  </div>

  {{-- Checklist --}}
  <ul class="space-y-3">
    @php
    $items = [
    [
    'label' => 'Kelengkapan akun dasar (gender, biodata)',
    'status' => $profilDasar ?? false,
    'bonus' => '1%',
    ],
    [
    'label' => 'Terverifikasi avatar dengan wajah asli',
    'status' => $avatar ?? false,
    'bonus' => '2%',
    ],
    [
    'label' => 'Verifikasi email',
    'status' => $emailVerified ?? false,
    'bonus' => '1%',
    ],
    [
    'label' => 'Verifikasi WhatsApp',
    'status' => $waVerified ?? false,
    'bonus' => '1%',
    ],
    [
    'label' => 'Melengkapi data alamat',
    'status' => $alamat ?? false,
    'bonus' => '1%',
    ],
    ];
    @endphp

    @foreach ($items as $item)
    <li class="flex items-center justify-between p-3 rounded-lg border
               {{ $item['status']
                    ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-700'
                    : 'bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700'
               }}">
      <div class="flex items-center gap-3">
        @if ($item['status'])
        {{-- Icon checked --}}
        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        @else
        {{-- Icon pending --}}
        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="9" />
        </svg>
        @endif

        <div>
          <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
            {{ $item['label'] }}
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            Bonus {{ $item['bonus'] }}
          </p>
        </div>
      </div>

      <span class="text-xs font-semibold px-3 py-1 rounded-full
                 {{ $item['status']
                      ? 'bg-green-600 text-white'
                      : 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300'
                 }}">
        {{ $item['status'] ? 'Selesai' : 'Belum' }}
      </span>
    </li>
    @endforeach
  </ul>

  {{-- Catatan --}}
  <div class="text-xs text-gray-500 dark:text-gray-400 italic">
    {{ __('Bonus maksimum Profile Integrity adalah 5% dan dihitung dari poin aktivitas.') }}
  </div>
</section>