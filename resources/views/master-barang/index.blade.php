<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            {{ __('Master Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('master-barang.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Tambah
                </a>

                <form method="GET" action="{{ route('master-barang.index') }}" class="flex flex-wrap items-center gap-4">
                    <input type="text" name="search" placeholder="Cari..." value="{{ $search }}" class="border rounded p-2 focus:outline-none focus:ring focus:ring-blue-200">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            <div class="mt-6 bg-white shadow rounded p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 shadow-sm overflow-hidden text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 font-bold text-left">Nama</th>
                                <th class="py-3 px-4 font-bold text-left">Harga Modal</th>
                                <th class="py-3 px-4 font-bold text-left">Harga Jual</th>
                                <th class="py-3 px-4 font-bold text-left">Kategori</th>
                                <th class="py-3 px-4 font-bold text-left">Created At</th>
                                <th class="py-2 px-4 font-bold text-left">Updated At</th>
                                <th class="py-2 px-4 font-bold text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($masterBarang as $value)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="py-2 px-4 font-bold text-gray-800">
                                    {{ $value->nama }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ number_format($value->harga_modal) }}
                                </td>
                                <td class="py-2 px-4 font-bold text-gray-800">
                                    {{ number_format($value->harga_jual) }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->kategori }}
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, H:i:s') }}
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($value->updated_at)->format('d M Y, H:i:s') }}
                                </td>
                                <td class="py-2 px-4 text-left">
                                    <a href="{{ route('master-barang.edit', $value->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <span class="text-gray-400">|</span>
                                    <form action="{{ route('master-barang.destroy', $value->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus master barang ini?')" class="text-red-600 hover:underline">
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
                    {{ $masterBarang->links('vendor.pagination.custom') }}
                </div>

            </div>
            
        </div>
    </div>

</x-app-layout>
