<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kegiatan extends Model
{
    use HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [];
}
