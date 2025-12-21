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


@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="bg-green-100 border border-green-300 text-green-700
           px-4 py-3 rounded-lg text-sm mb-4
           flex items-start justify-between gap-3">
    <div>
        ✅ {{ session('success') }}
    </div>

    <button @click="show = false" class="text-green-600 hover:text-green-800 font-bold" aria-label="Close">
        ✕
    </button>
</div>
@endif