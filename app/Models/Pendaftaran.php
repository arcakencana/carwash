<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

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
    ];

}
