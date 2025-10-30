<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kecamatan;
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

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'deskripsi' => 'nullable|string',
            'kuota_peserta' => 'required|integer|min:1',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('nama_kegiatan', 'deskripsi', 'kuota_peserta');

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        Kegiatan::create($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
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
