@extends('layouts.app')

@section('title', 'Edit Peralatan')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Peralatan</h4>
            <form action="{{ route('peralatan.update', $peralatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kode<span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="form-control" value="{{ $peralatan->kode }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis<span class="text-danger">*</span></label>
                        <select name="jenis" class="form-select">
                            @foreach ($jenisPeralatan as $jp)
                                <option {{ $peralatan->jenis == $jp->jenis ? 'selected' : '' }}>{{ $jp->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Koordinat<span class="text-danger">*</span></label>
                        <input type="text" name="koordinat" class="form-control" value="{{ $peralatan->koordinat }}"
                            required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Kondisi<span class="text-danger">*</span></label>
                        <select name="kondisi_terkini" class="form-select">
                            <option selected {{ $peralatan->kondisi_terkini == 'ON' ? 'selected' : '' }}>ON</option>
                            <option {{ $peralatan->kondisi_terkini == 'OFF' ? 'selected' : '' }}>OFF</option>
                            <option {{ $peralatan->kondisi_terkini == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Lokasi<span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $peralatan->lokasi }}" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Detail Lokasi</label>
                        <input type="text" name="detail_lokasi" class="form-control"
                            value="{{ $peralatan->detail_lokasi }}">
                    </div>
                    {{-- <div class="col-md-4">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="tipe" class="form-control" value="{{ $peralatan->tipe }}">
                </div> --}}
                    <div class="col-md-4">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="nama_pic" class="form-control" value="{{ $peralatan->nama_pic }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jabatan PIC</label>
                        <input type="text" name="jabatan_pic" class="form-control"
                            value="{{ $peralatan->jabatan_pic }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kontak PIC</label>
                        <input type="text" name="kontak_pic" class="form-control" value="{{ $peralatan->kontak_pic }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" class="form-control">{{ $peralatan->catatan }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Update</button>
                    <a href="{{ route('peralatan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
