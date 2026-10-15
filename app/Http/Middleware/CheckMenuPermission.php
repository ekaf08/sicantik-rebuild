<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Support\Access;
use Closure;
use Illuminate\Http\Request;

class CheckMenuPermission
{
    public function handle(Request $request, Closure $next, ?string $field = null)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $path = '/' . trim($request->path(), '/');

        $menuUrl = Menu::whereNotNull('url_menu')
            ->where('url_menu', '!=', '')
            ->pluck('url_menu')
            ->map(fn ($u) => '/' . trim($u, '/'))
            ->filter(fn ($u) => $u !== '/' && ($path === $u || str_starts_with($path, $u . '/')))
            ->sortByDesc(fn ($u) => strlen($u))
            ->first();

        if (!$menuUrl) {
            return $next($request);
        }

        $field ??= match ($request->method()) {
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
}