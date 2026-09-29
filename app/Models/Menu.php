<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'm_menu';
    
    protected $primaryKey = 'id_menu'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $guarded = [];

    // Relasi parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id_menu');
    }

    // Relasi children
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id_menu');
    }

    // Relasi roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_menu', 'id_menu', 'id_menu');
    }
}