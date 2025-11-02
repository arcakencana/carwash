<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return view('home.index', compact('kegiatans','jumlahPendaftaran','totalKuota','sisaKuota','persentase','tanggalHarian','jumlahHarian'));
    }

    // public function show(string $id)
    // {
    //     $id = decrypt($id);
    //     $data['kegiatan'] = Kegiatan::where('id', $id)->first(); 

    //     return view('home.show', $data);
    // }
}
