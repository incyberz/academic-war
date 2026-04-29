<form action="{{ route('checklists.store') }}" method="POST">
    @csrf

    {{-- polymorphic --}}
    <input type="hidden" name="checklistable_id" value="{{ $item->id }}" />
    <input
        type="hidden"
        name="checklistable_type"
        value="{{ get_class($item) }}"
    />

    <input
        name="after"
        type="hidden"
        value="{{ $item->checklists->count() }}"
    />

    <div class="flex gap-2 items-center flex-wrap">
        <x-input
            id="input-{{ $item->id }}"
            maxlength="255"
            minlength="10"
            name="pertanyaan"
            placeholder="Contoh: Saya sudah memahami peran admin sistem dalam aplikasi"
            required
        />

        <x-input
            class="w-20"
            max="100"
            min="10"
            name="poin"
            placeholder="10–100 Experience Points"
            required
            type="number"
            value="10"
        />

        <x-select name="is_wajib">
            <option value="1">🧱 ceklis ini wajib (prasyarat submit)</option>
            <option value="0">
                ⚔️ <i>this checklist is a challenge (optional)</i>
            </option>
        </x-select>

        <x-button btn="primary">+ Tambah</x-button>
    </div>
</form>
