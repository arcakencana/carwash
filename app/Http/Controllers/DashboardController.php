<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Kegiatan;
use App\Models\Kuota;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->kelurahan_id == 0) {

            $kegiatan = Kegiatan::first();
            $kuota = Kuota::sum('jumlah');

            return view('dashboard.index', [
                'nama' => 'Total',
                'kuota' => $kuota,
                'total_pendaftaran' => Pendaftaran::count(),
                'total_terverifikasi' => Pendaftaran::where('photo_path', '!=', null)->count(),
                'total_belum' => Pendaftaran::where('photo_path', '=', null)->count(),
            ]);

        } else {

            $kegiatan = Kegiatan::first();
            $kelurahan_id = Auth::user()->kelurahan_id;

            $kuota = Helper::getKuotaKelurahan($kegiatan->id, $kelurahan_id);
            $pendaftar = Helper::getPendaftaranKelurahan($kegiatan->id, $kelurahan_id);

            $data['nama'] = $kuota->name;
            $data['kuota'] = $kuota->jumlah;

            $data['total_pendaftaran'] = Pendaftaran::where('kelurahan_id', $kelurahan_id)
            ->count();

            $data['total_terverifikasi'] = Pendaftaran::where('photo_path', '!=', null)
            ->where('kelurahan_id', '=', $kelurahan_id)
            ->count();

            $data['total_belum'] = Pendaftaran::where('photo_path', '=', null)
            ->where('kelurahan_id', '=', $kelurahan_id)
            ->count();

            return view('dashboard.index', $data);

        }

    }

    public function grafikHarian()
    {
        if (Auth::user()->kelurahan_id == 0) {

            $data = Pendaftaran::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

            return response()->json($data);

        } else {

            $kelurahan_id = Auth::user()->kelurahan_id;

            $data = Pendaftaran::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->where('kelurahan_id', $kelurahan_id)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

            return response()->json($data);

        }

    }

}
