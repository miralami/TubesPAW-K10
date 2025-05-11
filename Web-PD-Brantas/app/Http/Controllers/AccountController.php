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

    // Daftar semua akun non-admin, dengan fitur pencarian
    public function index(Request $request)
    {
        $keyword = $request->katakunci;

        $users = User::where('role', '!=', 'admin')
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%")
                      ->orWhere('email', 'like', "%$keyword%");
                });
            })
            ->orderBy('name')
            ->paginate(5)
            ->withQueryString();

        return view('admin.akun.index', compact('users'));
    }

    // Form edit akun (admin)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.akun.edit', compact('user'));
    }

    // Update akun (opsional)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('admin.akun.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Hapus akun
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil dihapus.');
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

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
