@php
$roles = [
[
'key' => 'mhs',
'label' => 'Mhs',
'avatar' => 'img/roles/mhs.png',
],
[
'key' => 'dosen',
'label' => 'Dosen',
'avatar' => 'img/roles/dosen.png',
],
[
'key' => 'praktisi',
'label' => 'Praktisi',
'avatar' => 'img/roles/praktisi.png',
],
[
'key' => 'mitra',
'label' => 'Mitra',
'avatar' => 'img/roles/mitra.png',
],
[
'key' => 'akademik',
'label' => 'Akademik',
'avatar' => 'img/roles/akademik.png',
],
];
@endphp

<div class="text-center flex flex-col gap-4">
  <h1 class="text-2xl font-bold mb-2 ">
    Welcome!
  </h1>
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">
    Pilih peran untuk login...
  </p>

  <div class="blok_roles">
    @foreach ($roles as $role)
    @php
    // if(strtolower($role['label'])=='mitra') continue;
    // if(strtolower($role['label'])=='praktisi') continue;

    @endphp
    <div class="group flex-shrink-0 cursor-pointer">
      <div class="bg-white dark:bg-gray-900/50 rounded-xl shadow hover:shadow-lg transition p-4 w-36 text-center">

        <img src="{{ asset($role['avatar']) }}" alt="{{ $role['label'] }}" class="img_role mx-auto">

        <div class="font-semibold  mt-2">
          {{ $role['label'] }}
        </div>

      </div>
    </div>
    @endforeach
  </div>
</div>















@php
$role = $_GET['role'] ?? 'mhs';
$roles = config('roles');
$role_label = $roles[$role]['label'] ?? '';
$role_deskripsi = $roles[$role]['deskripsi'] ?? "Role [$role] belum dibuat";
$role_color = $roles[$role]['color'] ?? 'text-white';
$role_gradient = $roles[$role]['gradient'] ?? 'bg-gray-600';
@endphp
<div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg mt-10 mb-10" style="z-index: 1000">
  {{-- Login Form --}}
  <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    {{-- Username/Email/WA --}}
    <div>
      <x-input-label for="login" :value="__('Username | Whatsapp | Email')" />
      <x-text-input id="login" class="block mt-1 w-full rounded-md shadow-sm" type="text" name="login"
        :value="old('login')" required autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('login')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div>
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" class="block mt-1 w-full rounded-md shadow-sm" type="password" name="password"
        required autocomplete="current-password" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Remember Me --}}
    <div class="flex items-center justify-between">
      <label class="inline-flex items-center">
        <input id="remember_me" type="checkbox"
          class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
          name="remember">
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
      </label>

      @if (Route::has('password.request'))
      <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
        {{ __('Forgot your password?') }}
      </a>
      @endif
    </div>

    {{-- Submit Button --}}
    <div>
      <x-button class="w-full py-2 {{$role_color}} {{$role_gradient}} text-center" id="btn_login">
        {{ __('Log in '.$role_label) }}
      </x-button>
    </div>
  </form>

  {{-- Session Status --}}
  <x-auth-session-status class="mt-4" :status="session('status')" />
</div>

{{-- Dev Login Include --}}
@include('auth.devlogin')