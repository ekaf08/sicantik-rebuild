<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilRisiko extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_risiko';

    protected $fillable = ['bumil_id', 'jenis_risiko', 'keterangan', 'tanggal'];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];

    public function bumil()
    {
        return $this->belongsTo(Bumil::class, 'bumil_id');
    }
}
