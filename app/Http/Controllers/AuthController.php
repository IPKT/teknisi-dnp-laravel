<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'username';
    }

   public function login(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        if (Auth::attempt($credentials)) {
            \Log::info('login berhasil:', ['user' => Auth::user()]);
            $request->session()->regenerate(); // penting!
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            $this->username() => 'Username atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function createUserForm()
    {
        $this->authorize('isAdmin'); // hanya admin
        return view('auth.register');
    }

    public function storeUser(Request $request)
    {
        $this->authorize('isAdmin');

        $request->validate([
            // 'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'nama_lengkap' => 'required',
            'nip' => 'required',
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('tanda_tangan')) {
            $data['tanda_tangan'] = $request->file('tanda_tangan')->store('uploads/tandatangan', 'public');
        }

        User::create($data);
        return redirect()->route('dashboard')->with('success', 'User baru berhasil dibuat.');
    }
}