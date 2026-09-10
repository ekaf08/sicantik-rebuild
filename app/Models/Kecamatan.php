<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_kecamatan';
    protected $primaryKey = 'id_kec';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'id_kec', 'id_kec');
    }
}
