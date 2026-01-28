<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Penjualan
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form action="{{ route('data-transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- User -->
                <div class="mb-4">
                    <label class="block font-semibold">User</label>
                    <input type="text"
                    value="{{ auth()->user()->name }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    readonly>
                </div>

                <!-- No Polisi -->
                <div class="mb-4">
                    <label class="block font-semibold">No Polisi</label>
                    <input type="text" name="no_polisi"
                    value="{{ $transaksi->no_polisi }}"
                    class="w-full border rounded p-2">
                </div>

                <!-- Items -->
                <div class="mb-4 overflow-x-auto">
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
                            @foreach ($items as $i => $item)
                            <tr class="item-row">
                                <td class="p-2">
                                    <select name="items[{{ $i }}][barang_id]" class="barang w-full border p-2">
                                        <option value="">-- Pilih --</option>
                                        @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            data-harga="{{ $barang->harga_jual }}"
                                            @selected($item->master_barang_id == $barang->id)>
                                            {{ $barang->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-2 harga">{{ $item->harga }}</td>
                                <td class="p-2">
                                    <input type="number" name="items[{{ $i }}][qty]" value="{{ $item->qty }}" class="qty w-full border p-2">
                                </td>
                                <td class="p-2 subtotal">{{ $item->subtotal }}</td>
                                <td class="p-2">
                                    <button type="button" class="hapus text-red-600 font-bold">X</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Template row (hidden) -->
                    <table class="hidden">
                        <tbody>
                            <tr id="item-template" class="item-row">
                                <td class="p-2">
                                    <select class="barang w-full border p-2">
                                        <option value="">-- Pilih --</option>
                                        @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}">
                                            {{ $barang->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-2 harga">0</td>
                                <td class="p-2">
                                    <input type="number" class="qty w-full border p-2" value="1">
                                </td>
                                <td class="p-2 subtotal">0</td>
                                <td class="p-2">
                                    <button type="button" class="hapus text-red-600 font-bold">X</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" id="tambah" class="mt-3 bg-green-600 text-white px-3 py-1 rounded">+ Tambah Item</button>

                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('data-transaksi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Kembali</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Simpan Transaksi</button>
                </div>
            </form>

        </div>
    </div>

    <script>

     let index = {{ $items->count() }};

// Tambah item
     document.getElementById('tambah').addEventListener('click', function() {
        const tbody = document.getElementById('items');
        const template = document.querySelector('#item-template').cloneNode(true);
        template.removeAttribute('id');

    // Reset name & value
        template.querySelector('select').name = `items[${index}][barang_id]`;
        template.querySelector('input.qty').name = `items[${index}][qty]`;
        template.querySelector('select').value = '';
        template.querySelector('input.qty').value = 1;
        template.querySelector('.harga').innerText = 0;
        template.querySelector('.subtotal').innerText = 0;

        tbody.appendChild(template);
        index++;
    });

// Hapus item
     document.addEventListener('click', function(e) {
        if(e.target.classList.contains('hapus')) {
            const rows = document.querySelectorAll('#items tr');
            if(rows.length > 1) {
                e.target.closest('tr').remove();
                hitung();
            }
        }
    });

// Hitung subtotal
     function hitung() {
        document.querySelectorAll('#items tr').forEach(row => {
            const barang = row.querySelector('.barang');
            const qty = row.querySelector('.qty');
            if(!barang || !qty) return;
            const harga = parseFloat(barang.selectedOptions[0]?.dataset.harga || 0);
            row.querySelector('.harga').innerText = harga;
            row.querySelector('.subtotal').innerText = harga * qty.value;
        });
    }

    document.addEventListener('change', hitung);
    document.addEventListener('keyup', hitung);

// No polisi uppercase
    const inputPolisi = document.querySelector('input[name="no_polisi"]');
    if(inputPolisi) {
        inputPolisi.addEventListener('input', function() {
            this.value = this.value.replace(/\s/g,'').toUpperCase();
        });
    }

// Jalankan hitung awal
    hitung();


</script>

</x-app-layout>
