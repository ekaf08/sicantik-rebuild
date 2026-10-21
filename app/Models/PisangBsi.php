<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PisangBsi extends Model
{
    use SoftDeletes;
    protected $table = 'pisang_bsi';

    protected $fillable = [
        'nama_bsi',
        'alamat_bsi',
        'metode_pengolahan',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'upload_file_1',
        'upload_file_2',
    ];
}
