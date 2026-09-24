<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_menu';
    
    // 1. Ubah primaryKey menjadi 'id_menu'
    protected $primaryKey = 'id_menu'; 
    
    // Karena primary key bertipe integer/auto-increment
    public $incrementing = true;
    protected $keyType = 'int';

    protected $dates = ['deleted_at'];
    protected $guarded = [];

    // 2. Sesuaikan relasi parent (mengacu ke id_menu)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id_menu');
    }

    // 3. Sesuaikan relasi children
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id_menu');
    }

    // 4. Jika ada relasi roles, pastikan local key-nya id_menu
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_menu', 'id_menu', 'id_menu');
    }
}