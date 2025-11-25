<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'total_pendaftaran' => Pendaftaran::count(),
            'total_terverifikasi' => Pendaftaran::where('photo_path', '!=', null)->count(),
            'total_belum' => Pendaftaran::where('photo_path', '=', null)->count(),
        ]);
    }

    public function grafikHarian()
    {
        $data = Pendaftaran::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        return response()->json($data);
    }

}
