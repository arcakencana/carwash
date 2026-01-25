<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Dashboard Admin
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Transaksi -->
        <div class="bg-white p-5 rounded shadow">
          <p class="text-gray-500 text-sm">Total Transaksi</p>
          <h3 class="text-2xl font-bold">
            {{ $totalTransaksi }}
          </h3>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white p-5 rounded shadow">
          <p class="text-gray-500 text-sm">Total Pendapatan</p>
          <h3 class="text-2xl font-bold text-green-600">
            Rp {{ number_format($totalPendapatan) }}
          </h3>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white p-5 rounded shadow">
          <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
          <h3 class="text-2xl font-bold">
            {{ $transaksiHariIni }}
          </h3>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-white p-5 rounded shadow">
          <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
          <h3 class="text-2xl font-bold text-blue-600">
            Rp {{ number_format($pendapatanHariIni) }}
          </h3>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>
