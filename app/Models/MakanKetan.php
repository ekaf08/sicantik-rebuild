<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MakanKetan extends Model
{
    use SoftDeletes;
    protected $table = 'makan_ketan';

    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'nama_dasa_wisma',
        'rt',
        'rw',
        'jumlah_rumah',
        'tahun',
        'juara',
        'foto_1',
        'foto_2',
    ];
}
