<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kemangi extends Model
{
    use SoftDeletes;

    protected $table = 'kemangi';

    protected $fillable = [
        'kelompok',
        'kecamatan',
        'kelurahan',
        'tahun',
        'nilai_pre',
        'nilai_post',
        'jumlah_peserta',
    ];
}
