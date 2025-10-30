<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Pagination custom color */
        .pagination .active span {
            background-color: #2563eb !important; /* biru-600 */
            color: white !important;
            border-color: #2563eb !important;
        }
        .pagination a {
            color: #2563eb !important;
        }
        .pagination a:hover {
            background-color: #dbeafe !important; /* biru muda hover */
        }
    </style>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- 🔔 Flash Message (dengan icon & animasi) -->
        @if (session('success') || session('error') || session('info'))
        <div 
        id="alert"
        class="fixed top-20 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white
        transform transition-all duration-700 ease-in-out opacity-0 -translate-y-2
        @if (session('success')) bg-green-600 
        @elseif (session('error')) bg-red-600 
        @else bg-blue-600 @endif"
        >
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" 
        class="w-5 h-5 flex-shrink-0"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        @if (session('success'))
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        @elseif (session('error'))
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        @else
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M12 4h.01" />
        @endif
    </svg>

    <!-- Pesan -->
    <span class="font-medium">
        {{ session('success') ?? session('error') ?? session('info') }}
    </span>
</div>

<script>
    const alertBox = document.getElementById('alert');
    if (alertBox) {
            // Fade-in animasi
        setTimeout(() => {
            alertBox.classList.remove('opacity-0', 'translate-y-[-10px]');
            alertBox.classList.add('opacity-100', 'translate-y-0');
        }, 100);

            // Auto close setelah 3 detik
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
</body>
</html>
