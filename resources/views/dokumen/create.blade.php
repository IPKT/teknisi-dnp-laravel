@extends('layouts.app', ['title' => 'Tambah Hardware'])

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Tambah Hardware</h4>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
           <form action="{{ route('hardware.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Peralatan</label>
                        <select name="id_peralatan" class="form-select" required>
                            <option value="">-- Pilih Peralatan --</option>
                            @foreach ($peralatans as $alat)
                                <option value="{{ $alat->id }}">{{ $alat->kode }} - {{ $alat->lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="col-md-4">
                        <label>Jenis Hardware</label>
                        <select name="jenis_hardware" class="form-select" required>
                            <option value="">-- Pilih Jenis Hardware --</option>
                            @foreach ($jenis_hardware as $jenis)
                                <option value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Merk</label>
                        <input type="text" name="merk" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Tipe</label>
                        <input type="text" name="tipe" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal Pemasangan</label>
                        <input type="date" name="tanggal_pemasangan" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="terpasang">Terpasang</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>  
                    <div class="col-md-4">
                        <label>Tanggal Pelapasan</label>
                        <input type="date" name="tanggal Pelepasan" class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('peralatan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
