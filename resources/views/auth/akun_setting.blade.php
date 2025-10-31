@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="container mt-4">
        <h3>Ganti Password</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update_password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
            </div>

            <div class="mb-3">
                <label>Password Lama</label>
                <input type="password" name="password_lama" class="form-control">
                @error('password_lama')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password_baru" class="form-control">
                @error('password_baru')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Confirm Password Baru</label>
                <input type="password" name="confirm_passwordbaru" class="form-control">
                @error('confirm_passwordbaru')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
        </form>

    </div>
@endsection
