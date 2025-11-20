<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kelurahan;
use App\Models\Kuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kegiatan::query();

        if ($search) {
            $query->where('nama_kegiatan', 'like', "%{$search}%")
            ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $kegiatans = $query->latest()->paginate(10);
        $kegiatans->appends(['search' => $search]);

        return view('kegiatan.index', compact('kegiatans', 'search'));
    }

    public function create()
    {
        return view('kegiatan.create');
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

        $kegiatan = Kegiatan::create($data);

        $kelurahan = Kelurahan::get();

        foreach ($kelurahan as $value) {

            Kuota::create([
                'kegiatan_id' => $kegiatan->id,
                'kecamatan_id' => $value->kecamatan_id,
                'kelurahan_id' => $value->id,
                'jumlah' => 0,
            ]);

        }

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota_peserta' => 'required|integer|min:1',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('nama_kegiatan', 'deskripsi', 'kuota_peserta');

        if ($request->hasFile('banner')) {
            if ($kegiatan->banner) {
                Storage::disk('public')->delete($kegiatan->banner);
            }
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $kegiatan->update($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        try {

            // Hapus file banner jika ada
            if ($kegiatan->banner) {
                Storage::disk('public')->delete($kegiatan->banner);
            }

            // Hapus data kegiatan
            $kegiatan->delete();

            return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus!');

        } catch (\Exception $e) {

            // Bisa tulis log jika ingin debug
            \Log::error('Gagal menghapus kegiatan: ' . $e->getMessage());

            return redirect()
            ->route('kegiatan.index')
            ->with('error', 'Gagal menghapus kegiatan! Silakan coba lagi.');
        }
    }

    public function kuota($id)
    {
        $id = Crypt::decrypt($id);

        $kegiatan = Kegiatan::select('nama_kegiatan', 'kuota_peserta')
        ->where('id', $id)
        ->first();

        $kuota = Kuota::select('kuotas.id', 'kecamatans.name as nama_kecamatan', 'kelurahans.name as nama_kelurahan', 'jumlah', 'lokasi')
        ->join('kegiatans', 'kuotas.kegiatan_id', '=', 'kegiatans.id')
        ->join('kecamatans', 'kuotas.kecamatan_id', '=', 'kecamatans.id')
        ->join('kelurahans', 'kuotas.kelurahan_id', '=', 'kelurahans.id')
        ->where('kegiatan_id', $id)
        ->get();

        return view('kegiatan.kuota', compact('kegiatan', 'kuota'));
    }

    public function kuotaUpdateMassal(Request $request)
    {
        $jumlah = $request->input('jumlah');
        $lokasi = $request->input('lokasi');

        foreach ($jumlah as $id => $value) {
            Kuota::where('id', $id)->update([
                'jumlah' => $value,
                'lokasi' => $lokasi[$id] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Kuota berhasil diperbarui!');
    }

}
