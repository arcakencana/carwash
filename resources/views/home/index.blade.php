<x-guest-layout>

    <div class="relative min-h-screen bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/background.png') }}');
        background-position: center top 0px;
        background-size: contain;">

        <!-- Overlay transparan -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>

        <!-- Konten utama -->
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2">

            <!-- Card utama (lebar diperbesar) -->
            <div class="w-full sm:max-w-xl mt-5 mb-8 px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">

                <!-- Header -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center space-x-3 mt-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <span class="text-3xl font-bold text-gray-800 dark:text-gray-900">SITEBUS MURAH</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-800 text-sm mt-1">
                        Dinas Perindustrian dan Perdagangan Kota Batam
                    </p>
                </div>

                <!-- Detail kegiatan -->
                <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-1 py-8">
                    <div class="grid">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-xl transition duration-300">

                            @if($kegiatans->banner)
                            <img src="{{ asset('storage/'.$kegiatans->banner) }}"
                            alt="{{ $kegiatans->nama_kegiatan }}"
                            class="w-full object-cover h-50 p-1">
                            @endif

                            <div class="p-4">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2 dark:text-gray-900">
                                    {{ $kegiatans->nama_kegiatan }}
                                </h2>

                                <p class="text-gray-600 dark:text-gray-800 text-sm mb-3 text-justify">
                                    {{ $kegiatans->deskripsi }}
                                </p>

                                <p class="text-gray-500 text-sm mb-1">
                                    <strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($kegiatans->tanggal_kegiatan)->format('d M Y, H:i') }}
                                </p>

                                <p class="text-gray-500 text-sm mb-3">
                                    <strong>Total Kuota :</strong> {{ number_format($kegiatans->kuota_peserta) }}
                                </p>
                            </div>

                            <hr class="border-gray-300 dark:border-gray-700">

                            <!-- QR Section -->
                            <div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900">
                                <div class="p-6 text-center">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                        Link Pendaftaran
                                    </h2>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url('/pendaftaran', encrypt($kegiatans->id))) }}"
                                    alt="QR Pendaftaran"
                                    class="mx-auto rounded-lg shadow-md p-2 bg-white">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
