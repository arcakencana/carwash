<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('kasir')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = MasterBarang::where('kategori', 'primary')
        ->orderBy('nama')
        ->get();

        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.id' => 'required',
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
                $barang = MasterBarang::findOrFail($item['id']);
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

        return redirect()->route('transaksi.index')
        ->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit(MasterBarang $masterBarang)
    {
        //
    }

    public function update(Request $request, MasterBarang $masterBarang)
    {
        //
    }

    public function show($id)
    {
        // Ambil transaksi beserta user
        $transaksi = Transaksi::with('user')->findOrFail($id);

        // Ambil item transaksi beserta data barang
        $items = TransaksiItem::where('transaksi_id', $id)
            ->with('barang') // pastikan relasi 'barang' ada di model TransaksiItem
            ->get();

            return view('transaksi.show', compact('transaksi', 'items'));
        }

        public function destroy(MasterBarang $masterBarang)
        {
            try {

                $masterBarang->delete();

                return redirect()
                ->route('master-barang.index')
                ->with('success', 'Master Barang berhasil dihapus!');

            } catch (\Exception $e) {

            // Bisa tulis log jika ingin debug
                \Log::error('Gagal menghapus master barang: ' . $e->getMessage());

                return redirect()
                ->route('master-barang.index')
                ->with('error', 'Gagal menghapus master barang! Silakan coba lagi.');
            }
        }

    }
