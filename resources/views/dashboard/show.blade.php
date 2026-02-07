<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi #{{ $transaksi->kode_transaksi }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <div class="overflow-x-auto mb-4">
                <table class="w-full min-w-[600px] border border-gray-200">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-2">User</th>
                            <th>No Pelat</th>
                            <th>Keterangan</th>
                            <th>No Whatsapp</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-2">{{ $transaksi->user->name }}</td>
                            <td>{{ $transaksi->no_polisi }}</td>
                            <td>{{ $transaksi->keterangan }}</td>
                            <td>{{ $transaksi->no_wa }}</td>
                            <td>{{ $transaksi->status ?? 'Belum Dibayar' }}</td>
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
                                <th class="p-2 text-left">Diskon</th>
                                <th class="p-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            @php
                            $harga = $item->harga;
                            $qty = $item->qty;
                            $subtotalAsli = $harga * $qty;
                            $diskon = $item->diskon;
                            @endphp
                            <tr class="border-t">
                                <td class="p-2">{{ $item->barang->nama }}</td>
                                <td class="p-2">Rp {{ number_format($harga,0,',','.') }}</td>
                                <td class="p-2">{{ $qty }}</td>
                                <td class="p-2 text-red-600">
                                    Rp {{ number_format($diskon,0,',','.') }}
                                </td>
                                <td class="p-2 font-semibold">
                                    Rp {{ number_format($subtotalAsli - $diskon,0,',','.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Total -->
            @php
            $total = $items->sum(fn($i) => $i->harga * $i->qty);
            $totalDiskon = $items->sum('diskon');
            $grandTotal = $total - $totalDiskon;
            @endphp

            <div class="mt-6 border-t pt-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <!-- TOTAL -->
                    <div class="text-right md:text-left space-y-1">
                        <div>Total : Rp {{ number_format($total,0,',','.') }}</div>
                        <div class="text-red-600">
                            Diskon : - Rp {{ number_format($totalDiskon,0,',','.') }}
                        </div>
                        <div class="font-bold text-xl">
                            Grand Total : Rp {{ number_format($grandTotal,0,',','.') }}
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-end">
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-center">
                            Kembali
                        </a>

                    </div>

                </div>
            </div>

        </x-app-layout>
