<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pmt extends Model
{
    use SoftDeletes;
    protected $table = 'pmt';

    protected $fillable = [
        'nik',
        'nama_balita',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nama_orang_tua',
        'kecamatan',
        'kelurahan',
        'tahun',
        'putaran',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
    ];
}
