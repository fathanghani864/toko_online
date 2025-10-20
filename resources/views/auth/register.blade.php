<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-6">
            <x-input-label :value="('Pilih Role')" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <!-- Pengguna -->
                <label class="flex items-start justify-between p-4 border rounded-lg cursor-pointer hover:border-indigo-500">
                    <div>
                        <span class="font-semibold">Pengguna</span>
                        <p class="text-sm text-gray-600">Akun untuk membeli produk dan menggunakan layanan.</p>
                    </div>
                    <input type="radio" name="role" value="pengguna" class="mt-1" required>
                </label>

                <!-- Penjual -->
                <label class="flex items-start justify-between p-4 border rounded-lg cursor-pointer hover:border-indigo-500">
                    <div>
                        <span class="font-semibold">Penjual</span>
                        <p class="text-sm text-gray-600">Akun untuk menjual produk dan mengelola toko.</p>
                    </div>
                    <input type="radio" name="role" value="seller" class="mt-1" required>
                </label>
            </div>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>