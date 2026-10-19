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

    public static function isSuperUser(): bool
    {
        $user = auth()->user();

        return $user && (
            in_array((int) $user->id, self::BYPASS_USER_IDS, true)
            || in_array((int) $user->role_id, self::BYPASS_ROLE_IDS, true)
        );
    }

    public static function isProtectedUser($user): bool
    {
        return in_array((int) $user->id, self::BYPASS_USER_IDS, true)
            || in_array((int) $user->role_id, self::BYPASS_ROLE_IDS, true);
    }

public static function bypassRoleIds(): array
{
    return self::BYPASS_ROLE_IDS;
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
                        ->where('p.role_id', '=', $user->role_id)
                        ->whereNull('p.deleted_at');
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

   public static function getSidebarMenus()
    {
        $user = auth()->user();
        if (!$user) {
            return collect();
        }

        $menus = \App\Models\Menu::with(['children' => fn ($q) => $q
                ->whereIn('status_menu', ['1', 'Aktif'])
                ->orderBy('urutan')->orderBy('id_menu')])
            ->where(fn ($q) => $q->whereNull('parent_id')->orWhere('parent_id', 0))
            ->whereIn('status_menu', ['1', 'Aktif'])
            ->orderBy('urutan')->orderBy('id_menu')
            ->get();

        return $menus->filter(function ($m) {
            $hadChildren = $m->children->isNotEmpty();

            $allowed = $m->children
                ->filter(fn ($c) => $c->url_menu && self::can($c->url_menu))
                ->values();
            $m->setRelation('children', $allowed);

            return $hadChildren
                ? $allowed->isNotEmpty()
                : ($m->url_menu && self::can($m->url_menu));
        })->values();
    }
}