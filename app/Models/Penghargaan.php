<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    use HasFactory;

    protected $table = 'penghargaans';

    protected $fillable = [
        'nama_penghargaan',
        'deskripsi_penghargaan',
        'kategori_penghargaan',
        'tahun',
        'foto',
        'file',
        'created_by'
    ];
}
