<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WhatsappHelper;
use App\Models\Kegiatan;
use App\Models\Kecamatan;
use App\Models\Pendaftaran;

class PendaftaranKhususController extends Controller
{
    public function create($id)
    {
        $id = decrypt($id);

        $data['kegiatan'] = Kegiatan::where('id', $id)->first();
        $data['kecamatan'] = Kecamatan::get();

        return view('pendaftaran-khusus.create', $data);
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
        ]);

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

            $existing = Pendaftaran::where('kk', $kk)
            ->orWhere('ktp', $ktp)
            ->orWhere('whatsapp', $whatsapp)
            ->first();

            $errors = [];

            if ($existing->kk == $kk) {
                $errors['kk'] = ['Gagal, Nomor Kartu Keluarga ini sudah digunakan untuk pendaftaran lain.'];
            }

            if ($existing->ktp == $ktp) {
                $errors['ktp'] = ['Gagal, Nomor KTP ini sudah digunakan untuk pendaftaran lain.'];
            }

            if ($existing->whatsapp == $whatsapp) {
                $errors['whatsapp'] = ['Gagal, Nomor WhatsApp ini sudah digunakan untuk pendaftaran lain.'];
            }

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran gagal karena data sudah terdaftar.',
                'errors' => $errors
            ], 409);

        } else {

            $nextNomorUrut = Pendaftaran::getNextNomorUrut($request->kecamatan_id);

            $data = Pendaftaran::create([
                'kk' => $request->kk,
                'ktp' => $request->ktp,
                'nama' => $request->nama,
                'whatsapp' => $request->whatsapp,
                'alamat' => $request->alamat,
                'lansia_disabilitas' => 'ya',
                'antrian' => $nextNomorUrut,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'kegiatan_id' => $id,
            ]);

            $nama       = $request->nama;
            $noAntrian  = $nextNomorUrut;
            $phone      = '62' . substr($request->whatsapp, 1);
            $link       = route('pendaftaran.download', encrypt($data->id));

            $message = "*Halo $nama,* Pendaftaran kamu berhasil ✅ Nomor Antrian: *$noAntrian* \nSilakan download bukti pendaftaran melalui link berikut: \n $link";

            WhatsappHelper::sendMessage($phone, $message);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan, silahkan menunggu notifikasi undangan pengambilan paket subsidi melalui nomor whatsapp yang telah anda daftarkan atau download bukti pendaftaran di bawah ini.',
                'data' => route('pendaftaran.download', encrypt($data->id))
            ]);

        }

    }

}
