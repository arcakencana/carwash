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
        ->latest()
        ->paginate(10);

        return view('data-transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = MasterBarang::where('kategori', 'primary')
        ->orderBy('nama')
        ->get();

        return view('data-transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.master_barang_id' => 'required|exists:master_barang,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . time(),
                'no_polisi' => $request->no_polisi,
                'tanggal' => now(),
                'user_id' => Auth::id(),
                'total_harga' => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $barang = MasterBarang::findOrFail($item['master_barang_id']);

                $subtotal = $barang->harga_jual * $item['qty'];
                $total += $subtotal;

                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'master_barang_id' => $barang->id,
                    'qty' => $item['qty'],
                    'harga' => $barang->harga_jual,
                    'subtotal' => $subtotal
                ]);
            }

            $transaksi->update(['total_harga' => $total]);
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

    public function update(Request $request, Transaksi $data_transaksi)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:master_barang,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $data_transaksi) {
            $data_transaksi->items()->delete();

            $total = 0;

            foreach ($request->items as $item) {
                $barang = MasterBarang::findOrFail($item['barang_id']);
                $subtotal = $barang->harga_jual * $item['qty'];
                $total += $subtotal;

                TransaksiItem::create([
                    'transaksi_id' => $data_transaksi->id,
                    'master_barang_id' => $barang->id,
                    'qty' => $item['qty'],
                    'harga' => $barang->harga_jual,
                    'subtotal' => $subtotal
                ]);
            }

            $data_transaksi->update(['total_harga' => $total]);
        });

        return redirect()
        ->route('data-transaksi.show', $data_transaksi->id)
        ->with('success', 'Item transaksi berhasil diperbarui');
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
    // Update status menjadi "sudah"
        $transaksi->update(['status' => 'sudah']);

    // Ambil item beserta relasi barang
        $items = $transaksi->items()->with('barang')->get();

    // Load view struk
        return view('data-transaksi.struk', compact('transaksi', 'items'));
    }


    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            $transaksi->items()->delete();
            $transaksi->delete();
        });

        return redirect()
        ->route('data-transaksi.index')
        ->with('success', 'Transaksi berhasil dihapus');
    }

}
