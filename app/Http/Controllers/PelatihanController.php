<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PelatihanController extends Controller
{
    /**
     * Middleware untuk proteksi route, hanya admin.
     */
    public function __construct()
    {
        // ... (konstruktor Anda sudah benar) ...
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of pelatihan
     */
    public function index(Request $request)
    {
        // ... (index method Anda sudah benar) ...
        $query = Pelatihan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('jabatan')) {
            $query->where('jabatan', 'like', '%' . $request->jabatan . '%');
        }
        if ($request->filled('unit')) {
            $query->where('unit', 'like', '%' . $request->unit . '%');
        }

        $pelatihans = $query->orderBy('nama', 'asc')->paginate(10);
        return view('pelatihan.index', compact('pelatihans'));
    }

    /**
     * Show the form for creating a new pelatihan
     */
    public function create()
    {
        return view('pelatihan.create');
    }

    /**
     * Store a newly created pelatihan in storage
     * (LOGIKA DIPERBARUI DENGAN FILE UPLOAD)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:pelatihans,nama',
            'jabatan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'is_pns' => 'required|boolean',
            'nip' => 'nullable|required_if:is_pns,1|string|max:50',
            'golongan' => 'nullable|required_if:is_pns,1|string|max:100',
            'pelatihan_dasar' => 'nullable|array',
            'pelatihan_dasar.*' => 'nullable|string',
            'pelatihan_tahun_simple' => 'nullable|array',
            'pelatihan_tahun_simple.*' => 'nullable|string',

            // --- TAMBAHAN VALIDASI FILE ---
            'pelatihan_file' => 'nullable|array',
            'pelatihan_file.*' => 'nullable|file|mimes:pdf|max:2048', // Maks 2MB per file PDF
        ]);

        $daftarPelatihan = [];
        if ($request->has('pelatihan_dasar')) {
            $namaPelatihan = $request->input('pelatihan_dasar');
            $tahunPelatihan = $request->input('pelatihan_tahun_simple');
            $filePelatihan = $request->file('pelatihan_file'); // Ambil array file

            foreach ($namaPelatihan as $index => $nama) {
                if (!empty($nama)) {

                    // --- TAMBAHAN LOGIKA PENYIMPANAN FILE ---
                    $filePath = null;
                    if (isset($filePelatihan[$index]) && $filePelatihan[$index]->isValid()) {
                        $file = $filePelatihan[$index];
                        // Buat nama unik & simpan di 'public/pelatihan_pdf'
                        $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('pelatihan_pdf', $fileName, 'public');
                    }
                    // --- AKHIR LOGIKA FILE ---

                    $daftarPelatihan[] = [
                        'nama'  => $nama,
                        'tahun' => $tahunPelatihan[$index] ?? null,
                        'file'  => $filePath, // Simpan path file
                    ];
                }
            }
        }

        $data['pelatihan_dasar'] = $daftarPelatihan;

        unset($data['pelatihan_tahun_simple']);
        unset($data['pelatihan_file']); // Hapus dari data utama
        unset($data['data_tahun']);

        Pelatihan::create($data);
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    /**
     * Display the specified pelatihan
     */
    public function show($id)
    {
        // ... (show method Anda sudah benar) ...
        $pelatihan = Pelatihan::findOrFail($id);
        return view('pelatihan.show', compact('pelatihan'));
    }

    /**
     * Show the form for editing the specified pelatihan
     */
    public function edit($id)
    {
        // ... (edit method Anda sudah benar) ...
        $pelatihan = Pelatihan::findOrFail($id);
        return view('pelatihan.edit', compact('pelatihan'));
    }

    /**
     * Update the specified pelatihan in storage
     * (LOGIKA DIPERBARUI DENGAN FILE UPLOAD)
     */
    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:pelatihans,nama,' . $id,
            'jabatan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'is_pns' => 'required|boolean',
            'nip' => 'nullable|required_if:is_pns,1|string|max:50',
            'golongan' => 'nullable|required_if:is_pns,1|string|max:100',
            'pelatihan_dasar' => 'nullable|array',
            'pelatihan_dasar.*' => 'nullable|string',
            'pelatihan_tahun_simple' => 'nullable|array',
            'pelatihan_tahun_simple.*' => 'nullable|string',

            // --- TAMBAHAN VALIDASI FILE ---
            'pelatihan_file' => 'nullable|array',
            'pelatihan_file.*' => 'nullable|file|mimes:pdf|max:2048',
            'pelatihan_existing_file' => 'nullable|array', // Untuk melacak file lama
            'pelatihan_existing_file.*' => 'nullable|string',
        ]);

        $daftarPelatihan = [];
        if ($request->has('pelatihan_dasar')) {
            $namaPelatihan = $request->input('pelatihan_dasar');
            $tahunPelatihan = $request->input('pelatihan_tahun_simple');
            $filePelatihanBaru = $request->file('pelatihan_file'); // Array file baru
            $fileLama = $request->input('pelatihan_existing_file'); // Array path file lama

            foreach ($namaPelatihan as $index => $nama) {
                if (!empty($nama)) {
                    // Ambil path file lama dari hidden input
                    $filePath = $fileLama[$index] ?? null;

                    // Cek jika ada file BARU diupload di index ini
                    if (isset($filePelatihanBaru[$index]) && $filePelatihanBaru[$index]->isValid()) {
                        $file = $filePelatihanBaru[$index];

                        // Hapus file lama jika ada
                        if ($filePath && Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }

                        // Store file baru
                        $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('pelatihan_pdf', $fileName, 'public');
                    }

                    $daftarPelatihan[] = [
                        'nama'  => $nama,
                        'tahun' => $tahunPelatihan[$index] ?? null,
                        'file'  => $filePath,
                    ];
                }
            }

             // --- Logika Hapus File Yg Dihapus dari Form ---
            // Dapatkan semua file path yg *disubmit*
            $submittedFilePaths = collect($daftarPelatihan)->pluck('file')->filter();
            // Dapatkan semua file path yg *ada di DB*
            $originalFilePaths = collect($pelatihan->pelatihan_dasar)->pluck('file')->filter();
            // Cari file yg ada di DB tapi tidak ada di submit (artinya barisnya dihapus)
            $filesToDelete = $originalFilePaths->diff($submittedFilePaths);

            foreach ($filesToDelete as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $data['pelatihan_dasar'] = $daftarPelatihan;

        unset($data['pelatihan_tahun_simple']);
        unset($data['data_tahun']);
        unset($data['pelatihan_file']);
        unset($data['pelatihan_existing_file']);

        $pelatihan->update($data);
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    /**
     * Remove the specified pelatihan from storage
     * (LOGIKA DIPERBARUI DENGAN HAPUS FILE)
     */
    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        // --- TAMBAHAN: HAPUS FILE PDF TERKAIT ---
        if (is_array($pelatihan->pelatihan_dasar)) {
            foreach ($pelatihan->pelatihan_dasar as $item) {
                $filePath = $item['file'] ?? null;
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
        // --- AKHIR HAPUS FILE ---

        $pelatihan->delete();
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

    /**
     * Export pelatihan to Excel
     */
    public function export()
    {
        // ... (export method Anda sudah benar) ...
        try {
            $pelatihans = Pelatihan::all();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // TAMBAHAN: Kolom 'FILE PDF'
            $headers = ['NAMA', 'JABATAN', 'UNIT', 'STATUS', 'NIP', 'GOLONGAN', 'DAFTAR PELATIHAN (TAHUN)', 'FILE PDF'];
            $sheet->fromArray([$headers], null, 'A1');

            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '7c1316']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ];
            // Ubah range header
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

            $row = 2;
            foreach ($pelatihans as $p) {
                $daftarPelatihanStr = '';
                $daftarFileStr = ''; // TAMBAHAN

                if (is_array($p->pelatihan_dasar)) {
                    $items = [];
                    $files = []; // TAMBAHAN
                    foreach ($p->pelatihan_dasar as $item) {
                        $nama = $item['nama'] ?? 'N/A';
                        $tahun = $item['tahun'] ?? '?';
                        $items[] = "{$nama} ({$tahun})";

                        // TAMBAHAN: Kumpulkan link file
                        if (!empty($item['file'])) {
                            $files[] = Storage::url($item['file']);
                        }
                    }
                    $daftarPelatihanStr = implode('; ', $items);
                    $daftarFileStr = implode('; ', $files); // TAMBAHAN
                }

                $rowData = [
                    $p->nama,
                    $p->jabatan,
                    $p->unit,
                    $p->is_pns ? 'PNS' : 'Non-PNS',
                    $p->is_pns ? $p->nip : '',
                    $p->is_pns ? $p->golongan : '',
                    $daftarPelatihanStr,
                    $daftarFileStr // TAMBAHAN
                ];

                $sheet->fromArray([$rowData], null, 'A' . $row);
                $row++;
            }

            // Ubah range auto-size
            foreach (range('A', 'H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $fileName = 'Pelatihan_' . date('Y-m-d_His') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Import pelatihan from Excel
     */
    public function import_excel(Request $request)
    {
        // ... (import_excel method Anda sudah benar) ...
        // Catatan: Impor PDF dari Excel tidak praktis, jadi method ini
        // hanya akan mengimpor data teks seperti sebelumnya.
        try {
            $request->validate(['data' => 'required|string']);
            $rows = json_decode($request->input('data'), true);

            if (empty($rows)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data untuk diimpor.'], 422);
            }

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $rowIndex = $index + 2;

                try {
                    $data = [
                        'nama' => $row['Nama'] ?? null,
                        'jabatan' => $row['Jabatan'] ?? null,
                        'unit' => $row['Unit'] ?? null,
                        'is_pns' => (isset($row['is_pns (1=PNS, 0=Non-PNS)']) && $row['is_pns (1=PNS, 0=Non-PNS)'] == '1'),
                        'nip' => $row['NIP'] ?? null,
                        'golongan' => $row['Golongan'] ?? null,
                    ];

                    if (empty($data['nama'])) {
                        $errors[] = "Baris " . $rowIndex . ": Nama tidak boleh kosong";
                        continue;
                    }

                    $daftarPelatihan = [];
                    $i = 1;
                    while (true) {
                        $namaKey = "Pelatihan{$i}_Nama";
                        $tahunKey = "Pelatihan{$i}_Tahun";

                        if (!isset($row[$namaKey]) || empty($row[$namaKey])) {
                            break;
                        }

                        $daftarPelatihan[] = [
                            'nama' => $row[$namaKey],
                            'tahun' => $row[$tahunKey] ?? null,
                            'file' => null, // File tidak diimpor dari Excel
                        ];
                        $i++;
                    }
                    $data['pelatihan_dasar'] = $daftarPelatihan;

                    Pelatihan::updateOrCreate(
                        ['nama' => $data['nama']],
                        $data
                    );

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . $rowIndex . ": " . $e->getMessage();
                }
            }

            $message = "Berhasil impor/update {$imported} data.";
            if (count($errors) > 0) {
                 $message .= " Ditemukan " . count($errors) . " error.";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'errors' => $errors,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import gagal: ' . $e->getMessage(),
            ], 422);
        }
    }
}
