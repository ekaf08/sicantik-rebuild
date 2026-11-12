<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilNifas extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_nifas';

    protected $fillable = [
        'bumil_id', 'persalinan_id', 'tanggal', 'hari_nifas',
        'tensi', 'suhu', 'kondisi_ibu',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];

    public function bumil()
    {
        return $this->belongsTo(Bumil::class, 'bumil_id');
    }

    public function persalinan()
    {
        return $this->belongsTo(BumilPersalinan::class, 'persalinan_id');
    }
}
