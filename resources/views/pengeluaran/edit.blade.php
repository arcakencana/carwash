<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pengeluaran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <form method="POST" action="{{ route('pengeluaran.update', $pengeluaran->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Keterangan</label>
                        <input type="text"
                            name="keterangan"
                            value="{{ old('keterangan', $pengeluaran->keterangan) }}"
                            oninput="this.value = this.value.toUpperCase()"
                            class="w-full border rounded p-2">
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-1">Nominal</label>
                        <input type="number"
                            name="nominal"
                            value="{{ old('nominal', $pengeluaran->nominal) }}"
                            class="w-full border rounded p-2">
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('pengeluaran.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Kembali
                        </a>

                        <button
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
