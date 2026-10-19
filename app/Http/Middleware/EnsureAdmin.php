<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menolak akses dashboard untuk tamu maupun pengguna non-admin.
 * Tamu diarahkan ke halaman login oleh middleware `auth` sebelum middleware ini berjalan.
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke dashboard admin.');
        }

        return $next($request);
    }
}
