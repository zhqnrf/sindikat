<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Ambil semua catatan (format JSON)
    public function index()
    {
        $notes = Note::orderBy('updated_at', 'desc')->get();
        return response()->json($notes);
    }

    // Simpan atau Update
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255', // Judul wajib diisi
            'content' => 'nullable|string',
        ]);

        $note = Note::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Catatan berhasil disimpan',
            'data' => $note
        ]);
    }

    // Hapus Catatan
    public function destroy($id)
    {
        $note = Note::find($id);
        if ($note) {
            $note->delete();
            return response()->json(['status' => 'success', 'message' => 'Dihapus']);
        }
        return response()->json(['status' => 'error', 'message' => 'Tidak ditemukan'], 404);
    }
}