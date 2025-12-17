@php
$user = auth()->user();
$role = $user->role;
$role_name = $user->roleRef->nama ?? 'Mhs';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <x-section class="">
                <h3 class="text-lg font-semibold mb-1">
                    👋 Selamat Datang {{$user->name}}!
                </h3>
                <x-p class="text-sm">
                    Anda login sebagai <span class="font-semibold">{{ $role_name }}</span>.
                    Silakan lengkapi data akademik Anda untuk mulai mengajar.
                </x-p>
            </x-section>

            @php
            $target_dashboard = "dashboard.dashboard-$role";
            @endphp

            @if (View::exists($target_dashboard))
            @include($target_dashboard)
            @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <h3 class="text-lg font-semibold text-red-600">
                    Dashboard belum tersedia
                </h3>
                <p class="text-gray-500 mt-2">
                    Dashboard untuk role <strong>{{ $role }}</strong> belum dibuat.
                </p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>