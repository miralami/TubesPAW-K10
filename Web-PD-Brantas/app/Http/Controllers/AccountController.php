<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // Admin melihat semua akun
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.accounts.index', compact('users'));
    }

    // Admin menghapus akun
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jika user punya foto, hapus dari storage
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();
        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dihapus.');
    }

    // Pelanggan edit profil
    public function editProfile()
    {
        $user = Auth::user();
        return view('pelanggan.profile.edit', compact('user'));
    }

    // Pelanggan update profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save(); // Pastikan $user adalah instance model User

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
