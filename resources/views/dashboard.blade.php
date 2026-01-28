@php
$user = auth()->user();
// $role = $user->role->role_name ?? 'mhs';
$role_nama = $user->role->nama ?? 'Mhs';

$arr_sapaan = [
'mhs' => 'Selamat datang, pejuang akademik. Misi hari ini sudah menantimu.',
'dosen' => 'Selamat datang, komandan. Kendali perkuliahan dan bimbingan ada di tangan Anda.',
'akademik' => 'Selamat datang. Stabilitas sistem akademik hari ini bergantung pada Anda.',
'default' => 'Selamat datang kembali. Mari mulai aktivitas Anda.',
];

$sapaan = $arr_sapaan[$role] ?? $arr_sapaan['default'];


@endphp

<x-app-layout>
    <x-page-header title="Dashboard {{ucwords($role)}}"
        subtitle="Dashboard {{ucwords($role)}} TA.{{$tahunAktif}}/{{$semesterAktif}}" />

    <x-page-content>

        {{-- Welcome Card --}}
        <x-section>

            {{-- Header --}}
            <div class="mb-4">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    👋 Selamat Datang <span>{{ $user->properName() }}</span>
                </h3>

                <x-p class="text-sm text-gray-600 dark:text-gray-400">
                    Anda login sebagai
                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ $role_nama }}
                    </span>.
                    {{ $sapaan }}
                </x-p>
            </div>

            @if (isRole('mhs'))

            {{-- Progress Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                @if ($user->profile_completeness_progress<100) <div
                    class="hover:tracking-[0.5px] transition-all duration-200">
                    <a href="{{ route('profile.edit') }}">
                        <x-progress-bar label="Kelengkapan Akun" info="lengkapi ➡️"
                            :value="$user->profile_completeness_progress" />
                    </a>
            </div>
            @endif

            <div class="hover:tracking-[0.5px] transition-all duration-200">
                <a href="{{ route('mhs.index') }}">
                    <x-progress-bar label="Data Mahasiswa" info="lengkapi ➡️" />
                </a>
            </div>

            <div class="hover:tracking-[0.5px] transition-all duration-200">
                <a href="{{ route('presensi-mhs.index') }}">
                    <x-progress-bar label="Presensi Pekan Ini" info="lengkapi ➡️" />
                </a>
            </div>

            <div class="hover:tracking-[0.5px] transition-all duration-200">
                <a href="{{ route('jenis-bimbingan.index') }}">
                    <x-progress-bar label="Bimbingan Skripsi" info="lengkapi ➡️" />
                </a>
            </div>

            </div>

            @endif

        </x-section>

        @php
        $target_dashboard = "dashboard.dashboard-$role";
        @endphp

        {{-- @if (View::exists($target_dashboard)) --}}
        @if (0)
        @include($target_dashboard)
        @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
            <h3 class="text-lg font-semibold text-red-600">
                Dashboard belum tersedia
            </h3>
            <p class="text-gray-500 mt-2 mb-3">
                Dashboard untuk role <strong>{{ $role }}</strong> belum dibuat.
            </p>
            <a href="{{route('jenis-bimbingan.index')}}">
                <x-button>Dashboard Bimbingan</x-button>
            </a>
        </div>
        @endif
    </x-page-content>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-6">


        </div>
    </div>
</x-app-layout>