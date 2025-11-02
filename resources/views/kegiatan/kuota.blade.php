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
                Kuota Peserta : {{ $kegiatan->kuota_peserta }}
            </h2>
            <div class="mt-6 bg-white shadow rounded p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 shadow-sm overflow-hidden text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left w-1/3">Kecamatan</th>
                                <th class="py-3 px-4 text-left">Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kuota as $value)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->name }}
                                </td>
                                <td class="py-2 px-4 font-medium text-gray-800">
                                    {{ $value->jumlah }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            
        </div>
    </div>

</x-app-layout>
