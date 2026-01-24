<x-app-layout>
  <x-page-header title="Daftar Quest Submission" subtitle="Lihat semua pengumpulan quest mahasiswa" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Quest Submission List
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Quest</th>
              <th class="border px-3 py-2">Mahasiswa</th>
              <th class="border px-3 py-2">Status</th>
              <th class="border px-3 py-2">XP</th>
              <th class="border px-3 py-2">Apresiasi XP</th>
              <th class="border px-3 py-2">Feedback</th>
              <th class="border px-3 py-2">Submitted At</th>
              <th class="border px-3 py-2">Approved At</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($submissions as $submission)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $submission->quest->judul ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $submission->mhs->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ ucfirst($submission->status) }}</td>
              <td class="border px-3 py-2">{{ $submission->quest->xp ?? 0 }}</td>
              <td class="border px-3 py-2">{{ $submission->apresiasi_xp }}</td>
              <td class="border px-3 py-2">{{ $submission->feedback ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $submission->submitted_at?->format('d/m/Y H:i') ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $submission->approved_at?->format('d/m/Y H:i') ?? '-' }}</td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning"
                  onclick="window.location='{{ route('quest_submission.edit', $submission->id) }}'">Edit</x-button>
                <form action="{{ route('quest_submission.destroy', $submission->id) }}" method="POST"
                  class="inline-block" onsubmit="return confirm('Hapus submission ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="10">Tidak ada submission</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $submissions->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>