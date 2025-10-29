@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card shadow p-4" style="width: 360px;">
            <img src="{{ asset('assets') }}/images/Logo-BMKG-square.png" class="img-fluid mx-auto" alt="logo"
                width="40px">
            <h4 class="text-center my-4">TEKNISI DNP</h4>
            <form action="{{ url('/login') }}" method="POST">
                @error('username')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
                @csrf
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
@endsection
