<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Pendaftaran</h2>
    </x-slot>

    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2">

        <div class="w-full sm:max-w-xl lg:max-w-2xl px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">
            <form action="{{ route('pendaftaran.update', encrypt($pendaftarans->id)) }}" method="POST">
                @csrf @method('PUT')

                <input type="hidden" name="kegiatan_id" value="{{ encrypt($pendaftarans->kegiatan_id) }}">

                <div class="space-y-4">

                    <div>
                        <label class="block font-semibold mb-1">Nomor Kartu Keluarga</label>
                        <input type="text" name="kk" value="{{ $pendaftarans->kk }}" class="w-full border rounded-lg p-2 only-number-16" required>
                        <div class="text-red-600 text-sm mt-1 error-message" data-error="kk"></div>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Nomor KTP</label>
                        <input type="text" name="ktp" value="{{ $pendaftarans->ktp }}" class="w-full border rounded-lg p-2 only-number-16" required>
                        <div class="text-red-600 text-sm mt-1 error-message" data-error="ktp"></div>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama" value="{{ $pendaftarans->nama }}" class="w-full border rounded-lg p-2 only-uppercase" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Alamat (Sesuai KTP)</label>
                        <input type="text" name="alamat" value="{{ $pendaftarans->alamat }}" class="w-full border rounded-lg p-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Nomor Whatsapp</label>
                        <input type="number" name="whatsapp" value="{{ $pendaftarans->whatsapp }}" class="w-full border rounded-lg p-2 only-number" required>
                        <div class="text-red-600 text-sm mt-1 error-message" data-error="whatsapp"></div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>

                </div>

            </form>
        </div>
    </div>
</x-app-layout>
