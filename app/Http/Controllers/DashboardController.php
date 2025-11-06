<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->first();

        $totalPendaftaran = Pendaftaran::where('kegiatan_id', $kegiatans->id)->count();

        $sisaKuota = $kegiatans->kuota_peserta - $totalPendaftaran;

        $persentase = 0;

        if ($kegiatans->kuota_peserta > 0) {
            $persentase = ($totalPendaftaran / $kegiatans->kuota_peserta) * 100;
        }

        $persentase = number_format($persentase, 2);

        $data = Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        $tanggalHarian = $data->map(fn ($d) => \Carbon\Carbon::parse($d->tanggal)->format('d M'));
        $jumlahHarian  = $data->pluck('total');

        return view('dashboard', compact('kegiatans', 'totalPendaftaran', 'sisaKuota', 'persentase', 'tanggalHarian', 'jumlahHarian'));
    }

}
