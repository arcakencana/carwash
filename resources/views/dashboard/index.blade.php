<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Total Pendaftaran -->
                <div class="flex items-center p-5 bg-blue-500 text-white rounded-xl shadow-md">
                    <div class="text-4xl opacity-80">
                        📄
                    </div>
                    <div class="ml-4">
                        <p class="text-sm uppercase font-semibold opacity-90">Total Pendaftaran</p>
                        <h3 class="text-3xl font-bold">{{ $total_pendaftaran }}</h3>
                    </div>
                </div>

                <!-- Total Terverifikasi -->
                <div class="flex items-center p-5 bg-green-500 text-white rounded-xl shadow-md">
                    <div class="text-4xl opacity-80">
                        ✔️
                    </div>
                    <div class="ml-4">
                        <p class="text-sm uppercase font-semibold opacity-90">Terverifikasi</p>
                        <h3 class="text-3xl font-bold">{{ $total_terverifikasi }}</h3>
                    </div>
                </div>

                <!-- Total Belum Verifikasi -->
                <div class="flex items-center p-5 bg-yellow-500 text-white rounded-xl shadow-md">
                    <div class="text-4xl opacity-80">
                        ⏳
                    </div>
                    <div class="ml-4">
                        <p class="text-sm uppercase font-semibold opacity-90">Belum Verifikasi</p>
                        <h3 class="text-3xl font-bold">{{ $total_belum }}</h3>
                    </div>
                </div>

                <!-- Total User -->
                <div class="flex items-center p-5 bg-red-500 text-white rounded-xl shadow-md">
                    <div class="text-4xl opacity-80">
                        👤
                    </div>
                    <div class="ml-4">
                        <p class="text-sm uppercase font-semibold opacity-90">Total User</p>
                        <h3 class="text-3xl font-bold">{{ $total_user }}</h3>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-4">Grafik Pendaftaran Harian</h2>
                <canvas id="pendaftaranChart" class="w-full"></canvas>
            </div>

        </div>
    </div>

    <script>
        window.API_URL = "{{ url('/api/dashboard/harian') }}";
    </script>
    
</x-app-layout>
