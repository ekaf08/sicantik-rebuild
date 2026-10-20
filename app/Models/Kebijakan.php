<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Kebijakan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_kebijakan';

    protected $fillable = [
        'no_sk',
        'perihal',
        'id_kec',
        'id_kel',
        'tgl_mulai',
        'tgl_selesai',
        'file_sk',
        'keterangan',
        'kota',
        'tahun',
        'pokja',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date:Y-m-d',
        'tgl_selesai' => 'date:Y-m-d',
        'tahun'       => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    protected $appends = ['hash'];

    protected $hidden = ['id'];

    public function getHashAttribute()
    {
        if (!isset($this->attributes['id'])) {
            return null;
        }

        $encrypted = Crypt::encryptString((string) $this->attributes['id']);
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encrypted));
    }
}