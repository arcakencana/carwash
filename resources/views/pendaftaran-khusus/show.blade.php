<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight">Pendaftaran Terverifikasi</h2>
    </x-slot>

    <div class="min-h-screen flex flex-col items-center pt-8 px-4">
        <div class="w-full sm:max-w-2xl lg:max-w-3xl bg-white shadow-lg rounded-lg border border-gray-200 mb-8">

            <h2 class="text-2xl font-bold text-gray-800 p-6 pb-2">Pendaftaran Terverifikasi</h2>

            <div class="overflow-hidden">
                <table class="min-w-full border-t border-gray-200">
                    <tbody class="divide-y divide-gray-200">

                        <tr>
                            <td class="w-1/3 px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Kartu Keluarga
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->kk }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor KTP
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->ktp }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nama
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->nama }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Alamat
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->alamat }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Whatsapp
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->whatsapp }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Kecamatan
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->nama_kecamatan }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Kelurahan
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->nama_kelurahan }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Antrian
                            </td>
                            <td class="px-6 py-3 text-blue-700 font-bold text-xl">
                                {{ $pendaftaran->antrian }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="mb-4">

                <div class="flex flex-col items-center mt-4 space-y-2">

                    <img src="{{ asset($pendaftaran->photo_path) }}" 
                    class="w-40 h-40 rounded" />

                    <div class="text-gray-700 mt-2 text-center">
                        {{ date('d-m-Y H:i:s', strtotime($pendaftaran->captured_at)) }}
                    </div>

                    <div class="text-gray-700 mt-2 text-center">
                        📍 {{ $pendaftaran->latitude . ' | ' . $pendaftaran->longitude }}
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
