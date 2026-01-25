<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    protected $guard_name = 'web';
    protected $table = 'master_barang';
    protected $fillable = ['nama', 'harga_modal', 'harga_jual','kategori'];
}
