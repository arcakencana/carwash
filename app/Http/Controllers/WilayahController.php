<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getKelurahan($kecamatan_id)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id)->orderBy('name')->get();

        if ($kelurahan->count() > 0) {
            return response()->json([
                'success' => true,
                'data' => $kelurahan
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kelurahan untuk kecamatan ini.'
            ]);
        }
    }
}
