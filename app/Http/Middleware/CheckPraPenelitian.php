<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pengajuan;

class CheckPraPenelitian
{
    public function handle($request, Closure $next)
    {
        // Admin selalu boleh masuk
        if (auth()->user()->role === 'admin') {
            return $next($request);
        }

        // User biasa harus punya approve pra-penelitian
        $cek = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'pra_penelitian')
            ->where('status', 'approved')
            ->first();

        if (!$cek) {
            abort(403, 'Akses ditolak: Anda belum disetujui untuk pra penelitian.');
        }

        return $next($request);
    }
}
