<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Penjualan
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('data-transaksi.store') }}" method="POST">
                @csrf

                <!-- User -->
                <div class="mb-4">
                    <label class="block font-semibold">User</label>
                    <input type="text"
                    value="{{ auth()->user()->name }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">No Polisi</label>
                    <input type="text"
                    name="no_polisi"
                    class="w-full border rounded p-2">
                </div>

                <!-- Item Belanja -->
                <div class="mb-4">

                    <!-- Tambahkan wrapper scroll untuk mobile -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Item</th>
                                    <th class="p-2 text-left">Harga</th>
                                    <th class="p-2 text-left">Qty</th>
                                    <th class="p-2 text-left">Subtotal</th>
                                    <th class="p-2"></th>
                                </tr>
                            </thead>
                            <tbody id="items">
                                <tr>
                                    <td class="p-2">
                                        <select name="items[0][id]" class="barang w-full border p-2">
                                            <option>-- Pilih --</option>
                                            @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}"
                                                data-harga="{{ $barang->harga_jual }}">
                                                {{ $barang->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2 harga">0</td>
                                    <td class="p-2">
                                        <input type="number" name="items[0][qty]" value="1"
                                        class="qty w-full border p-2">
                                    </td>
                                    <td class="p-2 subtotal">0</td>
                                    <td class="p-2">
                                        <button type="button"
                                        class="hapus text-red-600">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" id="tambah"
                    class="mt-3 bg-green-600 text-white px-3 py-1 rounded">
                    + Tambah Item
                </button>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <!-- Tombol Kembali -->
                <a href="{{ route('data-transaksi.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                Kembali
            </a>

            <!-- Tombol Simpan -->
            <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
            Simpan Transaksi
        </button>
    </div>

</div>
</form>
</div>
</div>

<script>
    let index = 1;

    document.getElementById('tambah').addEventListener('click', function () {
        const tbody = document.getElementById('items');
        const row = tbody.children[0].cloneNode(true);

    // update name index
        row.querySelectorAll('select, input').forEach(el => {
            if (el.name.includes('[id]')) {
                el.name = `items[${index}][id]`;
            }
            if (el.name.includes('[qty]')) {
                el.name = `items[${index}][qty]`;
                el.value = 1;
            }
        });

    // reset tampilan
        row.querySelector('.harga').innerText = 0;
        row.querySelector('.subtotal').innerText = 0;

        tbody.appendChild(row);
        index++;
    });

// hapus row
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('hapus')) {
            const rows = document.querySelectorAll('#items tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                hitung();
            }
        }
    });

// hitung harga & subtotal
    function hitung() {
        document.querySelectorAll('#items tr').forEach(row => {
            const barang = row.querySelector('.barang');
            const qty = row.querySelector('.qty');
            const harga = barang.selectedOptions[0].dataset.harga || 0;

            row.querySelector('.harga').innerText = harga;
            row.querySelector('.subtotal').innerText = harga * qty.value;
        });
    }

    document.addEventListener('change', hitung);
    document.addEventListener('keyup', hitung);

    function hitung() {
        document.querySelectorAll('#items tr').forEach(row => {
            const barang = row.querySelector('.barang');
            const qty = row.querySelector('.qty');
            const harga = barang.selectedOptions[0].dataset.harga;

            row.querySelector('.harga').innerText = harga;
            row.querySelector('.subtotal').innerText = harga * qty.value;
        });
    }

    document.addEventListener('change', hitung);
    document.addEventListener('keyup', hitung);

    const inputPolisi = document.querySelector('input[name="no_polisi"]');

    inputPolisi.addEventListener('input', function() {
        this.value = this.value.replace(/\s/g, '').toUpperCase();
    });

</script>

</x-app-layout>
