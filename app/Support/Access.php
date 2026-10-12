<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class Access
{
    protected const BYPASS_ROLE_IDS = [1];

    protected const BYPASS_USER_IDS = [2];

    protected static ?array $cache = null;

    public static function flush(): void
    {
        self::$cache = null;
    }

    public static function can(string $url, string $field = 'table'): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if (in_array((int) $user->id, self::BYPASS_USER_IDS, true)
            || in_array((int) $user->role_id, self::BYPASS_ROLE_IDS, true)) {
            return true;
        }

        if (self::$cache === null) {
            self::$cache = DB::table('role_menu_permissions as p')
                ->join('menu_role as mr', function ($j) {
                    $j->on('mr.menu_id', '=', 'p.menu_id')
                      ->on('mr.role_id', '=', 'p.role_id');
                })
                ->join('m_menu as m', 'm.id_menu', '=', 'p.menu_id')
                ->where('p.role_id', $user->role_id)
                ->whereNull('p.deleted_at')
                ->whereNull('mr.deleted_at')
                ->whereNull('m.deleted_at')
                ->get(['m.url_menu', 'p.table', 'p.create', 'p.update', 'p.delete'])
                ->mapWithKeys(fn ($r) => ['/' . trim($r->url_menu, '/') => [
                    'table'  => (bool) $r->table,
                    'create' => (bool) $r->create,
                    'update' => (bool) $r->update,
                    'delete' => (bool) $r->delete,
                ]])
                ->all();
        }

        return self::$cache['/' . trim($url, '/')][$field] ?? false;
    }
}