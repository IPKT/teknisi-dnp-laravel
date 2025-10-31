@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-4">
    <h3><i class="bi bi-person-circle me-2"></i>Profil Saya</h3>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
        </div>
           <div class="mb-3">
            <label>Role</label>
            <input type="text" name="role" class="form-control" value="{{ old('role', $user->role) }}" disabled>
        </div>

        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
        </div>

        <div class="mb-3">
            <label>Tanda Tangan (PNG/JPG)</label>
            <input type="file" name="tanda_tangan" class="form-control">
            @if ($user->tanda_tangan)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->tanda_tangan) }}" alt="Tanda Tangan" height="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Perubahan
        </button>
    </form>
</div>
@endsection
