<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'total_pendaftaran'   => Pendaftaran::count(),
            'total_terverifikasi' => Pendaftaran::where('photo_path', '!=', null)->count(),
            'total_belum'         => Pendaftaran::where('photo_path', '=', null)->count(),
            'total_user'          => User::count(),
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
