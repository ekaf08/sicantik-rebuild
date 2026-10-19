<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakanKetan extends Model
{
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
