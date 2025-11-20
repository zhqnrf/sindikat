<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mou; // Asumsi nama model Universitas adalah Mou
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil user yang butuh approval (User biasa & belum approve)
        $pendingUsers = User::where('role', 'user')
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil semua user (kecuali yang sedang login sekarang)
        $allUsers = User::where('id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.index', compact('pendingUsers', 'allUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Akun ' . $user->name . ' berhasil disetujui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    // Jika ingin edit user (opsional)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Logika update disini jika diperlukan (ganti password/role)
        $user->update(['is_approved' => $request->has('is_approved')]);
        return back()->with('success', 'Status user diperbarui');
    }
}
