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

                <div class="mb-4">
                    <label class="block font-semibold">User</label>
                    <input type="text"
                    value="{{ auth()->user()->name }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">No Pelat Kendaraan</label>
                    <input type="text" name="no_polisi"
                    value="{{ $transaksi->no_polisi }}"
                    class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">No Whatsapp</label>
                    <input type="text" name="no_wa"
                    value="{{ $transaksi->no_wa }}"
                    class="w-full border rounded p-2">
                </div>

                <div class="mb-4 overflow-x-auto">
                    <table class="w-full min-w-[600px] border border-gray-200">
                        <thead class="bg-gray-100 text-sm">
                            <tr>
                                <th class="p-2 text-left w-[35%]">Item</th>
                                <th class="p-2 text-right w-[15%]">Harga</th>
                                <th class="p-2 text-center w-[8%]">Qty</th>
                                <th class="p-2 text-left w-[22%]">Diskon</th>
                                <th class="p-2 text-right w-[15%]">Subtotal</th>
                                <th class="p-2 w-[5%]"></th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            @foreach ($items as $i => $item)
                            <tr class="item-row">
                                <td class="p-2">
                                    <select name="items[{{ $i }}][barang_id]"
                                    class="barang w-full border rounded px-2 py-1 text-sm">
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
                            <td class="p-2 text-right font-mono harga">
                                {{ number_format($item->harga) }}
                            </td>
                            <td class="p-2 text-center">
                                <input type="number"
                                name="items[{{ $i }}][qty]"
                                value="{{ $item->qty }}"
                                min="1"
                                class="qty w-16 text-center border rounded px-1 py-1 text-sm">
                            </td>
                            <td class="p-2">
                                <div class="flex items-center gap-1">
                                    <select class="diskon-tipe w-10 border p-2">
                                        <option value="nominal" selected>Rp</option>
                                        <option value="persen">%</option>
                                    </select>

                                    {{-- INPUT TAMPIL --}}
                                    <input type="number"
                                    class="diskon w-20 text-right border px-2 py-1"
                                    value="{{ $item->diskon ?? 0 }}"
                                    min="0">

                                    {{-- INPUT YANG MASUK DB --}}
                                    <input type="hidden"
                                    name="items[{{ $i }}][diskon]"
                                    class="diskon-nominal"
                                    value="{{ $item->diskon ?? 0 }}">
                                </div>
                            </td>

                            <td class="p-2 text-right font-mono subtotal">
                                {{ number_format($item->subtotal) }}
                            </td>
                            <td class="p-2 text-center">
                                <button type="button" class="hapus text-red-600 font-bold">✕</button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" id="tambah" class="mt-3 bg-green-600 text-white px-3 py-1 rounded">+ Tambah Item</button>

                <div class="flex justify-end mt-6">
                    <div class="w-full max-w-sm bg-gray-50 border rounded p-4 space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span>Total Item</span>
                            <span id="totalQty" class="font-semibold">0</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Total Harga</span>
                            <span id="totalHarga" class="font-mono">Rp 0</span>
                        </div>

                        <div class="flex justify-between text-red-600">
                            <span>Total Diskon</span>
                            <span id="totalDiskon" class="font-mono">Rp 0</span>
                        </div>

                        <hr>

                        <div class="flex justify-between text-lg font-bold">
                            <span>GRAND TOTAL</span>
                            <span id="grandTotal" class="font-mono text-green-600">Rp 0</span>
                        </div>

                    </div>
                </div>

                <!-- Template row (hidden) -->
                <table class="hidden">
                    <tbody>
                        <tr id="item-template" class="item-row">
                            <td class="p-2">
                                <select class="barang w-full border rounded px-2 py-1 text-sm">
                                    <option value="">-- Pilih --</option>
                                    @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}">
                                        {{ $barang->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="p-2 text-right harga">0</td>

                            <td class="p-2 text-center">
                                <input type="number" class="qty w-16 text-center border rounded px-1 py-1 text-sm" value="1">
                            </td>

                            <td class="p-2">
                                <div class="flex items-center gap-1">
                                    <select class="diskon-tipe border rounded px-1 py-1 text-sm">
                                        <option value="nominal">Rp</option>
                                        <option value="persen">%</option>
                                    </select>

                                    <input type="number"
                                    class="diskon w-20 border rounded px-1 py-1 text-sm text-right"
                                    value="0"
                                    min="0">
                                </div>
                            </td>

                            <td class="p-2 text-right subtotal">0</td>

                            <td class="p-2 text-center">
                                <button type="button" class="hapus text-red-600 font-bold">✕</button>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('data-transaksi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Simpan Transaksi</button>
            </div>
        </form>

    </div>
</div>

<script>
    function hitung() {
        let totalQty = 0;
        let totalHarga = 0;
        let totalDiskon = 0;
        let grandTotal = 0;

        document.querySelectorAll('#items tr').forEach(row => {
            const barang = row.querySelector('.barang');
            const qty = row.querySelector('.qty');
            const diskonInput = row.querySelector('.diskon');
            const diskonTipe = row.querySelector('.diskon-tipe');

            if (!barang || !qty) return;

            const harga = parseInt(barang.selectedOptions[0]?.dataset.harga || 0);
            const qtyVal = parseInt(qty.value || 0);
            let diskonVal = parseInt(diskonInput?.value || 0);

            const subHarga = harga * qtyVal;
            let diskonRp = 0;

            if (diskonTipe && diskonTipe.value === 'persen') {
                diskonVal = Math.min(diskonVal, 100);
                diskonRp = Math.round(subHarga * diskonVal / 100);
            } else {
                diskonRp = diskonVal;
            }

            const diskonHidden = row.querySelector('.diskon-nominal');
            if (diskonHidden) {
                diskonHidden.value = diskonRp;
            }

            const subtotal = Math.max(subHarga - diskonRp, 0);

            row.querySelector('.harga').innerText = harga.toLocaleString('id-ID');
            row.querySelector('.subtotal').innerText = subtotal.toLocaleString('id-ID');

            totalQty += qtyVal;
            totalHarga += subHarga;
            totalDiskon += diskonRp;
            grandTotal += subtotal;
        });

        document.getElementById('totalQty').innerText = totalQty;
        document.getElementById('totalHarga').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
        document.getElementById('totalDiskon').innerText = 'Rp ' + totalDiskon.toLocaleString('id-ID');
        document.getElementById('grandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    document.addEventListener('change', hitung);
    document.addEventListener('keyup', hitung);

    let index = {{ $items->count() }};

    document.getElementById('tambah').addEventListener('click', function () {
        const tbody = document.getElementById('items');
        const template = document.getElementById('item-template').cloneNode(true);
        template.removeAttribute('id');

        template.querySelector('.barang').name = `items[${index}][barang_id]`;
        template.querySelector('.qty').name = `items[${index}][qty]`;

        const diskon = template.querySelector('.diskon');
        const diskonTipe = template.querySelector('.diskon-tipe');

        if (diskon) diskon.name = `items[${index}][diskon]`;
        if (diskonTipe) diskonTipe.name = `items[${index}][diskon_tipe]`;

        tbody.appendChild(template);
        index++;
        hitung();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('hapus')) {
            e.target.closest('tr').remove();
            hitung();
        }
    });

    hitung();
</script>


</x-app-layout>
