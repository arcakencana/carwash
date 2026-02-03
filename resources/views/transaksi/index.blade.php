<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol tambah transaksi -->
            <div class="mb-4 flex flex-col sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('transaksi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition-colors text-center">
                    + Transaksi Baru
                </a>
            </div>

            <!-- Tabel -->
            <div class="bg-white shadow rounded p-4 overflow-x-auto">
                <table class="w-full min-w-[700px] border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left">Kode</th>
                            <th class="p-2 text-left">Tanggal</th>
                            <th class="p-2 text-left">No Pelat Kendaraan</th>
                            <th class="p-2 text-left">No Whatsapp</th>
                            <th class="p-2 text-left">Total</th>
                            <th class="p-2 text-left">Status</th>
                            <th class="p-2 text-left">User</th>
                            <th class="p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $trx)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2 font-bold">{{ $trx->kode_transaksi }}</td>
                            <td class="p-2">
                                {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                            </td>
                            <td class="p-2">{{ $trx->no_polisi }}</td>
                            <td class="p-2">{{ $trx->no_wa }}</td>
                            <td class="p-2 text-left font-semibold">
                                {{ number_format($trx->total_harga) }}
                            </td>
                            <td class="p-2 text-left font-semibold">
                                {{ $trx->status }}
                            </td>
                            <td class="p-2">{{ $trx->kasir->name ?? '-' }}</td>
                            <td class="p-2">
                                <a href="{{ route('transaksi.show', $trx->id) }}"
                                    class="text-blue-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $transaksis->links('vendor.pagination.custom') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
