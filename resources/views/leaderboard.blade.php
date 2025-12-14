<hr>

@php
$best_players = [
['rank' => 1, 'nama' => 'Ahmad Firdaus', 'poin' => 13765],
['rank' => 2, 'nama' => 'Siti Aisyah', 'poin' => 12980],
['rank' => 3, 'nama' => 'Muhammad Rizki', 'poin' => 11840],
['rank' => 4, 'nama' => 'Nurul Huda', 'poin' => 11020],
['rank' => 5, 'nama' => 'Dimas Pratama', 'poin' => 10450],
['rank' => 6, 'nama' => 'Fajar Ramadhan', 'poin' => 9950],
['rank' => 7, 'nama' => 'Intan Permata', 'poin' => 9320],
['rank' => 8, 'nama' => 'Rian Saputra', 'poin' => 9010],
['rank' => 9, 'nama' => 'Dewi Lestari', 'poin' => 8725],
['rank' => 10,'nama' => 'Bagus Kurniawan', 'poin' => 8450],
];
@endphp

<div class="text-center flex flex-col gap-4 maxw-md mx-auto">
  <div class="py-4">
    <h1 class="text-4xl font-bold">
      🏆 Leaderboard Top 10
    </h1>
  </div>

  <div class="overflow-hidden rounded-lg border border-gray-700">
    <table class="w-full text-sm">
      <thead class="">
        <tr>
          <th class="py-2 px-3">Rank</th>
          <th class="py-2 px-3 text-left">Nama</th>
          <th class="py-2 px-3 text-right">Poin</th>
        </tr>
      </thead>

      <tbody class="bg-gray-800 text-white">
        @foreach ($best_players as $player)
        @php
        $rank = $player['rank'];
        $medal = match($rank) {
        1 => '🥇',
        2 => '🥈',
        3 => '🥉',
        default => '🟢',
        };

        $rowClass = match($rank) {
        1 => 'bg-yellow-500/10 font-bold',
        2 => 'bg-gray-400/10',
        3 => 'bg-orange-500/10',
        default => '',
        };
        @endphp

        <tr class="border-b border-gray-700 {{ $rowClass }}">
          <td class="py-2 px-3 text-center text-lg">
            {{ $rank }}
          </td>
          <td class="py-2 px-3 text-left">
            {{ $medal }} {{ $player['nama'] }}
          </td>
          <td class="py-2 px-3 text-right font-mono">
            {{ number_format($player['poin']) }} LP
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>