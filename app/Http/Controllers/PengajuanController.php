<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        // Cek apakah ada pengajuan pra-penelitian
        $pra = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'pra_penelitian')
            ->latest()
            ->first();

        // Cek apakah ada pengajuan magang
        $magang = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'magang')
            ->latest()
            ->first();

        // Kirim kedua variabel ke view
        return view('pengajuan.index', compact('pra', 'magang'));
    }

    public function ajukanPra()
    {
        // Cek apakah sudah pernah mengajukan dan statusnya belum rejected
        $cek = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'pra_penelitian')
            ->whereIn('status', ['pending', 'approved']) // Kalau rejected boleh ajukan lagi
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah memiliki pengajuan Pra-Penelitian yang aktif.');
        }

        Pengajuan::create([
            'user_id' => auth()->id(),
            'jenis'   => 'pra_penelitian',
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Pengajuan pra-penelitian berhasil dikirim.');
    }

    public function ajukanMagang()
    {
        // Cek apakah sudah pernah mengajukan
        $cek = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'magang')
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah memiliki pengajuan Magang yang aktif.');
        }

        Pengajuan::create([
            'user_id' => auth()->id(),
            'jenis'   => 'magang',
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Pengajuan magang berhasil dikirim.');
    }

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
