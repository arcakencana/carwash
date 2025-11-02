<x-guest-layout>
    <!-- Background full-page -->
    <div class="relative min-h-screen bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/background.png') }}');
        background-position: center top 0px;
        background-size: contain;">

        <!-- Overlay transparan biar teks tetap terbaca -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <!-- Konten utama -->
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <!-- Logo -->
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-200" />
            </a>

            <!-- Card putih di tengah -->
            <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white bg-opacity-95 shadow-lg rounded-lg overflow-hidden backdrop-blur-sm">

                <!-- Header -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center space-x-3 mt-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <span class="text-2xl font-bold text-gray-900">SITEBUS MURAH</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-900 text-sm mt-1">
                        Dinas Perindustrian dan Perdagangan Kota Batam
                    </p>
                </div>

                <!-- Daftar kegiatan -->
                <div class="max-w-7xl mx-auto px-1 sm:px-1 lg:px-1 py-6">
                    <div class="grid gap-4">
                        @foreach($kegiatans as $kegiatan)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-xl transition duration-300">

                            @if($kegiatan->banner)
                            <img src="{{ asset('storage/'.$kegiatan->banner) }}"
                            alt="{{ $kegiatan->nama_kegiatan }}"
                            class="w-full object-cover h-48 p-1">
                            @endif

                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800 mb-1 dark:text-gray-900">
                                    {{ $kegiatan->nama_kegiatan }}
                                </h2>

                                <p class="text-gray-600 dark:text-gray-800 text-sm mb-3 line-clamp-3">
                                    {{ $kegiatan->deskripsi }}
                                </p>

                                <p class="text-gray-500 text-xs mb-1">
                                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}
                                </p>

                                <p class="text-gray-500 text-xs mb-2">
                                    <strong>Kuota:</strong> {{ $kegiatan->kuota_peserta }}
                                </p>

                                <a href="{{ route('home.show', encrypt($kegiatan->id)) }}"
                                   class="mt-2 inline-block bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700 transition text-sm">
                                   Detail
                               </a>
                           </div>
                       </div>
                       @endforeach
                   </div>

                   <!-- Pagination -->
                   <div class="mt-8 flex justify-center">
                    {{ $kegiatans->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
