<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MasterBarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = MasterBarang::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $masterBarang = $query->latest()->paginate(30);
        $masterBarang->appends(['search' => $search]);

        return view('master-barang.index', compact('masterBarang', 'search'));
    }

    public function create()
    {
        return view('master-barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_modal' => 'required|integer',
            'harga_jual' => 'required|integer',
            'kategori' => 'required|string',
        ]);

        $data = $request->only('nama', 'harga_modal', 'harga_jual', 'kategori');
        $masterBarang = MasterBarang::create($data);

        return redirect()->route('master-barang.index')->with('success', 'Master Barang berhasil ditambahkan!');
    }

    public function edit(MasterBarang $masterBarang)
    {
        return view('master-barang.edit', compact('masterBarang'));
    }

    public function update(Request $request, MasterBarang $masterBarang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_modal' => 'required|integer',
            'harga_jual' => 'required|integer',
            'kategori' => 'required|string',
        ]);

        $data = $request->only('nama', 'harga_modal', 'harga_jual', 'kategori');
        $masterBarang->update($data);

        return redirect()->route('master-barang.index')->with('success', 'Master Barang berhasil diperbarui!');
    }

    public function destroy(MasterBarang $masterBarang)
    {
        try {
            $masterBarang->delete();

            return redirect()
            ->route('master-barang.index')
            ->with('success', 'Master Barang berhasil dihapus!');
        } catch (\Exception $e) {
            // Bisa tulis log jika ingin debug
            \Log::error('Gagal menghapus master barang: ' . $e->getMessage());

            return redirect()
            ->route('master-barang.index')
            ->with('error', 'Gagal menghapus master barang! Silakan coba lagi.');
        }
    }
}
