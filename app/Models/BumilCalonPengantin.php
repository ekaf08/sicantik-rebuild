<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilCalonPengantin extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_calon_pengantin';

    protected $fillable = [
        'bumil_id', 'nik', 'tanggal', 'hasil_pemeriksaan', 'bb', 'tb', 'lila', 'imt',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];
}
