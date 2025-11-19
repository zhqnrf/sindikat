<?php

namespace App\Http\Controllers;

use App\Models\SuratBalasan;
use App\Models\Mou;
use App\Models\MahasiswaPenelitian;
use Illuminate\Http\Request;
use PDF;

class SuratBalasanController extends Controller
{
    public function index()
    {
        $data = SuratBalasan::with(['mou', 'mahasiswaPenelitian'])->latest()->paginate(10);
        return view('surat_balasan.index', compact('data'));
    }

    public function create()
    {
        $mous = Mou::all();
        $mahasiswa = MahasiswaPenelitian::all();
        return view('surat_balasan.create', compact('mous', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mou_id' => 'required',
            'nama_mahasiswa' => 'required|string',
            'nim' => 'required|string',
            'wa_mahasiswa' => 'required|string',
            'keperluan' => 'required|string',
            'prodi' => 'required|string',
            'lama_berlaku' => 'required|string',
            'data_dibutuhkan' => 'required|string',
        ]);

        SuratBalasan::create($request->all());

        return redirect()->route('surat-balasan.index')
            ->with('success', 'Surat Balasan berhasil ditambahkan.');
    }

    public function edit(SuratBalasan $suratBalasan)
    {
        $mous = Mou::all();
        $mahasiswa = MahasiswaPenelitian::all();

        return view('surat_balasan.edit', compact('suratBalasan', 'mous', 'mahasiswa'));
    }

    public function update(Request $request, SuratBalasan $suratBalasan)
    {
        $request->validate([
            'mou_id' => 'required',
            'nama_mahasiswa' => 'required|string',
            'nim' => 'required|string',
            'wa_mahasiswa' => 'required|string',
            'keperluan' => 'required|string',
            'prodi' => 'required|string',
            'lama_berlaku' => 'required|string',
            'data_dibutuhkan' => 'required|string',
        ]);

        $suratBalasan->update($request->all());

        return redirect()->route('surat-balasan.index')
            ->with('success', 'Surat Balasan berhasil diperbarui.');
    }

    public function destroy(SuratBalasan $suratBalasan)
    {
        $suratBalasan->delete();

        return redirect()->route('surat-balasan.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function generatePdf($id)
    {
        $data = SuratBalasan::with(['mou', 'mahasiswaPenelitian'])->findOrFail($id);

        $pdf = PDF::loadView('surat_balasan.pdf', compact('data'));

        return $pdf->download('surat-balasan-'.$data->id.'.pdf');
    }
}
