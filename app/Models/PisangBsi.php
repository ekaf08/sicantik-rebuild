<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PisangBsi extends Model
{
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
