<?php

namespace App\Http\Controllers;

use App\Models\Mou; // Pastikan Anda import model Mou/Universitas
use App\Models\PraPenelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PraPenelitianController extends Controller
{
    public function index()
    {
        // Ambil data dengan relasi untuk efisiensi query
        $penelitian = PraPenelitian::with(['mou', 'mahasiswas'])
            ->withCount('mahasiswas') // Ini akan menghasilkan field 'mahasiswas_count'
            ->latest()
            ->paginate(10);

        return view('pra-penelitian.index', compact('penelitian'));
    }

    public function create()
    {
        $mous = Mou::where('tanggal_keluar', '>=', now()->toDateString())->get();
        return view('pra-penelitian.create', compact('mous'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mou_id' => 'required|exists:mous,id',
            'jenis_penelitian' => 'required|in:Data Awal,Uji Validitas,Penelitian',
            'tanggal_mulai' => 'required|date',

            // Validasi untuk data mahasiswa (array)
            'mahasiswas' => 'required|array|min:1',
            'mahasiswas.*.nama' => 'required|string|max:255',
            'mahasiswas.*.no_telpon' => 'required|string|max:20',
            'mahasiswas.*.jenjang' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat data penelitian utama
            $penelitian = PraPenelitian::create([
                'judul' => $request->judul,
                'mou_id' => $request->mou_id,
                'jenis_penelitian' => $request->jenis_penelitian,
                'tanggal_mulai' => $request->tanggal_mulai,
            ]);

            // 2. Loop dan simpan data mahasiswa
            foreach ($request->mahasiswas as $dataMahasiswa) {
                $penelitian->mahasiswas()->create($dataMahasiswa);
            }

            DB::commit();
            return redirect()->route('pra-penelitian.index')->with('success', 'Data pra penelitian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error: Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show(PraPenelitian $praPenelitian)
    {
        // Load relasi
        $praPenelitian->load(['mou', 'mahasiswas']);
        return view('pra-penelitian.show', compact('praPenelitian'));
    }

    public function edit(PraPenelitian $praPenelitian)
    {
        $praPenelitian->load('mahasiswas');
        $mous = Mou::where('tanggal_keluar', '>=', now()->toDateString())->get();
        return view('pra-penelitian.edit', compact('praPenelitian', 'mous'));
    }

    public function update(Request $request, PraPenelitian $praPenelitian)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mou_id' => 'required|exists:mous,id',
            'jenis_penelitian' => 'required|in:Data Awal,Uji Validitas,Penelitian',
            'tanggal_mulai' => 'required|date',
            'mahasiswas' => 'required|array|min:1',
            'mahasiswas.*.nama' => 'required|string|max:255',
            'mahasiswas.*.no_telpon' => 'required|string|max:20',
            'mahasiswas.*.jenjang' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data penelitian utama
            $praPenelitian->update($request->only(['judul', 'mou_id', 'jenis_penelitian', 'tanggal_mulai']));

            // 2. Hapus mahasiswa lama dan tambahkan yang baru (cara paling simpel)
            $praPenelitian->mahasiswas()->delete();

            foreach ($request->mahasiswas as $dataMahasiswa) {
                $praPenelitian->mahasiswas()->create($dataMahasiswa);
            }

            DB::commit();
            return redirect()->route('pra-penelitian.index')->with('success', 'Data pra penelitian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(PraPenelitian $praPenelitian)
    {
        try {
            // Karena kita pakai cascadeOnDelete di migrasi,
            // data mahasiswa akan ikut terhapus.
            $praPenelitian->delete();
            return redirect()->route('pra-penelitian.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Fitur untuk membatalkan penelitian
     */
    public function batal(PraPenelitian $praPenelitian)
    {
        $praPenelitian->update(['status' => 'Batal']);
        return back()->with('success', 'Penelitian telah dibatalkan.');
    }
}
