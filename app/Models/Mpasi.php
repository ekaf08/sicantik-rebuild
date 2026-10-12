<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mpasi extends Model
{
    protected $table = 't_mpasi';

    protected $primaryKey = 'id_mpasi';

    protected $fillable = [
        'judul', 'kategori_usia', 'deskripsi', 'bahan', 'langkah', 'mpasi_foto', 'url_video'
    ];   

    public static function listKategoriUsia()
    {
        return [
            '6-8_bulan'   => '6 - 8 Bulan',
            '9-11_bulan'  => '9 - 11 Bulan',
            '12-23_bulan' => '12 - 23 Bulan',
        ];
    }

}
