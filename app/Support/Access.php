<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class Access
{
    protected const BYPASS_ROLE_IDS = [1]; // ID Super Admin
    protected const BYPASS_USER_IDS = [2]; // Bypass khusus User ID 2 (Super User tanpa role)

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
            self::$cache = DB::table('menu_role as mr')
                ->join('m_menu as m', 'm.id_menu', '=', 'mr.menu_id')
                ->leftJoin('role_menu_permissions as p', function ($j) use ($user) {
                    $j->on('p.menu_id', '=', 'mr.menu_id')
                      ->where('p.role_id', '=', $user->role_id);
                })
                ->where('mr.role_id', $user->role_id)
                ->whereNull('mr.deleted_at')
                ->whereNull('m.deleted_at')
                ->get(['m.url_menu', 'p.table', 'p.create', 'p.update', 'p.delete'])
                ->mapWithKeys(fn ($r) => ['/' . trim($r->url_menu, '/') => [
                    'table'  => $r->table !== null ? (bool) $r->table : true,
                    'create' => (bool) ($r->create ?? false),
                    'update' => (bool) ($r->update ?? false),
                    'delete' => (bool) ($r->delete ?? false),
                ]])
                ->all();
        }

        return self::$cache['/' . trim($url, '/')][$field] ?? false;
    }
}