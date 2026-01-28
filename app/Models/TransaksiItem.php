<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $guard_name = 'web';
    protected $table = 'transaksi_items';
    protected $fillable = [
        'id',
        'transaksi_id',
        'master_barang_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class, 'master_barang_id');
    }
}
