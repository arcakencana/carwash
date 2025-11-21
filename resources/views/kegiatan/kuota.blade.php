<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Kuota Kegiatan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-900 leading-tight">
                Nama Kegiatan : {{ $kegiatan->nama_kegiatan }}
            </h2>
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-900 leading-tight">
                Total Kuota : {{ number_format($kegiatan->kuota_peserta) }}
            </h2>
            <div class="mt-6 bg-white shadow rounded p-4">
                <div class="overflow-x-auto">
                    <form action="{{ route('kuota.updateMassal') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <table class="w-full table-auto border border-gray-200 shadow-sm overflow-hidden text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="py-3 px-4 text-left w-12">No</th>
                                    <th class="py-3 px-4 text-left">Kecamatan</th>
                                    <th class="py-3 px-4 text-left">Kelurahan</th>
                                    <th class="py-3 px-4 text-left w-24">Kuota</th>
                                    <th class="py-3 px-4 text-left">Lokasi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($kuota as $value)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="py-2 px-4 font-medium text-gray-800">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-2 px-4 text-gray-800">
                                        {{ $value->nama_kecamatan }}
                                    </td>

                                    <td class="py-2 px-4 text-gray-800">
                                        {{ $value->nama_kelurahan }}
                                    </td>

                                    <td class="py-2 px-4 text-gray-800">
                                        <input 
                                        type="number" 
                                        name="jumlah[{{ $value->id }}]" 
                                        value="{{ $value->jumlah }}" 
                                        class="border rounded px-2 py-1 w-20 text-right"
                                        >
                                    </td>

                                    <td class="py-2 px-4 text-gray-800">
                                        <input 
                                        type="text" 
                                        name="lokasi[{{ $value->id }}]" 
                                        value="{{ $value->lokasi }}" 
                                        class="border rounded px-2 py-1 w-full"
                                        >
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <div class="mt-4">
                            <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                            >
                            Update Kuota
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

</x-app-layout>
