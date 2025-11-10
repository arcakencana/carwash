<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-4 text-gray-700">Monitoring, {{ $kegiatans->nama_kegiatan }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                <div class="bg-white shadow rounded-lg p-5 border-l-4 border-green-500 hover:shadow-md transition flex items-center">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c.5 0 1 .5 1 1v6c0 .5-.5 1-1 1s-1-.5-1-1V9c0-.5.5-1 1-1zM8 12h8" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Kuota</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($kegiatans->kuota_peserta) }}</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-5 border-l-4 border-blue-500 hover:shadow-md transition flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Pendaftaran</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalPendaftaran) }}</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-5 border-l-4 border-yellow-500 hover:shadow-md transition flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Sisa Kuota</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($sisaKuota) }}</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-5 border-l-4 border-red-500 hover:shadow-md transition flex items-center">
                    <div class="p-3 bg-red-100 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V7a4 4 0 014-4h0a4 4 0 014 4v4m0 0h-8m0 0v6h8v-6" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Persentase Terisi</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $persentase }}%</p>
                        <div class="w-full bg-gray-200 h-2 rounded mt-2">
                            <div class="bg-red-500 h-2 rounded" style="width: {{ $persentase }}%;"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Chart Total Pendaftar Harian -->
            <div class="bg-white shadow rounded-lg p-6 mt-4">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Total Pendaftar Harian</h2>
                <canvas id="pendaftarChart" class="w-full h-64"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')

    <!-- Kirim data ke JS -->
    <script>
        window.pendaftarHarian = {
            labels: @json($tanggalHarian),
            data: @json($jumlahHarian)
        };
    </script>

    @vite('resources/js/dashboardChart.js')
    
    @endpush

</x-app-layout>
