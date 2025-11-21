<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = Pengajuan::where('user_id', auth()->id())->latest()->first();

        return view('pengajuan.index', compact('pengajuan'));
    }

    public function ajukanPra()
    {
        Pengajuan::create([
            'user_id' => auth()->id(),
            'jenis'   => 'pra_penelitian',
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Pengajuan pra-penelitian berhasil dikirim.');
    }

    public function ajukanMagang()
    {
        Pengajuan::create([
            'user_id' => auth()->id(),
            'jenis'   => 'magang',
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Pengajuan magang berhasil dikirim.');
    }

    // khusus admin
    public function adminIndex()
    {
        $data = Pengajuan::with('user')->latest()->get();
        return view('admin.pengajuan.index', compact('data'));
    }

    public function approve(Pengajuan $pengajuan)
    {
        $pengajuan->update(['status' => 'approved']);
        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Pengajuan $pengajuan)
    {
        $pengajuan->update(['status' => 'rejected']);
        return back()->with('success', 'Pengajuan ditolak.');
    }
}
