<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            $totalTransaksi = Transaksi::count();
            $totalPendapatan = Transaksi::sum('total_harga');

            $hariIni = Carbon::today();

            $transaksiHariIni = Transaksi::whereDate('tanggal', $hariIni)->count();
            $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->sum('total_harga');

            return view('dashboard.index-admin', compact(
                'totalTransaksi',
                'totalPendapatan',
                'transaksiHariIni',
                'pendapatanHariIni'
            ));
        } else {
            $hariIni = Carbon::today();

            $transaksiHariIni = Transaksi::whereDate('tanggal', $hariIni)->count();
            $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)
            ->sum('total_harga');

            return view('dashboard.index', compact(
                'transaksiHariIni',
                'pendapatanHariIni'
            ));
        }
    }
}
