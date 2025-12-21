<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        {{-- USERNAME --}}
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" placeholder="username..."
                :value="old('username', $user->username)" minlength="3" maxlength="20" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="whatsapp" :value="__('WhatsApp')" />
            <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" placeholder="08xxxxxxxxxx"
                :value="old('whatsapp', $user->whatsapp)" minlength="11" maxlength="14" />
            <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
        </div>

        {{-- GENDER --}}
        <div>
            <x-input-label :value="__('Gender')" />

            <div class="mt-2 flex gap-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="radio" name="gender" value="L" class="text-indigo-600 focus:ring-indigo-500"
                        @checked(old('gender', $user->gender) === 'L')
                    >
                    Laki-laki
                </label>

                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="radio" name="gender" value="P" class="text-indigo-600 focus:ring-indigo-500"
                        @checked(old('gender', $user->gender) === 'P')
                    >
                    Perempuan
                </label>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- IMAGE --}}
        <div>
            <x-input-label for="avatar" :value="__('Profile Avatar')" />

            <div class="flex items-center gap-4 mt-2">
                @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Avatar"
                    class="w-16 h-16 rounded-full object-cover border">
                @endif

                <input id="avatar" name="avatar" type="file" accept="avatar/*" class="block w-full text-sm text-gray-700 dark:text-gray-300
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               dark:file:bg-indigo-900 dark:file:text-indigo-300
                               hover:file:bg-indigo-100" />
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>