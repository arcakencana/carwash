<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            <h2 class="font-semibold text-gray-800 leading-tight">{{ $label }}
                <a href="{{ url('/pendaftaran/laporan', ['id' => encrypt($id_kegiatan)]) }}" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition" target="_blank">
                    Laporan
                </a>
            </h2>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('pendaftaran.create', encrypt($id_kegiatan)) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Tambah
                </a>

                <form method="GET" action="" class="flex flex-wrap items-center gap-4">
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
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-left">KK</th>
                                <th class="py-3 px-4 text-left">KTP</th>
                                <th class="py-3 px-4 text-left">Alamat</th>
                                <th class="py-3 px-4 text-left">Whatsapp</th>
                                <th class="py-3 px-4 text-left">Antrian</th>
                                <th class="py-3 px-4 text-left">Tanggal</th>
                                <th class="py-2 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftarans as $value)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->nama }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->kk }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->ktp }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->alamat }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->whatsapp }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->antrian }}
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:i:s') }}
                                </td>
                                <td class="py-2 px-4 text-center">
                                    <a href="" class="text-blue-600 hover:underline">Kirim</a>
                                    <span class="text-gray-400">|</span>
                                    <a href="{{ route('pendaftaran.download', encrypt($value->id)) }}" class="text-blue-600 hover:underline" target="_blank">Download</a>
                                    <span class="text-gray-400">|</span>
                                    <a href="{{ url('/pendaftaran/edit/' . encrypt($value->id)) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <span class="text-gray-400">|</span>
                                    <form action="{{ route('pendaftaran.destroy', encrypt($value->id)) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        
                                        <input type="hidden" name="id" value="{{ encrypt($value->id) }}">
                                        <input type="hidden" name="kegiatan_id" value="{{ encrypt($value->kegiatan_id) }}">

                                        <button onclick="return confirm('Yakin hapus kegiatan ini?')" class="text-red-600 hover:underline">
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
                    {{ $pendaftarans->links('vendor.pagination.custom') }}
                </div>

            </div>
            
        </div>
    </div>

</x-app-layout>
