<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilPersalinan extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_persalinan';

    protected $fillable = [
        'bumil_id', 'hamil_ke', 'tanggal', 'cara_persalinan',
        'tempat_persalinan', 'status_kelahiran',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];

    public function bumil()
    {
        return $this->belongsTo(Bumil::class, 'bumil_id');
    }

    public function anak()
    {
        return $this->hasMany(BumilAnak::class, 'persalinan_id');
    }

    public function nifas()
    {
        return $this->hasMany(BumilNifas::class, 'persalinan_id');
    }
}
