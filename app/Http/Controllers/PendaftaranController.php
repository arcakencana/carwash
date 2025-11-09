<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WhatsappHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kegiatan;
use App\Models\Kecamatan;
use App\Models\Pendaftaran;
use App\Models\Kuota;

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
                'lansia_disabilitas' => 'tidak',
                'antrian' => $nextNomorUrut,
                // 'berkas' => $path,
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

    public function download($id)
    {
        $id = decrypt($id);

        $pendaftaran = Pendaftaran::select('nama_kegiatan', 'tanggal_kegiatan', 'kk', 'ktp', 'nama', 'alamat', 'whatsapp', 'kecamatans.name as nama_kecamatan', 'lansia_disabilitas', 'antrian', 'pendaftarans.created_at as tanggal_pendaftaran')
        ->join('kecamatans', 'pendaftarans.kecamatan_id', '=', 'kecamatans.id')
        ->join('kegiatans', 'pendaftarans.kegiatan_id', '=', 'kegiatans.id')
        ->where('pendaftarans.id', $id)
        ->first();

        $url = route('pendaftaran.download', encrypt($pendaftaran->id));

        $pdf = Pdf::loadView('pendaftaran.download', compact('pendaftaran', 'url'));

        return $pdf->download($pendaftaran->kk . '.pdf');
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
