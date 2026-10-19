<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getEncIdAttribute()
    {
        return strtr(Crypt::encryptString($this->id), '+/', '-_');
    }

    public static function decId(string $encId)
    {
        try {
            $original = strtr($encId, '-_', '+/');
            return Crypt::decryptString($original);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_role', 'role_id', 'menu_id')
                    ->wherePivotNull('deleted_at');
    }
}
