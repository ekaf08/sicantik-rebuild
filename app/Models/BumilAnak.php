<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BumilAnak extends Model
{
    use SoftDeletes;

    protected $table = 'bumil_anak';

    protected $fillable = [
        'persalinan_id', 'nama', 'jenis_kelamin', 'tanggal_lahir',
        'berat_lahir', 'panjang_lahir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public function persalinan()
    {
        return $this->belongsTo(BumilPersalinan::class, 'persalinan_id');
    }
}
