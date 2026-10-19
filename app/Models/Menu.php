<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['enc_id'];

    public function getEncIdAttribute(): string
    {
        return Crypt::encryptString((string) $this->id_menu);
    }

    protected $table = 'm_menu';
    
    protected $primaryKey = 'id_menu'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $guarded = [];

    // Relasi User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relasi parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id_menu');
    }

    // Relasi children
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id_menu')
                    ->whereIn('status_menu', ['1', 'Aktif'])
                    ->orderBy('urutan');
    }

    // Relasi roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role', 'menu_id', 'role_id')
                    ->wherePivotNull('deleted_at');
    }
}