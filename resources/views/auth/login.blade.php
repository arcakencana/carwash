<x-guest-layout>
    <!-- Background warna default -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">

        <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800
        shadow-lg rounded-xl">

        <!-- Logo & Title -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 mb-2">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ env("APP_NAME") }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Action -->
                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600"
                        href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                    @endif

                    <x-primary-button class="px-6">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center text-xs text-gray-400">
                © {{ date('Y') }} CARWASH. All rights reserved.
            </div>
        </div>
    </div>

    {{-- Turnstile tetap --}}
    <script>
        function turnstileLoginCallback(token) {
            window.loginTurnstileToken = token;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('form[action="{{ route('login') }}"]');

            form.addEventListener('submit', function (e) {
                let token = window.turnstile ? window.turnstile.getResponse() : '';

                if (!token) {
                    e.preventDefault();
                    alert("Silakan selesaikan verifikasi Captcha.");
                    return false;
                }

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cf-turnstile-response';
                input.value = token;
                form.appendChild(input);
            });
        });
    </script>
</x-guest-layout>
