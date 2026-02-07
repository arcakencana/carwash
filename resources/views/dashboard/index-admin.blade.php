<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Dashboard Admin
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

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

      </div>

    </div>
  </div>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Tabel -->
    <div class="bg-white shadow rounded p-4 overflow-x-auto">
      <table class="w-full min-w-[700px] border text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 text-left">Kode</th>
            <th class="p-2 text-left">No Pelat</th>
            <th class="p-2 text-left">Keterangan</th>
            <th class="p-2 text-left">No Whatsapp</th>
            <th class="p-2 text-left">Total</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">User</th>
            <th class="p-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transaksi as $trx)
          <tr class="border-t hover:bg-gray-50">
            <td class="p-2 font-bold">{{ $trx->kode_transaksi }}</td>
            <td class="p-2">{{ $trx->no_polisi }}</td>
            <td class="p-2">{{ $trx->keterangan }}</td>
            <td class="p-2">{{ $trx->no_wa }}</td>
            <td class="p-2 text-left font-semibold">
              {{ number_format($trx->total_harga) }}
            </td>
            <td class="p-2 text-left font-semibold">
              {{ $trx->status }}
            </td>
            <td class="p-2">{{ $trx->kasir->name ?? '-' }}</td>
            <td class="p-2">
              <a href="{{ route('dashboard.show', $trx->id) }}" class="text-green-600 hover:underline">Detail</a>
              <span class="text-gray-400">|</span>
              <form action="{{ route('dashboard.destroy', ['transaksi' => $trx->id]) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus transaksi ini?')" class="text-red-600 hover:underline">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-4">
      {{ $transaksi->links('vendor.pagination.custom') }}
    </div>

  </div>

</x-app-layout>
