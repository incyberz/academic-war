@php
$ZZZ = true;
@endphp

@props([
'alert' => 'alert',
'description' => 'description',
])


@if(isSuperAdmin() || $ZZZ)
<x-card class="mb-6 border border-red-300 dark:border-red-800 super_admin">
    <x-card-header class="bg-red-50 dark:bg-red-950/40">
        <div class="flex items-start justify-between gap-3">
            <div>
                <div class="text-lg font-bold text-red-700 dark:text-red-300">
                    ⚠️ Super Admin Tools
                </div>
                <div class="text-sm text-red-600/90 dark:text-red-200/80">
                    {{ $description ?? 'Fitur ini hanya untuk Super Admin dan berisiko tinggi.' }}
                </div>
            </div>
            {{ $header ?? '' }}
        </div>
    </x-card-header>

    <x-card-body>
        @if($alert)
        <x-alert type="danger" title="Peringatan">
            {!! $alert !!}
        </x-alert>
        @endif

        {{ $slot }}
    </x-card-body>
</x-card>
@else
<x-card class="mb-6 border border-gray-300 dark:border-gray-700">
    <x-card-header class="bg-gray-50 dark:bg-gray-800/40">
        <div class="text-lg font-bold text-gray-700 dark:text-gray-200">
            ⚠️ Akses Terbatas
        </div>
    </x-card-header>
    <x-card-body>
        <x-alert type="warning" title="Tidak Bisa Akses">
            Role Anda bukan Super Admin.
        </x-alert>
        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Jika membutuhkan akses, silakan hubungi administrator sistem.
        </div>
    </x-card-body>
</x-card>
@endif