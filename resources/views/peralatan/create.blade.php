@extends('layouts.app')

@section('title', 'Tambah Peralatan')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Peralatan</h4>
        <form action="{{ route('peralatan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode<span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" required maxlength="6">
                </div>
        
               <div class="col-md-4">
                    <label class="form-label">Jenis<span class="text-danger">*</span></label>
                    <select name="jenis" class="form-select">
                        <option>Intensitymeter Realshake</option>
                        <option>Seismometer</option>
                        <option>Accelero Non Colocated</option>
                        <option>Intensitymeter Reis</option>
                        <option>WRS</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Koordinat<span class="text-danger">*</span></label>
                    <input type="text" name="koordinat" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kondisi<span class="text-danger">*</span></label>
                    <select name="kondisi_terkini" class="form-select">
                        <option>ON</option>
                        <option>OFF</option>
                        <option>RUSAK</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Lokasi<span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Detail Lokasi</label>
                    <input type="text" name="detail_lokasi" class="form-control">
                </div>
                {{-- <div class="col-md-4">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="tipe" class="form-control">
                </div> --}}
                <div class="col-md-4">
                    <label class="form-label">Nama PIC</label>
                    <input type="text" name="nama_pic" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jabatan PIC</label>
                    <input type="text" name="jabatan_pic" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kontak PIC</label>
                    <input type="text" name="kontak_pic" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('peralatan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
