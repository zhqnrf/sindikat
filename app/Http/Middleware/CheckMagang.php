<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pengajuan;

class CheckMagang
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        $cek = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'magang')
            ->where('status', 'approved')
            ->first();

        if (!$cek) {
            abort(403, 'Akses ditolak: Anda belum disetujui untuk magang.');
        }

        return $next($request);
    }
}
