<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->first();

        $jumlahPendaftaran = ['jumlahPendaftaran' => 100];
        $totalKuota = 52500;
        $sisaKuota = 1000;
        $persentase = 35;
        $tanggalHarian = ['01 Nov', '02 Nov'];
        $jumlahHarian = [12, 20];

        return view('home.index', compact('kegiatans', 'jumlahPendaftaran', 'totalKuota', 'sisaKuota', 'persentase', 'tanggalHarian', 'jumlahHarian'));
    }

}
