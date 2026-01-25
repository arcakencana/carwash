<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guard_name = 'web';
    protected $table = 'transaksi';
    protected $fillable = [
        'kode_transaksi',
        'no_polisi',
        'tanggal',
        'user_id',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

