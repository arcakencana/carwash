<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kegiatan</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Tanggal & Waktu Kegiatan</label>
                    <input type="datetime-local" name="tanggal_kegiatan" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded p-2" rows="4"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Kuota Peserta</label>
                    <input type="number" name="kuota_peserta" class="w-full border rounded p-2" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Banner (JPG/PNG, maks 2MB)</label>
                    <input type="file" name="banner" class="w-full border rounded p-2">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('kegiatan.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
