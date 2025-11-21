<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class DaftarKegiatanController extends Controller
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

        return view('daftar-kegiatan.index', compact('kegiatans', 'search'));
    }

}
