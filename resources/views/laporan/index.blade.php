<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-4">
                <form method="GET" class="flex gap-2 mb-4">
                    <input type="date" name="tanggal_awal" class="border p-2" required>
                    <input type="date" name="tanggal_akhir" class="border p-2" required>
                    <button class="bg-blue-600 text-white px-4 rounded">
                        Tampilkan
                    </button>
                    <a href="{{ route('laporan.export', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Export Excel
                    </a>
                </form>
            </div>

            @if(request('tanggal_awal') && request('tanggal_akhir'))
            <div class="mb-3 text-sm font-semibold text-gray-700">
                Laporan Transaksi Periode
                <span class="text-blue-600">
                    {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d M Y') }}
                </span>
                s/d
                <span class="text-blue-600">
                    {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y') }}
                </span>
            </div>
            @endif

            <div class="mt-6 bg-white shadow rounded p-4">
                <div class="overflow-x-auto">

                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-left">Nama Items</th>
                                <th class="p-2 text-left">Qty</th>
                                <th class="p-2 text-left">Modal</th>
                                <th class="p-2 text-left">Total</th>
                                <th class="p-2 text-left">Diskon</th>
                                <th class="p-2 text-left">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <tr>
                                <td class="p-2 text-left">{{ $row->nama }}</td>
                                <td class="p-2 text-left">{{ $row->total_qty }}</td>
                                <td class="p-2 text-left">{{ number_format($row->total_modal,0,',','.') }}</td>
                                <td class="p-2 text-left">{{ number_format($row->total_jual,0,',','.') }}</td>
                                <td class="p-2 text-left text-danger">
                                    -{{ number_format($row->total_diskon,0,',','.') }}
                                </td>
                                <td class="text-end fw-bold">
                                    {{ number_format($row->grand_total,0,',','.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td class="p-2 text-left">TOTAL</td>
                                <td class="p-2 text-left">{{ $data->sum('total_qty') }}</td>
                                <td class="p-2 text-left">{{ number_format($data->sum('total_modal'),0,',','.') }}</td>
                                <td class="p-2 text-left">{{ number_format($data->sum('total_jual'),0,',','.') }}</td>
                                <td class="p-2 text-left text-danger">
                                    -{{ number_format($data->sum('total_diskon'),0,',','.') }}
                                </td>
                                <td class="p-2 text-left">{{ number_format($data->sum('grand_total'),0,',','.') }}</td>
                            </tr>
                        </tfoot>

                    </table>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
