<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\PraPenelitian;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    /**
     * Tampilkan halaman konsultasi
     */
    public function index()
    {
        // Ambil data pra penelitian milik user
        $praPenelitian = PraPenelitian::where('user_id', auth()->id())->firstOrFail();

        // Ambil data pengajuan (untuk cek CI sudah di-assign)
        $pengajuan = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'pra_penelitian')
            ->first();

        // Cek apakah CI sudah di-assign
        if (!$pengajuan || !$pengajuan->ci_nama) {
            return redirect()->route('pengajuan.index')
                ->with('error', 'Anda belum mendapatkan CI. Silakan hubungi admin.');
        }

        // Ambil history konsultasi
        $konsultasi = Konsultasi::where('pra_penelitian_id', $praPenelitian->id)
            ->orderBy('tanggal_konsul', 'desc')
            ->get();

        $totalKonsul = $konsultasi->count();
        $minKonsul = 2;

        return view('konsultasi.index', compact('praPenelitian', 'pengajuan', 'konsultasi', 'totalKonsul', 'minKonsul'));
    }

    /**
     * Simpan hasil konsultasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_konsul' => 'required|date',
            'hasil_konsul' => 'required|string|min:10',
        ]);

        $praPenelitian = PraPenelitian::where('user_id', auth()->id())->firstOrFail();

        Konsultasi::create([
            'pra_penelitian_id' => $praPenelitian->id,
            'user_id' => auth()->id(),
            'tanggal_konsul' => $request->tanggal_konsul,
            'hasil_konsul' => $request->hasil_konsul,
        ]);

        return back()->with('success', 'Hasil konsultasi berhasil disimpan!');
    }

    /**
     * Edit konsultasi
     */
    public function edit($id)
    {
        $konsultasi = Konsultasi::where('user_id', auth()->id())->findOrFail($id);
        $praPenelitian = PraPenelitian::where('user_id', auth()->id())->firstOrFail();
        
        $pengajuan = Pengajuan::where('user_id', auth()->id())
            ->where('jenis', 'pra_penelitian')
            ->first();

        $allKonsultasi = Konsultasi::where('pra_penelitian_id', $praPenelitian->id)
            ->orderBy('tanggal_konsul', 'desc')
            ->get();

        $totalKonsul = $allKonsultasi->count();
        $minKonsul = 2;

        return view('konsultasi.edit', compact('konsultasi', 'praPenelitian', 'pengajuan', 'allKonsultasi', 'totalKonsul', 'minKonsul'));
    }

    /**
     * Update konsultasi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_konsul' => 'required|date',
            'hasil_konsul' => 'required|string|min:10',
        ]);

        $konsultasi = Konsultasi::where('user_id', auth()->id())->findOrFail($id);

        $konsultasi->update([
            'tanggal_konsul' => $request->tanggal_konsul,
            'hasil_konsul' => $request->hasil_konsul,
        ]);

        return redirect()->route('konsultasi.index')->with('success', 'Hasil konsultasi berhasil diperbarui!');
    }

    /**
     * Hapus konsultasi
     */
    public function destroy($id)
    {
        $konsultasi = Konsultasi::where('user_id', auth()->id())->findOrFail($id);
        $konsultasi->delete();

        return back()->with('success', 'Hasil konsultasi berhasil dihapus!');
    }
}