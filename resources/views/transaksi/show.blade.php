    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi #{{ $transaksi->kode_transaksi }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-5xl mx-auto">
            <div class="bg-white p-6 rounded shadow">
                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full border border-gray-200 rounded">
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2 font-semibold w-1/5">User Transaksi</td>
                                <td class="p-2">: {{ $transaksi->user->name }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-semibold">Kode Transaksi</td>
                                <td class="p-2">: {{ $transaksi->kode_transaksi }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-semibold">No Pelat Kendaraan</td>
                                <td class="p-2">: {{ $transaksi->no_polisi }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-semibold">No Whatsapp</td>
                                <td class="p-2">: {{ $transaksi->no_wa }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Items</th>
                                    <th class="p-2 text-left">Harga</th>
                                    <th class="p-2 text-left">Qty</th>
                                    <th class="p-2 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="p-2">{{ $item->barang->nama }}</td>
                                    <td class="p-2">{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="p-2">{{ $item->qty }}</td>
                                    <td class="p-2">{{ number_format($item->harga * $item->qty, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <h3 class="font-semibold text-lg">
                        Total: 
                        {{ number_format($items->sum(fn($i) => $i->harga * $i->qty), 0, ',', '.') }}
                    </h3>
                </div>

                <a href="{{ route('transaksi.index') }}" class="inline-block mb-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    ← Kembali ke Daftar Transaksi
                </a>

            </div>
        </div>
    </x-app-layout>
