<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Pengeluaran Harian
        </h2>
    </x-slot>

    <!-- WRAPPER JARAK DARI HEADER -->
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <form method="POST" action="{{ route('pengeluaran.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Keterangan</label>
                        <input type="text"
                        name="keterangan"
                        oninput="this.value = this.value.toUpperCase()"
                        class="w-full border rounded p-2">
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-1">Nominal</label>
                        <input type="number"
                        name="nominal"
                        class="w-full border rounded p-2">
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('pengeluaran.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali
                    </a>

                    <button
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
</div>
</x-app-layout>
