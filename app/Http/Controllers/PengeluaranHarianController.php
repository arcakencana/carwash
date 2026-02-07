<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranHarian;
use Illuminate\Http\Request;

class PengeluaranHarianController extends Controller
{
    public function index()
    {
        $data = PengeluaranHarian::with('user')
        ->whereDate('tanggal', now())
        ->orderBy('id', 'desc')
        ->get();

        $total = $data->sum('nominal');

        return view('pengeluaran.index', compact('data', 'total'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0'
        ]);

        PengeluaranHarian::create([
            'user_id'    => auth()->id(),
            'tanggal'    => now()->toDateString(),
            'keterangan' => strtoupper($request->keterangan),
            'nominal'    => $request->nominal
        ]);

        return redirect()->route('pengeluaran.index')
        ->with('success', 'Pengeluaran berhasil disimpan');
    }

    public function edit(PengeluaranHarian $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, PengeluaranHarian $pengeluaran)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        $pengeluaran->update([
            'keterangan' => strtoupper($request->keterangan),
            'nominal'    => $request->nominal,
        ]);

        return redirect()
        ->route('pengeluaran.index')
        ->with('success', 'Pengeluaran berhasil diupdate');
    }

    public function destroy(PengeluaranHarian $pengeluaran)
    {
        $pengeluaran->delete();

        return redirect()
        ->route('pengeluaran.index')
        ->with('success', 'Pengeluaran berhasil dihapus');
    }

}
