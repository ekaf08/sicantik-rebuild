<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Support\Access;
use Closure;
use Illuminate\Http\Request;

class CheckMenuPermission
{
    private const OPEN_PATHS = [
        '/dashboard', '/logout', '/refresh_captcha',
    ];
    private const OPEN_PREFIXES = [
        '/get-kecamatan/', '/get-kelurahan/',
    ];

    private const FIELD_BY_ROUTE = [
        'permission.access'   => 'update',
        'user.reset-password' => 'update',
        'kebijakan.update'    => 'update', 
        // 'inovasi.kota'     => 'table',   // aktifkan jika POST hanya filter
    ];

    public function handle(Request $request, Closure $next, ?string $field = null)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (Access::isSuperUser()) {
            return $next($request);
        }

        $path = '/' . trim($request->path(), '/');

        if (in_array($path, self::OPEN_PATHS, true)
            || collect(self::OPEN_PREFIXES)->contains(fn ($p) => str_starts_with($path, $p))) {
            return $next($request);
        }

        $menuUrl = $this->menuUrls()
            ->filter(fn ($u) => $path === $u || str_starts_with($path, $u . '/'))
            ->sortByDesc(fn ($u) => strlen($u))
            ->first();

        if (!$menuUrl) {
            abort(403, 'Akses ditolak: route tidak terdaftar di menu.');
        }

        $field ??= self::FIELD_BY_ROUTE[$request->route()?->getName()]
            ?? match ($request->method()) {
                'POST'         => 'create',
                'PUT', 'PATCH' => 'update',
                'DELETE'       => 'delete',
                default        => 'table',
            };

        if (!Access::can($menuUrl, $field)) {
            abort(403, "Akses ditolak: Anda tidak memiliki izin untuk aksi {$field} di menu {$menuUrl}.");
        }

        return $next($request);
    }

    private function menuUrls()
    {
        return Menu::whereNotNull('url_menu')
            ->where('url_menu', '!=', '')
            ->pluck('url_menu')
            ->map(fn ($u) => '/' . trim($u, '/'))
            ->filter(fn ($u) => $u !== '/')
            ->unique()
            ->values();
    }
}