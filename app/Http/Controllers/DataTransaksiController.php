<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataTransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('kasir')
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('data-transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = MasterBarang::orderBy('nama')
        ->get();

        return view('data-transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_polisi' => 'required|string|max:10',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:master_barang,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.diskon' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $transaksi = Transaksi::create([
                'kode_transaksi'    => 'TRX-' . time(),
                'no_polisi'         => $request->no_polisi,
                'no_wa'             => $request->no_wa,
                'tanggal'           => now(),
                'user_id'           => Auth::id(),
                'total_harga'       => 0,
            ]);

            $grandTotal = 0;

            foreach ($request->items as $item) {
                $barang = MasterBarang::findOrFail($item['id']);
                $qty = (int) $item['qty'];
                $harga = (int) $barang->harga_jual;
                $diskon = (int) ($item['diskon'] ?? 0);
                $subHarga = $harga * $qty;
                $subtotal = max($subHarga - $diskon, 0);

                TransaksiItem::create([
                    'transaksi_id'      => $transaksi->id,
                    'master_barang_id'  => $barang->id,
                    'qty'               => $qty,
                    'harga'             => $harga,
                    'diskon'            => $diskon,
                    'subtotal'          => $subtotal,
                ]);

                $grandTotal += $subtotal;
            }

            $transaksi->update([
                'total_harga' => $grandTotal
            ]);
        });

        return redirect()
        ->route('data-transaksi.index')
        ->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit(Transaksi $data_transaksi)
    {
        $data_transaksi->load('items.barang');

        $barangs = MasterBarang::orderBy('nama')->get();

        return view('data-transaksi.edit', [
            'transaksi' => $data_transaksi,
            'items' => $data_transaksi->items,
            'barangs' => $barangs
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['no_polisi' => $request->no_polisi]);
        $transaksi->items()->delete();

        $total = 0;
        $totalDiskon = 0;

        foreach ($request->items as $item) {
            $barang = MasterBarang::findOrFail($item['barang_id']);

            $harga = (int) $barang->harga_jual;
            $qty   = (int) $item['qty'];

            $diskonInput = (float) ($item['diskon'] ?? 0);
            $diskonTipe  = $item['diskon_tipe'] ?? 'nominal';

            if ($diskonTipe === 'persen') {
                $diskonNominal = ($harga * $qty) * ($diskonInput / 100);
            } else {
                $diskonNominal = $diskonInput;
            }

            $diskonNominal = min($diskonNominal, $harga * $qty);
            $subtotal = ($harga * $qty) - $diskonNominal;

            $transaksi->items()->create([
                'master_barang_id'  => $barang->id,
                'harga'             => $harga,
                'qty'               => $qty,
                'diskon'            => $diskonNominal,
                'subtotal'          => $subtotal,
            ]);

            $total += $harga * $qty;
            $totalDiskon += $diskonNominal;
        }

        $transaksi->update([
            'total_harga' => $total,
            'total_diskon' => $totalDiskon,
            'grand_total' => $total - $totalDiskon,
        ]);

        return redirect()
        ->route('data-transaksi.show', $transaksi->id)
        ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);
        $items = TransaksiItem::where('transaksi_id', $id)
        ->with('barang')
        ->get();

        return view('data-transaksi.show', compact('transaksi', 'items'));
    }

    public function bayar(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'sudah']);

        $items = $transaksi->items()->with('barang')->get();

        return view('data-transaksi.struk', compact('transaksi', 'items'));
    }


    public function destroy(Transaksi $data_transaksi)
    {
        DB::transaction(function () use ($data_transaksi) {
            $data_transaksi->items()->delete();
            $data_transaksi->delete();
        });

        return redirect()
        ->route('data-transaksi.index')
        ->with('success', 'Transaksi berhasil dihapus');
    }
}
