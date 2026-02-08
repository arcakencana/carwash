<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('kasir')
        ->where('user_id', Auth::id())
        ->whereBetween('tanggal', [
            now()->startOfDay(),
            now()->endOfDay()
        ])
        ->where('status', 'belum')
        ->orderBy('id', 'desc')
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
            'no_polisi' => 'required|string|max:10',
            'items.*.id' => 'required',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {

            $transaksi = Transaksi::create([
                'kode_transaksi'    => 'TRX-' . time(),
                'no_polisi'         => $request->no_polisi,
                'keterangan'        => $request->keterangan,
                'no_wa'             => $request->no_wa,
                'tanggal'           => now(),
                'user_id'           => Auth::id(),
                'total_harga'       => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $barang = MasterBarang::findOrFail($item['id']);
                $subtotal = $barang->harga_jual * $item['qty'];
                $total += $subtotal;

                TransaksiItem::create([
                    'transaksi_id'      => $transaksi->id,
                    'master_barang_id'  => $barang->id,
                    'qty'               => $item['qty'],
                    'harga'             => $barang->harga_jual,
                    'subtotal'          => $subtotal
                ]);
            }

            $transaksi->update(['total_harga' => $total]);
        });

        return redirect()->route('transaksi.index')
        ->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit(Transaksi $transaksi)
    {
        //
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);

        $items = TransaksiItem::where('transaksi_id', $id)
            ->with('barang') // pastikan relasi 'barang' ada di model TransaksiItem
            ->get();

            return view('transaksi.show', compact('transaksi', 'items'));
        }

        public function destroy(Transaksi $transaksi)
        {
        //
        }
    }
