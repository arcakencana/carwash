<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function __construct()
    {
        // hanya admin yang bisa kelola kegiatan
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kegiatan::query();

        if ($search) {
            $query->where('nama_kegiatan', 'like', "%{$search}%")
            ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $kegiatans = $query->latest()->paginate(10);
        $kegiatans->appends(['search' => $search]); // biar query search-nya tetap di pagination

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

        Kegiatan::create($data);

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
        if ($kegiatan->banner) {
            Storage::disk('public')->delete($kegiatan->banner);
        }
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
