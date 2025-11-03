<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'nama_lengkap', 'username', 'nip', 'role')->get();
        return view('auth.manage_user', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:teknisi,operasional,pimpinan', // sesuaikan dengan role yang kamu pakai
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role updated successfully']);
    }
}