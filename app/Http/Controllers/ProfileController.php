<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->nip = $request->nip;

        if ($request->hasFile('tanda_tangan')) {
            $file = $request->file('tanda_tangan');
            $filename = 'ttd_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/tanda_tangan', $filename, 'public'); // ✅ pakai disk public

            $user->tanda_tangan = $path; // simpan path relatif
        }



        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function akunSetting()
    {
        $user = Auth::user();
        // dd($user);
        return view('auth.akun_setting', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'confirm_passwordbaru' => 'required|same:password_baru',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
