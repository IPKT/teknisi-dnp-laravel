<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginActivity;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'nama_lengkap', 'username', 'nip', 'role')->orderBy('role', 'asc')->get();
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

    public function userActivityRecap()
    {
        // $this->authorize('isAdmin');

        $users = User::query()
            // 1. Ambil waktu login terakhir (akan jadi field: last_login_at)
            ->withMax('loginActivities as last_login_at', 'created_at')
            
            // 2. Hitung jumlah login BULAN INI (akan jadi field: logins_this_month_count)
            ->withCount(['loginActivities as logins_this_month' => function ($query) {
                $query->where('created_at', '>=', now()->startOfMonth());
            }])
            
            // 3. (Opsional) Hitung TOTAL login seumur hidup (akan jadi field: total_logins_count)
            ->withCount('loginActivities as total_logins')
            
            // Urutkan user yang paling baru login di paling atas
            ->orderByDesc('last_login_at')
            ->paginate(15);

        return view('admin.user-activity-recap', compact('users'));
    }
}