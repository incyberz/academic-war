<x-app-layout>
  <x-page-header title="Page Header" subtitle="..." />

  <x-page-content>
    <x-alert type="danger" title="title">alert</x-alert>
    <x-card>
      <x-card-header>Card Header</x-card-header>
      <x-card-body>
        card body
        <x-label class="required">label</x-label>
        <x-input />
        <x-textarea>text area</x-textarea>
        <x-select>
          <option value="">-- Pilih --</option>
        </x-select>
        <x-button btn=primary>Primary</x-button>
      </x-card-body>
    </x-card>
    <table></table>
    {{-- semua tag table dan childs tanpa classes --}}
  </x-page-content>
</x-app-layout>