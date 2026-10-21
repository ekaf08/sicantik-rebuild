<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PisangOrganik extends Model
{
    use SoftDeletes;
    protected $table = 'pisang_organik';

    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'jumlah_tonase',
        'tonase_residu',
        'sampah_terolah_anorganik',
        'sampah_terolah_organik',
        'metode_pengolahan',
        'upload_file_1',
        'upload_file_2',
    ];

    protected $casts = [
        'metode_pengolahan' => 'array',
    ];
}
