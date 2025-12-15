@extends('layouts.app')
@section('title', 'User Activity Recap')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Rekap Aktivitas User</h2>
            <p class="text-muted mb-0">
                Memantau keaktifan user bulan ini ({{ now()->format('F Y') }})
            </p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 ps-4">User Info</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3">Login Terakhir</th>
                            <th class="py-3 text-center">Login Bulan Ini</th>
                            <th class="py-3 text-center">Total Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            {{-- Nama & Role --}}
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $user->nama_lengkap }}</div>
                                <div class="small text-muted">
                                    {{ $user->username }} &bull; <span class="text-uppercase">{{ $user->role }}</span>
                                </div>
                            </td>

                            {{-- Status Keaktifan --}}
                            <td class="text-center">
                                @if($user->logins_this_month > 10)
                                    <span class="badge rounded-pill bg-success">Sangat Aktif</span>
                                @elseif($user->logins_this_month > 0)
                                    <span class="badge rounded-pill bg-primary">Aktif</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">Pasif</span>
                                @endif
                            </td>

                            {{-- Login Terakhir --}}
                            <td>
                                @if($user->last_login_at)
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->format('d M Y, H:i') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                                    </small>
                                @else
                                    <span class="text-muted fst-italic small">Belum pernah login</span>
                                @endif
                            </td>

                            {{-- Statistik Angka --}}
                            <td class="text-center">
                                <span class="fs-5 fw-bold {{ $user->logins_this_month > 0 ? 'text-primary' : 'text-muted' }}">
                                    {{ $user->logins_this_month }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="font-monospace text-dark">{{ $user->total_logins }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i> {{-- Kalau pakai Bootstrap Icons --}}
                                Belum ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white py-3">
            {{-- 
               PENTING: Laravel 12 defaultnya Tailwind. 
               Pakai parameter ini biar paginationnya jadi style Bootstrap 5 
            --}}
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection