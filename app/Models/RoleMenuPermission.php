<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenuPermission extends Model
{
    protected $table = 'role_menu_permissions';

    protected $fillable = [
        'menu_id', 'role_id',
        'table', 'create', 'update', 'delete', 'can_access',
    ];

    protected $casts = [
        'table'      => 'boolean',
        'create'     => 'boolean',
        'update'     => 'boolean',
        'delete'     => 'boolean',
        'can_access' => 'boolean',
    ];

}
