<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bumil extends Model
{
    use SoftDeletes;

    protected $table = 'bumil';

    protected $fillable = [
        'kategori',     // hamil / nifas
        'no_kk',
        'nik',
        'nama',
        'usia',
        'alamat',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'status_kek',   // KEK / Tidak KEK (untuk ibu hamil)
        'resti',        // true = ibu hamil risiko tinggi
        'tanggal',      // tanggal pendataan (dipakai filter bulan dan tahun)
    ];

    protected $casts = [
        'resti'   => 'boolean',
        'tanggal' => 'date:Y-m-d',
    ];

    public function kehamilan()
    {
        return $this->hasMany(BumilKehamilan::class, 'bumil_id');
    }

    public function calonPengantin()
    {
        return $this->hasMany(BumilCalonPengantin::class, 'bumil_id');
    }
}
