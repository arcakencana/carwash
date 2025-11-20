<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <title>Dinas Perindustrian dan Perdagangan Kota Batam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Pagination custom color */
        .pagination .active span {
            background-color: #2563eb !important;
            color: white !important;
            border-color: #2563eb !important;
        }
        .pagination a {
            color: #2563eb !important;
        }
        .pagination a:hover {
            background-color: #dbeafe !important;
        }

        /* Popup animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }
        .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
    </style>

    @stack('styles') 
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')

        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Flash Notification -->
        @if (session('success') || session('error') || session('info'))
        <div 
        id="alert"
        class="fixed top-20 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white
        transform transition-all duration-700 ease-in-out opacity-0 -translate-y-2
        @if (session('success')) bg-green-600 
        @elseif (session('error')) bg-red-600 
        @else bg-blue-600 @endif"
        >
        <span class="font-medium">
            {{ session('success') ?? session('error') ?? session('info') }}
        </span>
    </div>

    <script>
        const alertBox = document.getElementById('alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove('opacity-0', 'translate-y-[-10px]');
                alertBox.classList.add('opacity-100', 'translate-y-0');
            }, 100);

            setTimeout(() => {
                alertBox.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => alertBox.remove(), 700);
            }, 3000);
        }
    </script>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

</div>

<!-- 🔔 GLOBAL POPUP MODAL -->
<div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-80 sm:w-96 rounded-lg shadow-lg p-5 relative animate-fadeIn">

        <!-- Tombol X -->
        <button id="closeAlertIcon" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-3">Pemberitahuan</h3>
        <p id="alertMessage" class="text-gray-700"></p>

        <div class="mt-4 text-right">
            <button id="closeAlert" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Fungsi global untuk munculkan popup
    function showAlert(message) {
        $('#alertMessage').text(message);
        $('#alertModal').removeClass('hidden');
    }

    // Tombol close
    $(document).on('click', '#closeAlert, #closeAlertIcon', function() {
        $('#alertModal').addClass('hidden');
    });

    // Tutup kalau klik area luar
    $(document).on('click', function(e) {
        if ($(e.target).is('#alertModal')) {
            $('#alertModal').addClass('hidden');
        }
    });
</script>

<!-- Cloudflare Turnstile -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

@stack('scripts')

</body>
</html>
