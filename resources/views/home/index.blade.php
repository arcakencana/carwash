<x-guest-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-200">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center space-x-3 mt-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                    <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">SITEBUS MURAH</span>
                </div>
                <p class="text-gray-100 text-lg mt-1">Dinas Perindustrian dan Perdagangan Kota Batam</p>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-1 py-10">

                {{-- Kegiatan Post Cards --}}
                <div class="grid">

                    @foreach($kegiatans as $kegiatan)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-xl transition">

                        @if($kegiatan->banner)
                        <img src="{{ asset('storage/'.$kegiatan->banner) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full object-cover">
                        @endif

                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $kegiatan->nama_kegiatan }}</h2>

                            <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                {{ $kegiatan->deskripsi }}
                            </p>

                            <p class="text-gray-500 text-sm">
                                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}
                            </p>

                            <p class="text-gray-500 text-sm">
                                <strong>Kuota:</strong> {{ $kegiatan->kuota_peserta }}
                            </p>

                            <a href="#" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- Pagination --}}
                <div class="mt-8 flex justify-center">
                    {{ $kegiatans->links() }}
                </div>

            </div>
        </div>

    </x-guest-layout>
