<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kecamatan;
use App\Models\Pendaftaran;
use App\Models\Kuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        //
    }

    public function create($id)
    {
        $id = decrypt($id);

        $data['kegiatan'] = Kegiatan::where('id', $id)->first();
        $data['kecamatan'] = Kecamatan::get();
        
        return view('pendaftaran.create', $data);
    }

    public function store(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'kecamatan_id' => 'required|integer',
            'kelurahan_id' => 'required|integer',
            'kk' => 'required|integer',
            'ktp' => 'required|integer',
            'nama' => 'required',
            'alamat' => 'required',
            'whatsapp' => 'required|min:9',
            // 'foto_kk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // if ($request->hasFile('foto_kk')) {
        //     $path = $request->file('foto_kk')->store('berkas', 'public');
        // }

        $kk = $request->kk;
        $ktp = $request->ktp;
        $whatsapp = $request->whatsapp;

        // Query cek apakah sudah ada
        $exists = Pendaftaran::query()
        ->where(function ($q) use ($kk, $ktp, $whatsapp) {
            if ($kk) {
                $q->where('kk', $kk);
            }
            if ($ktp) {
                $q->orWhere('ktp', $ktp);
            }
            if ($whatsapp) {
                $q->orWhere('whatsapp', $whatsapp);
            }
        })
        ->exists();

        // Jika sudah ada -> fail
        if ($exists) {

            return response()->json([
                'success' => true,
                'message' => 'Mohon Maaf Registrasi Anda Gagal Karena Data Nomor KK, NIK atau Whatsapp Anda Sudah Melakukan Pendaftaran',
                'data' => null
            ]);

        } else {

            $data = Pendaftaran::create([
                'kk' => $request->kk,
                'ktp' => $request->ktp,
                'nama' => $request->nama,
                'whatsapp' => $request->whatsapp,
                'alamat' => $request->alamat,
                'lansia_disabilitas' => 'Tidak',
                // 'berkas' => $path,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'kegiatan_id' => $id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $data
            ]);

        } 

    }

    public function getKuota($kegiatan_id, $kecamatan_id)
    {
        $kuota = Kuota::where('kegiatan_id', $kegiatan_id)
        ->where('kecamatan_id', $kecamatan_id)
        ->first();

        if (!$kuota) {
            return response()->json([
                'success' => false,
                'message' => 'Data kuota tidak ditemukan'
            ]);
        }

        // Hitung jumlah pendaftar pada kegiatan dan kecamatan yang sama
        $jumlah_pendaftar = Pendaftaran::where('kegiatan_id', $kegiatan_id)
        ->where('kecamatan_id', $kecamatan_id)
        ->count();

        $sisa = $kuota->jumlah - $jumlah_pendaftar;

        return response()->json([
            'success' => true,
            'jumlah' => $kuota->jumlah,
            'sisa' => max($sisa, 0),
        ]);
    }

    public function edit(Kegiatan $kegiatan)
    {
        //
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        //
    }

    public function destroy(Kegiatan $kegiatan)
    {
        //
    }

}
