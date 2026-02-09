<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Penjualan</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('data-transaksi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                <div>
                    <label class="block font-semibold">User</label>
                    <input
                    type="text"
                    value="{{ auth()->user()->name }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    readonly
                    >
                </div>

                <div>
                    <label class="block font-semibold">No Pelat</label>
                    <input
                    type="text"
                    name="no_polisi"
                    class="w-full border rounded p-2"
                    maxlength="8"
                    oninput="
                    let v = this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');
                    let hurufDepan = v.slice(0,1);
                    let angka = v.slice(1,5);
                    let hurufBelakang = v.slice(5,8);
                    this.value = hurufDepan + angka + hurufBelakang;
                    "
                    onkeydown="if(event.key === ' ') event.preventDefault();"
                    >
                </div>

                <div>
                    <label class="block font-semibold">Keterangan</label>
                    <input
                    type="text"
                    name="keterangan"
                    class="w-full border rounded p-2"
                    oninput="this.value = this.value.toUpperCase()"
                    >
                </div>

                <div>
                    <label class="block font-semibold">No Whatsapp</label>
                    <input
                    type="text"
                    name="no_wa"
                    class="w-full border rounded p-2"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    onkeydown="if(event.key === ' ') event.preventDefault();"
                    >
                </div>

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
                                <th class="p-2 text-left">Diskon</th>
                                <th class="p-2 text-left">Subtotal</th>
                                <th class="p-2"></th>
                            </tr>
                        </thead>

                        <tbody id="items">
                            <tr>
                                <td class="p-2">
                                    <select name="items[0][id]" class="barang w-full border rounded">
                                        <option value="">-- Pilih --</option>
                                        @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            data-harga="{{ $barang->harga_jual }}">
                                            {{ $barang->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="p-2 text-right font-mono harga">0</td>

                                <td class="p-2">
                                    <input type="number"
                                    name="items[0][qty]"
                                    value="1"
                                    min="1"
                                    class="qty w-16 border rounded">
                                </td>

                                <!-- DISKON -->
                                <td class="p-2">
                                    <div class="flex items-center gap-1">
                                        <select class="diskon-tipe w-18 border rounded">
                                            <option value="nominal">Rp</option>
                                            <option value="persen">%</option>
                                        </select>
                                        <input type="number"
                                        class="diskon w-28 border rounded"
                                        placeholder="0">

                                        <!-- YANG MASUK DB -->
                                        <input 
                                        type="hidden"
                                        name="items[0][diskon]"
                                        class="diskon-nominal">
                                    </div>
                                </td>

                                <td class="p-2 text-right font-mono subtotal">0</td>

                                <td class="p-2">
                                    <button type="button" class="hapus text-red-600">X</button>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <button type="button" id="tambah" class="mt-3 bg-green-600 text-white px-3 py-1 rounded">
                    + Tambah Item
                </button>
            </div>

            <div class="flex justify-end mt-4">
                <div class="w-full max-w-sm bg-gray-50 border rounded p-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Total Item</span>
                        <span id="totalQty" class="font-mono">0</span>
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


            <div class="flex justify-end gap-3 mt-4">
                <!-- Tombol Kembali -->
                <a href="{{ route('data-transaksi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                    Kembali
                </a>

                <!-- Tombol Simpan -->
                <button type="submit"class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Simpan Transaksi
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    let index = document.querySelectorAll('#items tr').length;

    document.getElementById('tambah').addEventListener('click', function () {
        const tbody = document.getElementById('items');
        const row = tbody.querySelector('tr').cloneNode(true);

    // reset value
        row.querySelector('.barang').value = '';
        row.querySelector('.harga').innerText = '0';
        row.querySelector('.qty').value = 1;
        row.querySelector('.diskon').value = 0;
        row.querySelector('.subtotal').innerText = '0';

    // update name biar tidak bentrok
        row.querySelector('.barang').name = `items[${index}][id]`;
        row.querySelector('.qty').name = `items[${index}][qty]`;
        row.querySelector('.diskon-nominal').name = `items[${index}][diskon]`;

        tbody.appendChild(row);
        index++;

        hitung();
    });

// hapus item
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('hapus')) {
            const rows = document.querySelectorAll('#items tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                hitung();
            }
        }
    });
</script>

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
            const diskonHidden = row.querySelector('.diskon-nominal');

            if (!barang || !qty) return;

            const harga = parseInt(barang.selectedOptions[0]?.dataset.harga || 0);
            const qtyVal = parseInt(qty.value || 0);
            const subHarga = harga * qtyVal;

        // ===== HITUNG DISKON =====
            let diskonNominal = 0;
            let diskonVal = parseInt(diskonInput?.value || 0);

            if (diskonTipe?.value === 'persen') {
                diskonVal = Math.min(diskonVal, 100);
                diskonNominal = Math.round(subHarga * diskonVal / 100);
            } else {
                diskonNominal = diskonVal;
            }

        // proteksi diskon lebih besar dari subtotal
            diskonNominal = Math.min(diskonNominal, subHarga);

            const subtotal = subHarga - diskonNominal;

        // ===== SIMPAN KE INPUT HIDDEN (INI YANG PENTING) =====
            if (diskonHidden) {
                diskonHidden.value = diskonNominal;
            }

        // ===== UPDATE TAMPILAN =====
            row.querySelector('.harga').innerText = harga.toLocaleString('id-ID');
            row.querySelector('.subtotal').innerText = subtotal.toLocaleString('id-ID');

            totalQty += qtyVal;
            totalHarga += subHarga;
            totalDiskon += diskonNominal;
            grandTotal += subtotal;
        });

    // ===== TOTAL =====
        document.getElementById('totalQty').innerText = totalQty;
        document.getElementById('totalHarga').innerText =
        'Rp ' + totalHarga.toLocaleString('id-ID');
        document.getElementById('totalDiskon').innerText =
        'Rp ' + totalDiskon.toLocaleString('id-ID');
        document.getElementById('grandTotal').innerText =
        'Rp ' + grandTotal.toLocaleString('id-ID');
    }

// ===== EVENT =====
    document.addEventListener('change', e => {
        if (e.target.closest('#items')) hitung();
    });
    document.addEventListener('keyup', e => {
        if (e.target.closest('#items')) hitung();
    });

// hitung awal
    hitung();
</script>


</x-app-layout>
