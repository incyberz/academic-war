<x-app-layout>
  <x-page-header title="Edit Course" subtitle="Edit identitas course serta tambah/hapus unit (sub-course)." />

  <x-page-content>

    {{-- Alert --}}
    @if (session('success'))
    <x-alert type="success" title="Berhasil">
      {{ session('success') }}
    </x-alert>
    @endif

    @if ($errors->any())
    <x-alert type="danger" title="Terjadi kesalahan">
      <ul>
        @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
      </ul>
    </x-alert>
    @endif

    {{-- Card: Edit Course --}}
    <x-card>
      <x-card-header>Identitas Course</x-card-header>

      <x-card-body>
        <form method="POST" action="{{ route('course.update', $course->id) }}">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <x-label class="required">Kode</x-label>
              <x-input name="kode" value="{{ old('kode', $course->kode) }}" />
            </div>

            <div>
              <x-label class="required">Nama</x-label>
              <x-input name="nama" value="{{ old('nama', $course->nama) }}" />
            </div>

            <div class="md:col-span-2">
              <x-label>Deskripsi</x-label>
              <x-textarea name="deskripsi">{{ old('deskripsi', $course->deskripsi) }}</x-textarea>
            </div>

            <div>
              <x-label class="required">Tipe</x-label>
              <x-select name="tipe">
                <option value="mk" @selected(old('tipe', $course->tipe) === 'mk')>mk</option>
                <option value="bidang" @selected(old('tipe', $course->tipe) === 'bidang')>bidang</option>
              </x-select>
            </div>

            <div>
              <x-label>Level</x-label>
              <x-input name="level" value="{{ old('level', $course->level) }}" />
            </div>

            <div class="md:col-span-2">
              <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course->is_active)) />
                <span>Aktif</span>
              </label>
            </div>

          </div>

          <div class="mt-4 flex justify-end">
            <x-button btn="primary" type="submit">Simpan Course</x-button>
          </div>
        </form>
      </x-card-body>
    </x-card>

    {{-- Card: Add Unit --}}
    <x-card>
      <x-card-header>Tambah Unit</x-card-header>

      <x-card-body>
        <form method="POST" action="{{ route('course.unit.store', $course->id) }}">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <x-label class="required">Kode Unit</x-label>
              <x-input name="kode" value="{{ old('kode') }}" />
            </div>

            <div>
              <x-label class="required">Nama Unit</x-label>
              <x-input name="nama" value="{{ old('nama') }}" />
            </div>

            <div class="md:col-span-2">
              <x-label>Deskripsi</x-label>
              <x-textarea name="deskripsi">{{ old('deskripsi') }}</x-textarea>
            </div>

            <div>
              <x-label>Urutan</x-label>
              <x-input type="number" min="1" name="urutan" value="{{ old('urutan') }}" />
            </div>

            <div class="flex items-center">
              <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="aktif" value="1" @checked(old('aktif', true)) />
                <span>Aktif</span>
              </label>
            </div>

          </div>

          <div class="mt-4 flex justify-end">
            <x-button btn="primary" type="submit">Tambah Unit</x-button>
          </div>
        </form>
      </x-card-body>
    </x-card>

    {{-- Table: Units --}}
    <x-card>
      <x-card-header>Daftar Unit</x-card-header>

      <x-card-body>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Urutan</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($course->units as $unit)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $unit->urutan }}</td>
              <td>{{ $unit->kode }}</td>
              <td>{{ $unit->nama }}</td>
              <td>{{ $unit->aktif ? 'Aktif' : 'Nonaktif' }}</td>
              <td>
                <form method="POST" action="{{ route('unit.destroy', $unit->id) }}"
                  onsubmit="return confirm('Hapus unit ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6">Belum ada unit.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </x-card-body>
    </x-card>

  </x-page-content>
</x-app-layout>