<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function show($id)
    {
        $id = decrypt($id);

        $data['pendaftaran'] = Pendaftaran::join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id')
        ->where('pendaftarans.id', $id)->first();

        return view('verifikasi.show', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:2048',
            'latitude' => 'required',
            'longitude' => 'required',
            'timestamp' => 'required',
        ]);

        $fotoName = time() . '_' . uniqid() . '.' . $request->foto->extension();
        $request->foto->storeAs('public/foto_verifikasi', $fotoName);

        Verifikasi::create([
            'foto' => $fotoName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => $request->timestamp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
        ]);
    }


    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        dd($request);
        $request->validate([
            'kegiatan_id' => 'required',
            'kk' => 'required|integer',
            'ktp' => 'required|integer',
            'nama' => 'required',
            'alamat' => 'required',
            'whatsapp' => 'required|min:9',
        ]);

        $kk = $request->kk;
        $ktp = $request->ktp;

        // Query cek apakah sudah ada
        $exists = Pendaftaran::where(function ($q) use ($kk, $ktp) {
            $q->where('kk', $kk)
            ->orWhere('ktp', $ktp);
        })
        ->when($id, fn ($q) => $q->where('id', '!=', $id))
        ->exists();


        // Jika sudah ada -> fail
        if ($exists) {

            return back()->with('error', 'Data pendaftaran sudah');

        } else {

            $data = Pendaftaran::where('id', $id)
            ->update([
                'kk' => $request->kk,
                'ktp' => $request->ktp,
                'nama' => $request->nama,
                'whatsapp' => $request->whatsapp,
                'alamat' => $request->alamat,
            ]);


            return redirect()->route('pendaftaran.index', $request->kegiatan_id)->with('success', 'Data berhasil update!');

        }
    }

}
