@php
$user = auth()->user();
// $role = $user->role->role_name ?? 'mhs';
$role_nama = $user->role->nama ?? 'Mhs';

@endphp

<x-app-layout>
    <x-page-header title="Dashboard {{ucwords($role)}}"
        subtitle="Dashboard {{ucwords($role)}} TA.{{$tahunAjarAktif}}/{{$semesterAktif}}" />

    <x-page-content>

        {{-- Welcome Card --}}
        <x-section>
            <h3 class="text-lg font-semibold mb-1">
                👋 Selamat Datang {{$user->name}}!
            </h3>
            <x-p class="text-sm">
                Anda login sebagai <span class="font-semibold">{{ $role_nama }}</span>.
                Silakan lengkapi data akademik Anda untuk mulai mengajar.
            </x-p>
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