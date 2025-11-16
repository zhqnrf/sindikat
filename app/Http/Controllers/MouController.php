<?php

namespace App\Http\Controllers;

use App\Models\Mou;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // Tambahkan ini
use Exception; // Tambahkan ini

class MouController extends Controller
{
    /**
     * Halaman LIST (Halaman Kedua)
     * KITA TAMBAHKAN LOGIKA FILTER DI SINI
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        // Mulai query
        $query = Mou::query();

        // 1. Filter Nama Universitas
        if ($request->filled('search')) {
            $query->where('nama_universitas', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Dari Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_masuk', '>=', $request->tanggal_mulai);
        }

        // 3. Filter Sampai Tanggal
        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_keluar', '<=', $request->tanggal_selesai);
        }

        // Ambil data, urutkan, dan paginasi
        // withQueryString() penting agar filter tetap aktif saat pindah halaman
        $mous = $query->latest()->paginate(10)->withQueryString();

        return view('mou.index', compact('mous'));
    }

    /**
     * Halaman CREATE (Halaman Pertama)
     */
    public function create()
    {
        return view('mou.create');
    }

    /**
     * Logika untuk MENYIMPAN data dari form CREATE
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_universitas' => 'required|string|max:255',
            'tanggal_masuk'    => 'required|date',
            'tanggal_keluar'   => 'required|date|after_or_equal:tanggal_masuk',
            'file_mou'         => 'required|file|mimes:pdf,doc,docx|max:5120',
            'surat_keterangan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan'       => 'nullable|string',
        ]);

        // Simpan file_mou, path akan jadi 'public/file_mou/namafile.pdf'
        $pathMou = $request->file('file_mou')->store('public/file_mou');

        // Simpan surat_keterangan
        $pathSurat = $request->file('surat_keterangan')->store('public/surat_keterangan');

        Mou::create([
            'nama_universitas' => $request->nama_universitas,
            'tanggal_masuk'    => $request->tanggal_masuk,
            'tanggal_keluar'   => $request->tanggal_keluar,
            'keterangan'       => $request->keterangan,
            'file_mou'         => $pathMou,
            'surat_keterangan' => $pathSurat,
        ]);

        return redirect()->route('mou.index')
            ->with('success', 'Data MOU berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     * FUNGSI UNTUK TOMBOL EDIT
     */
    public function edit(Mou $mou) // Gunakan Route Model Binding
    {
        // Tampilkan view 'mou.edit' dan kirim data mou yang mau diedit
        return view('mou.edit', compact('mou'));
    }

    /**
     * Update the specified resource in storage.
     * FUNGSI UNTUK MENYIMPAN PERUBAHAN DARI EDIT
     */
    public function update(Request $request, Mou $mou) // Gunakan Route Model Binding
    {
        // 1. Validasi
        // 'nullable' berarti jika tidak ada file baru, file lama tetap dipakai
        $request->validate([
            'nama_universitas' => 'required|string|max:255',
            'tanggal_masuk'    => 'required|date',
            'tanggal_keluar'   => 'required|date|after_or_equal:tanggal_masuk',
            'file_mou'         => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Boleh kosong
            'surat_keterangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Boleh kosong
            'keterangan'       => 'nullable|string',
        ]);

        // 2. Ambil semua data input
        $data = $request->only('nama_universitas', 'tanggal_masuk', 'tanggal_keluar', 'keterangan');

        // 3. Cek jika ada file MOU baru
        if ($request->hasFile('file_mou')) {
            // Hapus file lama
            Storage::delete($mou->file_mou);
            // Simpan file baru
            $data['file_mou'] = $request->file('file_mou')->store('public/file_mou');
        }

        // 4. Cek jika ada file Surat Keterangan baru
        if ($request->hasFile('surat_keterangan')) {
            // Hapus file lama
            Storage::delete($mou->surat_keterangan);
            // Simpan file baru
            $data['surat_keterangan'] = $request->file('surat_keterangan')->store('public/surat_keterangan');
        }

        // 5. Update data di database
        $mou->update($data);

        return redirect()->route('mou.index')
            ->with('success', 'Data MOU berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * FUNGSI UNTUK TOMBOL HAPUS
     */
    public function destroy(Mou $mou) // Gunakan Route Model Binding
    {
        try {
            // 1. Hapus file dari storage
            Storage::delete($mou->file_mou);
            Storage::delete($mou->surat_keterangan);

            // 2. Hapus data dari database
            $mou->delete();

            return redirect()->route('mou.index')
                ->with('success', 'Data MOU berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('mou.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * FUNGSI BARU UNTUK IMPORT EXCEL
     * Ini dipanggil oleh JavaScript 'importMOU()' di view index
     */
    public function importExcel(Request $request)
    {
        // Validasi request harus ada 'data'
        $validator = Validator::make($request->all(), [
            'data' => 'required|json'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data JSON tidak valid.'], 400);
        }

        $data = json_decode($request->data, true);
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            try {
                // Sesuaikan nama kolom dengan template Excel Anda
                $namaUniversitas = $row['Nama Universitas'] ?? null;
                $tglMasuk = $row['Tanggal Masuk (YYYY-MM-DD)'] ?? null;
                $tglKeluar = $row['Tanggal Keluar (YYYY-MM-DD)'] ?? null;

                // Validasi data sederhana
                if (empty($namaUniversitas) || empty($tglMasuk) || empty($tglKeluar)) {
                    throw new Exception("Data tidak lengkap di baris " . ($index + 2));
                }

                // Karena tidak ada upload file via Excel, kita set default/null
                Mou::create([
                    'nama_universitas' => $namaUniversitas,
                    'tanggal_masuk'    => $tglMasuk,
                    'tanggal_keluar'   => $tglKeluar,
                    'keterangan'       => $row['Keterangan'] ?? null,
                    'file_mou'         => 'imported/default.pdf', // Path default
                    'surat_keterangan' => 'imported/default.pdf', // Path default
                ]);

                $successCount++;
            } catch (Exception $e) {
                $errorCount++;
                $errors[] = $e->getMessage();
            }
        }

        if ($errorCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Selesai: $successCount berhasil, $errorCount gagal. Error: " . implode(', ', $errors)
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil mengimpor $successCount data MOU."
        ]);
    }
}
