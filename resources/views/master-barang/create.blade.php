<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Master Barang</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('master-barang.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Harga Modal</label>
                    <input type="text" name="harga_modal" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Harga Jual</label>
                    <input type="text" name="harga_jual" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Kategori</label>
                    <select name="kategori" class="w-full border rounded p-2" required>
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('master-barang.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
