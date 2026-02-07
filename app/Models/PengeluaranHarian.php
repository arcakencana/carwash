<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranHarian extends Model
{
    protected $table = 'pengeluaran_harian';

    protected $fillable = [
        'user_id',
        'tanggal',
        'keterangan',
        'nominal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

