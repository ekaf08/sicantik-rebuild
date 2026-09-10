<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'm_kelurahan';
    protected $primaryKey = 'id_kel';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'id_kel', 'id_kel');
    }
}
