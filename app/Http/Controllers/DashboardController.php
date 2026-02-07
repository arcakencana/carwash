<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {

            $hariIni = Carbon::today();

            $totalTransaksi = Transaksi::where('status', 'sudah')
            ->count();
            $totalPendapatan = Transaksi::where('status', 'sudah')
            ->sum('total_harga');
            $transaksiHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->where('status', 'sudah')->count();
            $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->where('status', 'sudah')->sum('total_harga');
            $transaksi = Transaksi::orderBy('id', 'asc')
            ->paginate(10);

            return view('dashboard.index-admin', compact(
                'totalTransaksi',
                'totalPendapatan',
                'transaksiHariIni',
                'pendapatanHariIni',
                'transaksi'
            ));

        } else {

            $hariIni = Carbon::today();

            $transaksiHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->where('status', 'sudah')->count();
            $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->where('status', 'sudah')->sum('total_harga');

            return view('dashboard.index', compact(
                'transaksiHariIni',
                'pendapatanHariIni'
            ));
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);
        $items = TransaksiItem::where('transaksi_id', $id)
        ->with('barang')
        ->get();

        return view('dashboard.show', compact('transaksi', 'items'));
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            $transaksi->items()->delete();
            $transaksi->delete();
        });

        return redirect()
        ->route('dashboard')
        ->with('success', 'Transaksi berhasil dihapus');
    }

}
