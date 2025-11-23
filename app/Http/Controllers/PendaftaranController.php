<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\WhatsappHelper;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index(Request $request, $id)
    {
        $id_kegiatan = decrypt($id);
        $kelurahan_id = Auth::user()->kelurahan_id;
        $search = $request->input('search');

        $query = Pendaftaran::query();

        if ($search) {
            $query->where('kk', 'like', "%{$search}%")
            ->orWhere('ktp', 'like', "%{$search}%")
            ->orWhere('nama', 'like', "%{$search}%");
        }

        $query->where([
            'kegiatan_id' => $id_kegiatan,
            'kelurahan_id' => $kelurahan_id,
        ]);

        $pendaftarans = $query->latest()->paginate(10);
        $pendaftarans->appends(['search' => $search]);

        $kuota = Helper::getKuotaKelurahan($id_kegiatan, $kelurahan_id);
        $pendaftar = Helper::getPendaftaranKelurahan($id_kegiatan, $kelurahan_id);

        $label = 'Jumlah Pendaftar ' . $kuota->name . ' ' . $pendaftar . ' dari ' . $kuota->jumlah;

        return view('pendaftaran.index', compact('pendaftarans', 'search', 'id_kegiatan', 'label'));
    }

    public function create($id)
    {
        $id = decrypt($id);
        $kelurahan_id = Auth::user()->kelurahan_id;

        $kuota = Helper::getKuotaKelurahan($id, $kelurahan_id);
        $pendaftar = Helper::getPendaftaranKelurahan($id, $kelurahan_id);

        $data['label'] = 'Jumlah Pendaftar ' . $kuota->name . ' ' . $pendaftar . ' dari ' . $kuota->jumlah;
        $data['kegiatan'] = Kegiatan::where('id', $id)->first();

        return view('pendaftaran.create', $data);
    }

    public function store(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'kk' => 'required|integer',
            'ktp' => 'required|integer',
            'nama' => 'required',
            'alamat' => 'required',
            'whatsapp' => 'required|min:9',
        ]);

        $kk = $request->kk;
        $ktp = $request->ktp;

        // Query cek apakah sudah ada
        $exists = Pendaftaran::query()
        ->where(function ($q) use ($kk, $ktp) {
            if ($kk) {
                $q->where('kk', $kk);
            }
            if ($ktp) {
                $q->orWhere('ktp', $ktp);
            }
        })
        ->exists();

        // Jika sudah ada -> fail
        if ($exists) {

            $existing = Pendaftaran::where('kk', $kk)
            ->orWhere('ktp', $ktp)
            ->first();

            $errors = [];

            if ($existing->kk == $kk) {
                $errors['kk'] = ['Gagal, Nomor Kartu Keluarga ini sudah digunakan untuk pendaftaran lain.'];
            }

            if ($existing->ktp == $ktp) {
                $errors['ktp'] = ['Gagal, Nomor KTP ini sudah digunakan untuk pendaftaran lain.'];
            }

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran gagal karena data sudah terdaftar.',
                'errors' => $errors,
            ], 409);

        } else {

            $kelurahan_id = Auth::user()->kelurahan_id;
            $kecamatan = Helper::getKecamatanByKelurahan($kelurahan_id);
            $nextNomorUrut = Helper::getNextNomorUrutKelurahan($id, $kelurahan_id);

            $data = Pendaftaran::create([
                'kk' => $request->kk,
                'ktp' => $request->ktp,
                'nama' => $request->nama,
                'whatsapp' => $request->whatsapp,
                'alamat' => $request->alamat,
                'lansia_disabilitas' => 'tidak',
                'antrian' => $nextNomorUrut,
                'kecamatan_id' => $kecamatan->id,
                'kelurahan_id' => $kelurahan_id,
                'kegiatan_id' => $id,
            ]);

            $nama = $request->nama;
            $noAntrian = $nextNomorUrut;
            $phone = '62' . substr($request->whatsapp, 1);
            $link = route('pendaftaran.download', encrypt($data->id));

            $message = "*Halo $nama,* Pendaftaran kamu berhasil ✅ Nomor Antrian: *$noAntrian* \nSilakan download bukti pendaftaran melalui link berikut: \n $link";

            WhatsappHelper::sendMessage($phone, $message);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan, silahkan menunggu notifikasi undangan pengambilan paket subsidi melalui nomor whatsapp yang telah anda daftarkan atau download bukti pendaftaran di bawah ini.',
                'data' => route('pendaftaran.download', encrypt($data->id)),
            ]);

        }

    }

    public function edit($id)
    {
        $id = decrypt($id);

        $pendaftarans = Pendaftaran::findOrFail($id);

        return view('pendaftaran.edit', compact('pendaftarans'));

    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);

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

    public function destroy(Request $request)
    {
        try {

            $id = decrypt($request->id);

            Pendaftaran::where('id', $id)->delete();

            return redirect()
            ->route('pendaftaran.index', $request->kegiatan_id)
            ->with('success', 'Pendaftaran berhasil dihapus!');

        } catch (\Exception $e) {

            // Bisa tulis log jika ingin debug
            \Log::error('Gagal menghapus pendaftaran: ' . $e->getMessage());

            return redirect()
            ->route('pendaftaran.index', $request->kegiatan_id)
            ->with('error', 'Gagal menghapus pendaftaran! Silakan coba lagi.');
        }
    }

    public function laporan($id)
    {
        $id = decrypt($id);

        $kelurahan_id = Auth::user()->kelurahan_id;

        $laporan = Pendaftaran::select(
            'pendaftarans.id as pendaftaran_id',
            'pendaftarans.kk',
            'pendaftarans.ktp',
            'pendaftarans.nama',
            'pendaftarans.alamat',
            'pendaftarans.whatsapp',
            'pendaftarans.antrian',
            'pendaftarans.created_at as tanggal_pendaftaran',
            'kegiatans.nama_kegiatan',
            'kegiatans.tanggal_kegiatan',
            'kecamatans.name as nama_kecamatan',
            'kelurahans.name as nama_kelurahan',
        )
        ->join('kecamatans', 'pendaftarans.kecamatan_id', '=', 'kecamatans.id')
        ->join('kelurahans', 'pendaftarans.kelurahan_id', '=', 'kelurahans.id')
        ->join('kegiatans', 'pendaftarans.kegiatan_id', '=', 'kegiatans.id')
        ->where('pendaftarans.kegiatan_id', $id)
        ->where('pendaftarans.kelurahan_id', $kelurahan_id)
        ->orderBy('pendaftarans.antrian', 'ASC')
        ->get();

        $pdf = Pdf::loadView('pendaftaran.laporan', compact('laporan'));

        return $pdf->download($kelurahan_id . '.pdf');

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
