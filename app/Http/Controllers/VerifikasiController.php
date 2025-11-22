<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function show($id)
    {
        $id = decrypt($id);

        $data['pendaftaran'] = Pendaftaran::select('pendaftarans.id', 'kk', 'ktp', 'nama', 'alamat', 'whatsapp', 'antrian', 'name')
        ->join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id')
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
        $request->validate([
            'pendaftaran_id' => 'required',
            'selfie_image' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'captured_at' => 'required',
        ]);

        $id = decrypt($request->pendaftaran_id);

        $image = $request->selfie_image;

        // Pisahkan metadata base64
        list($type, $imageData) = explode(';', $image);
        list(, $imageData) = explode(',', $imageData);

        // Decode base64
        $imageData = base64_decode($imageData);

        // Nama file
        $fotoName = time() . '_' . uniqid() . '.jpg';

        // Simpan ke storage
        $path = storage_path('app/public/foto_verifikasi/' . $fotoName);
        file_put_contents($path, $imageData);

        $publicPath = 'storage/foto_verifikasi/' . $fotoName;

        $updated = Pendaftaran::where('id', $id)->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'captured_at' => Carbon::parse($request->captured_at)->format('Y-m-d H:i:s'),
            'photo_path' => $publicPath,
        ]);

        return response()->json([
            'success' => $updated,
            'updated' => $updated,
        ]);

    }

}
