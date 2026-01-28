{{-- Progress Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

  @if ($user->profile_completeness_progress<100) <div class="hover:tracking-[0.5px] transition-all duration-200">
    <a href="{{ route('profile.edit') }}">
      <x-progress-bar label="Kelengkapan Akun" info="lengkapi ➡️" :value="$user->profile_completeness_progress" />
    </a>
</div>
@endif

<div class="hover:tracking-[0.5px] transition-all duration-200">
  <a href="{{ route('mhs.index') }}">
    <x-progress-bar label="Data Mahasiswa" info="lengkapi ➡️" />
  </a>
</div>

<div class="hover:tracking-[0.5px] transition-all duration-200">
  <a href="{{ route('presensi-mhs.index') }}">
    <x-progress-bar label="Presensi Pekan Ini" info="lengkapi ➡️" />
  </a>
</div>

<div class="hover:tracking-[0.5px] transition-all duration-200">
  <a href="{{ route('jenis-bimbingan.index') }}">
    <x-progress-bar label="Bimbingan Skripsi" info="lengkapi ➡️" />
  </a>
</div>

</div>