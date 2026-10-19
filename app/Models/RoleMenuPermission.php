<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleMenuPermission extends Model
{
    use SoftDeletes;
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
