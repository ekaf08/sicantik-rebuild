<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilKehamilan extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_kehamilan';

    protected $fillable = [
        'bumil_id', 'tanggal', 'usia_kehamilan', 'hb', 'bb', 'tb',
        'imt', 'lila', 'tensi', 'tfu', 'djj',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];
}
