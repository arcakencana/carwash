<x-guest-layout>
    <!-- Background full-page -->
    <div class="relative min-h-screen bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/background.png') }}');
        background-position: center top 0px;
        background-size: contain;">

        <!-- Overlay transparan -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex flex-col items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">SITEBUS MURAH</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">Dinas Perindustrian dan Perdagangan Kota Batam</p>
                </div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
            type="password"
            name="password"
            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Turnstile Captcha -->
            <div class="mt-4">
                <div class="cf-turnstile"
                data-sitekey="{{ config('services.turnstile.sitekey') }}"
                data-callback="turnstileLoginCallback">
            </div>

            <p id="turnstile-error" class="text-red-600 text-sm mt-1"></p>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>

<script>
    function turnstileLoginCallback(token) {
        // token muncul di sini saat captcha selesai
        window.loginTurnstileToken = token;
        console.log("Login Turnstile token:", token);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const form = document.querySelector('form[action="{{ route('login') }}"]');

        form.addEventListener('submit', function(e) {

            let token = window.turnstile ? window.turnstile.getResponse() : '';

            if (!token) {
                e.preventDefault();
                document.getElementById('turnstile-error').innerText =
                "Silakan selesaikan verifikasi Captcha.";
                return false;
            }

        // Tambahkan token sebagai hidden input
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cf-turnstile-response';
            input.value = token;
            form.appendChild(input);
        });

    });
</script>


</x-guest-layout>
