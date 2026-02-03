<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\LaporanTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = collect();
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $data = DB::table('transaksi_items')
            ->join('transaksi', 'transaksi.id', '=', 'transaksi_items.transaksi_id')
            ->join('master_barang', 'master_barang.id', '=', 'transaksi_items.master_barang_id')
            ->where('transaksi.status', 'sudah')
            ->whereBetween('transaksi.created_at', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('transaksi_items.master_barang_id', 'master_barang.nama', 'master_barang.harga_modal')
            ->select(
                'master_barang.nama',
                'master_barang.harga_modal',
                DB::raw('SUM(transaksi_items.qty) as total_qty'),
                // TOTAL PENDAPATAN - MODAL
                DB::raw('SUM(transaksi_items.qty * (transaksi_items.harga - master_barang.harga_modal)) 
                    as total_pendapatan'),
                // TOTAL DISKON
                DB::raw('SUM(transaksi_items.diskon) as total_diskon'),
                // GRAND TOTAL (SETELAH DISKON)
                DB::raw('SUM((transaksi_items.qty * (transaksi_items.harga - master_barang.harga_modal)) 
                    - transaksi_items.diskon) as grand_total')
            )
            ->get();
        }

        return view('laporan.index', compact('data'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        return Excel::download(
            new LaporanTransaksiExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'laporan-transaksi-' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
