@if (session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="bg-red-100 border border-red-300 text-red-700
           px-4 py-3 rounded-lg text-sm mb-4
           flex items-start justify-between gap-3">
    <div>
        ⚠️ {{ session('error') }}
    </div>

    <button @click="show = false" class="text-red-500 hover:text-red-700 font-bold" aria-label="Close">
        ✕
    </button>
</div>
@endif


@if (session('success') || session('status'))
@php
$message = session('success')
?? match (session('status')) {
'profile-updated' => 'Profil berhasil diperbarui',
default => session('status'),
};
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="bg-green-100 border border-green-300 text-green-700
           dark:bg-green-900/30 dark:border-green-700 dark:text-green-300
           px-4 py-3 rounded-lg text-sm mb-4
           flex items-start justify-between gap-3">
    <div>
        ✅ {{ $message }}
    </div>

    <button @click="show = false" class="text-green-600 dark:text-green-400
               hover:text-green-800 dark:hover:text-green-200
               font-bold" aria-label="Close">
        ✕
    </button>
</div>
@endif