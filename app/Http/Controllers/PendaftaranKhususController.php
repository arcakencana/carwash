<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsappHelper;
use App\Models\Kecamatan;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PendaftaranKhususController extends Controller
{
    public function index(Request $request, $id)
    {
        $id_kegiatan = decrypt($id);

        $search = $request->input('search');

        $query = Pendaftaran::query();
        $query->select(
            'pendaftarans.id as pendaftaran_id',
            'pendaftarans.kk',
            'pendaftarans.ktp',
            'pendaftarans.nama',
            'pendaftarans.alamat',
            'pendaftarans.whatsapp',
            'pendaftarans.antrian',
            'pendaftarans.created_at',
            'pendaftarans.photo_path',
            'kelurahans.name as nama_kelurahan'
        );
        $query->join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id');

        if ($search) {
            $query->where('kk', 'like', "%{$search}%")
            ->orWhere('ktp', 'like', "%{$search}%")
            ->orWhere('nama', 'like', "%{$search}%");
        }

        $query->where(['kegiatan_id' => $id_kegiatan,]);

        $query->orderBy('pendaftarans.id', 'DESC');

        $pendaftarans = $query->latest()->paginate(10);
        $pendaftarans->appends(['search' => $search]);

        return view('pendaftaran-khusus.index', compact('pendaftarans', 'search', 'id_kegiatan'));
    }

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

        $data = Pendaftaran::create([
            'kk' => $request->kk,
            'ktp' => $request->ktp,
            'nama' => $request->nama,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'lansia_disabilitas' => 'ya',
            'antrian' => 0,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'kegiatan_id' => $id,
        ]);

        $nama = $request->nama;
        $noAntrian = 0;
        $phone = '62' . substr($request->whatsapp, 1);
        $link = route('pendaftaran-khusus.download', encrypt($data->id));

        $message = "*Halo $nama,* Pendaftaran kamu berhasil ✅ Nomor Antrian: *$noAntrian* \nSilakan download bukti pendaftaran melalui link berikut: \n $link";

        WhatsappHelper::sendMessage($phone, $message);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan, silahkan menunggu notifikasi undangan pengambilan paket subsidi melalui nomor whatsapp yang telah anda daftarkan atau download bukti pendaftaran di bawah ini.',
            'data' => route('pendaftaran-khusus.download', encrypt($data->id)),
        ]);

    }

    public function show($id)
    {
        $id = decrypt($id);

        $data['pendaftaran'] = Pendaftaran::select(
            'pendaftarans.id as pendaftaran_id',
            'pendaftarans.kk',
            'pendaftarans.ktp',
            'pendaftarans.nama',
            'pendaftarans.alamat',
            'pendaftarans.whatsapp',
            'pendaftarans.lansia_disabilitas',
            'pendaftarans.antrian',
            'pendaftarans.latitude',
            'pendaftarans.longitude',
            'pendaftarans.captured_at',
            'pendaftarans.photo_path',
            'kegiatans.nama_kegiatan',
            'kecamatans.name as nama_kecamatan',
            'kelurahans.name as nama_kelurahan'
        )
        ->join('kegiatans', 'pendaftarans.kegiatan_id', '=', 'kegiatans.id')
        ->join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id')
        ->join('kecamatans', 'pendaftarans.kecamatan_id', '=', 'kecamatans.id')
        ->where('pendaftarans.id', $id)->first();

        return view('pendaftaran-khusus.show', $data);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        try {

            $id = decrypt($request->id);

            Pendaftaran::where('id', $id)->delete();

            return redirect()
            ->route('pendaftaran-khusus.index', $request->kegiatan_id)
            ->with('success', 'Pendaftaran berhasil dihapus!');

        } catch (\Exception $e) {

            // Bisa tulis log jika ingin debug
            \Log::error('Gagal menghapus pendaftaran: ' . $e->getMessage());

            return redirect()
            ->route('pendaftaran-khusus.index', $request->kegiatan_id)
            ->with('error', 'Gagal menghapus pendaftaran! Silakan coba lagi.');
        }
    }

    public function download($id)
    {
        $id = decrypt($id);

        $pendaftaran = Pendaftaran::select('pendaftarans.id as pendaftaran_id', 'nama_kegiatan', 'tanggal_kegiatan', 'kk', 'ktp', 'nama', 'alamat', 'whatsapp', 'kecamatans.name as nama_kecamatan', 'kelurahans.name as nama_kelurahan', 'antrian', 'pendaftarans.created_at as tanggal_pendaftaran', 'kuotas.lokasi')
        ->join('kecamatans', 'pendaftarans.kecamatan_id', '=', 'kecamatans.id')
        ->join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id')
        ->join('kegiatans', 'pendaftarans.kegiatan_id', '=', 'kegiatans.id')
        ->join('kuotas', 'pendaftarans.kelurahan_id', '=', 'kuotas.kelurahan_id')
        ->where('pendaftarans.id', $id)
        ->first();

        if ($pendaftaran) {

            $url = route('verifikasi.show', encrypt($pendaftaran->pendaftaran_id));

            $pdf = Pdf::loadView('pendaftaran.download', compact('pendaftaran', 'url'));

            return $pdf->download($pendaftaran->kk . '.pdf');

        } else {

            abort(404);
        }

    }

}
