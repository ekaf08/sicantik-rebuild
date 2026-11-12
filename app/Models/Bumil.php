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
        'hamil_ke',             // kehamilan yang ke berapa
        'alamat',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'status_kek',   // KEK / Tidak KEK (untuk ibu hamil)
        'resti',        // true = ibu hamil risiko tinggi
        'tanggal',      // tanggal pendataan (dipakai filter bulan dan tahun)
        'tanggal_melahirkan',   // terisi = sudah melahirkan (pindah ke nifas)
    ];

    protected $casts = [
        'resti'              => 'boolean',
        'tanggal'            => 'date:Y-m-d',
        'tanggal_melahirkan' => 'date:Y-m-d',
    ];

    public function kehamilan()
    {
        return $this->hasMany(BumilKehamilan::class, 'bumil_id');
    }

    public function calonPengantin()
    {
        return $this->hasMany(BumilCalonPengantin::class, 'bumil_id');
    }

    public function risiko()
    {
        return $this->hasMany(BumilRisiko::class, 'bumil_id');
    }

    public function persalinan()
    {
        return $this->hasMany(BumilPersalinan::class, 'bumil_id');
    }

    public function nifas()
    {
        return $this->hasMany(BumilNifas::class, 'bumil_id');
    }
}
