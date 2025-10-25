@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container mt-4">
    <h3><i class="bi bi-person-plus me-2"></i>Tambah User Baru</h3>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="teknisi">Teknisi</option>
                <option value="operasional">Operasional</option>
                <option value="pimpinan">Pimpinan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>
</div>
@endsection
