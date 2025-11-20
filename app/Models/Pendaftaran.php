<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'kk',
        'ktp',
        'nama',
        'whatsapp',
        'alamat',
        'lansia_disabilitas',
        'kecamatan_id',
        'kelurahan_id',
        'kegiatan_id',
        'antrian',
        'latitude',
        'longitude',
        'captured_at',
        'photo_path',
    ];

    public static function getNextNomorUrut(string $kecamatanId): int
    {
        // 1. Cari nilai maksimum dari kolom 'nomor_urut'
        //    hanya untuk data yang memiliki 'kode_wilayah' yang sesuai.
        $lastNumber = self::query()
        ->where('kecamatan_id', $kecamatanId)
        ->max('antrian');

        // 2. Cek apakah ada nomor pendaftaran sebelumnya:
        //    - Jika ada ($lastNumber bukan null), kembalikan $lastNumber + 1.
        //    - Jika tidak ada (baru pertama kali untuk kode wilayah ini), kembalikan 1.

        return $lastNumber ? $lastNumber + 1 : 1;
    }

}
