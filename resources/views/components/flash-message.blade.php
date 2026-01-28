@php
$flash = [
'success' => session('success') ?? (session('status') === 'profile-updated' ? 'Profil berhasil diperbarui' : null),
'error' => session('error'),
'warning' => session('warning'),
'info' => session('info'),
];
@endphp

{{-- ERROR --}}
@if ($flash['error'])
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition>
    <x-alert type="danger" title="Gagal">
        <div class="flex items-start justify-between gap-3">
            <div>⚠️ {{ $flash['error'] }}</div>
            <button @click="show=false" class="font-bold opacity-70 hover:opacity-100" aria-label="Close">✕</button>
        </div>
    </x-alert>
</div>
@endif

{{-- SUCCESS --}}
@if ($flash['success'])
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition>
    <x-alert type="success" title="Berhasil">
        <div class="flex items-start justify-between gap-3">
            <div>✅ {{ $flash['success'] }}</div>
            <button @click="show=false" class="font-bold opacity-70 hover:opacity-100" aria-label="Close">✕</button>
        </div>
    </x-alert>
</div>
@endif

{{-- WARNING --}}
@if ($flash['warning'])
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition>
    <x-alert type="warning" title="Perhatian">
        <div class="flex items-start justify-between gap-3">
            <div>⚠️ {{ $flash['warning'] }}</div>
            <button @click="show=false" class="font-bold opacity-70 hover:opacity-100" aria-label="Close">✕</button>
        </div>
    </x-alert>
</div>
@endif

{{-- INFO --}}
@if ($flash['info'])
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition>
    <x-alert type="info" title="Info">
        <div class="flex items-start justify-between gap-3">
            <div>ℹ️ {{ $flash['info'] }}</div>
            <button @click="show=false" class="font-bold opacity-70 hover:opacity-100" aria-label="Close">✕</button>
        </div>
    </x-alert>
</div>
@endif

{{-- VALIDATION ERRORS --}}
@if ($errors->any())
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" x-transition>
    <x-alert type="danger" title="Validasi gagal">
        <div class="flex items-start justify-between gap-3">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button @click="show=false" class="font-bold opacity-70 hover:opacity-100" aria-label="Close">✕</button>
        </div>
    </x-alert>
</div>
@endif