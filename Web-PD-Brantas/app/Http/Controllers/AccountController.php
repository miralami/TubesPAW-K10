<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /* ========== ADMIN SECTION ========== */

    // Daftar semua akun non-admin
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(15);
        return view('admin.accounts.index', compact('users'));
    }

    // Hapus akun
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();
        return redirect()->route('admin.accounts.index')
                         ->with('success', 'Akun berhasil dihapus.');
    }

    /* ========== CUSTOMER SECTION ========== */

    // Form edit profil
    public function editProfile()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // Simpan perubahan profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'  => 'nullable|confirmed|min:6',
        ]);

        // basic field
        $user->name  = $request->name;
        $user->email = $request->email;

        // ganti password bila diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // handle foto baru
        if ($request->hasFile('photo')) {
            // hapus foto lama
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
