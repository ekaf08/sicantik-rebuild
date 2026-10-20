<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class DaftarKetuaPkk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_daftar_ketua_pkk';

    protected $fillable = [
        'file_pdf',
        'original_name',
        'created_by',
        'updated_by',
        'deleted_by',
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