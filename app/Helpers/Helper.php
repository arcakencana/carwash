<?php

namespace App\Helpers;

use App\Models\kelurahan;
use App\Models\Kuota;
use App\Models\Pendaftaran;

class Helper
{
    public static function getJamAntrian($noAntrian)
    {
        if ($noAntrian >= 1 && $noAntrian <= 500) {
            return '08:00 - 10:00';
        } elseif ($noAntrian >= 501 && $noAntrian <= 1000) {
            return '10:00 - 12:00';
        } elseif ($noAntrian >= 1001) {
            return '12:00 - selesai';
        } else {
            return '-';
        }
    }

    public static function getKuotaKelurahan($kegiatan_id, $kelurahan_id)
    {
        $kuota = Kuota::select('kelurahans.name', 'kuotas.jumlah')
        ->join('kelurahans', 'kelurahans.id', '=', 'kuotas.kelurahan_id')
        ->where([
            'kuotas.kelurahan_id' => $kelurahan_id,
            'kegiatan_id' => $kegiatan_id,
        ])
        ->first();

        return $kuota;
    }

    public static function getPendaftaranKelurahan($kegiatan_id, $kelurahan_id)
    {
        $jumlah = Pendaftaran::where('kegiatan_id', $kegiatan_id)
        ->where('kelurahan_id', $kelurahan_id)
        ->count();

        return $jumlah;
    }

    public static function getNextNomorUrutKelurahan($kegiatan_id, $kelurahan_id)
    {
        $jumlah = Pendaftaran::where('kegiatan_id', $kegiatan_id)
        ->where('kelurahan_id', $kelurahan_id)
        ->count();

        return $jumlah + 1;
    }

    public static function getKecamatanByKelurahan($kelurahan_id)
    {
        $data = Kelurahan::select('kecamatans.id', 'kecamatans.name')
        ->join('kecamatans', 'kelurahans.kecamatan_id', '=', 'kecamatans.id')
        ->where('kelurahans.id', $kelurahan_id)
        ->first();

        return $data;
    }

}
