@php
$role = $_GET['role'] ?? 'mhs';
$roles = config('roles');
$role_label = $roles[$role]['label'] ?? 'Undefined Role';
$role_deskripsi = $roles[$role]['deskripsi'] ?? "Role [$role] belum dibuat";
$role_color = $roles[$role]['color'] ?? 'text-white';
$role_gradient = $roles[$role]['gradient'] ?? 'bg-gray-600';
@endphp

<x-guest-layout>
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg mt-10">
        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold mb-2 {{$role_color}} {{$role_gradient}} inline-block px-4 py-2 rounded">
                Login as {{$role_label}}!
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                {{$role_deskripsi}}
            </p>
        </div>

        {{-- Role Image --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/roles/'.$role.'.png')}}" alt="role image"
                class="w-24 h-24 object-cover rounded-full shadow-md">
        </div>

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
                <x-text-input id="password" class="block mt-1 w-full rounded-md shadow-sm" type="password"
                    name="password" required autocomplete="current-password" />
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
                <x-primary-button class="w-full py-2 {{$role_color}} {{$role_gradient}} text-center" id="btn_login">
                    {{ __('Log in '.$role_label) }}
                </x-primary-button>
            </div>
        </form>

        {{-- Session Status --}}
        <x-auth-session-status class="mt-4" :status="session('status')" />

        {{-- Dev Login Include --}}
        @include('auth.devlogin')
    </div>
</x-guest-layout>