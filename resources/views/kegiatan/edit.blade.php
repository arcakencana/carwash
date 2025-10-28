<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kegiatan</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('kegiatan.update', $kegiatan) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" value="{{ $kegiatan->nama_kegiatan }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Tanggal & Waktu Kegiatan</label>
                    <input type="datetime-local" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('Y-m-d\TH:i')) }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded p-2" rows="4">{{ $kegiatan->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Kuota Peserta</label>
                    <input type="number" name="kuota_peserta" value="{{ $kegiatan->kuota_peserta }}" class="w-full border rounded p-2" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Banner Saat Ini</label>
                    @if ($kegiatan->banner)
                    <img src="{{ asset('storage/'.$kegiatan->banner) }}" alt="" class="w-32 mb-2 rounded">
                    @endif
                    <input type="file" name="banner" class="w-full border rounded p-2">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
                <a href="{{ route('kegiatan.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
