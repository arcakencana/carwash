<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Master Barang</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('master-barang.update', $masterBarang->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold">Nama</label>
                    <input type="text" name="nama" value="{{ $masterBarang->nama }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Harga Modal</label>
                    <input type="text" name="harga_modal" value="{{ $masterBarang->harga_modal }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Harga Jual</label>
                    <input type="text" name="harga_jual" value="{{ $masterBarang->harga_jual }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Kategori</label>
                    <select name="kategori" class="w-full border rounded p-2" required>
                        <option value="primary" @if($masterBarang->kategori == 'primary') selected @endif>Primary</option>
                        <option value="secondary" @if($masterBarang->kategori == 'secondary') selected @endif>Secondary</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
                <a href="{{ route('master-barang.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
