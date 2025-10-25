@extends('layouts.app', ['title' => 'Tambah Pemeliharaan'])

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Edit Pemeliharaan</h4>

    <div class="card shadow-sm">
        <div class="card-body">
           <form action="{{ route('pemeliharaan.update', $pemeliharaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-3">
                        <label>Peralatan</label>
                        <select name="id_peralatan" class="form-select" required>
                            <option value="">-- Pilih Peralatan --</option>
                            @foreach ($peralatans as $alat)
                                <option value="{{ $alat->id }}" {{ $alat->id == $pemeliharaan->id_peralatan ? 'selected' : '' }}>
                                    {{ $alat->kode }} - {{ $alat->lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Kondisi Awal<span class="text-danger">*</span></label>
                        {{-- <input type="text" name="kondisi_awal" class="form-control" value="{{ $pemeliharaan->kondisi_awal }}" required> --}}
                         <select name="kondisi_awal" class="form-select">
                            <option {{$pemeliharaan->kondisi_awal == "ON" ? 'selected' : ''}}  value="ON">ON</option>
                            <option {{$pemeliharaan->kondisi_awal == "OFF" ? 'selected' : ''}} value="OFF">OFF</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tanggal<span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $pemeliharaan->tanggal }}">
                    </div>
                    <div class="col-md-3">
                        <label>Jenis Pemeliharaan<span class="text-danger">*</span></label>
                        <select name="jenis_pemeliharaan" class="form-select">
                            {{-- <option value="">-- Pilih Jenis Pemeliharaan--</option> --}}
                            <option {{$pemeliharaan->jenis_pemeliharaan == 'PM' ? 'selected' : ''}} value="PM">Preventive Maintenance</option>
                            <option {{$pemeliharaan->jenis_pemeliharaan == 'CM' ? 'selected' : ''}} value="CM">Corrective Maintenance</option>
                        </select>
                        {{-- <input type="text" name="jenis_pemeliharaan" class="form-control" value="{{ $pemeliharaan->jenis_pemeliharaan }}"> --}}
                    </div>
                    <div class="col-md-6">
                        <label>Pelaksana<span class="text-danger">*</span></label>
                        {{-- <input type="text" name="pelaksana" class="form-control" value="{{ $pemeliharaan->pelaksana }}"> --}}
                        <textarea class="form-control textAreaMultiline my-text-area" name="pelaksana" rows="3" placeholder="1. Nama \n2. Nama" required>{{ $pemeliharaan->pelaksana }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Rekomendasi<span class="text-danger">*</span></label>
                        {{-- <input type="text" name="rekomendasi" class="form-control" value="{{ $pemeliharaan->rekomendasi }}"> --}}
                         <textarea class="form-control textAreaMultiline my-text-area" name="rekomendasi" rows="3" placeholder="1.  \n2. " required>{{ $pemeliharaan->rekomendasi }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Kerusakan</label>
                        <input type="text" name="kerusakan" class="form-control" value="{{ $pemeliharaan->kerusakan }}">
                    </div>
                    <div class="col-md-6">
                        <label>Laporan WA</label>
                        <textarea class="form-control textAreaMultiline" name="text_wa" rows="3" placeholder="copy laporan di WA Grup">{{ $pemeliharaan->text_wa }}</textarea>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Catatan Pemeliharaan</label>
                        <textarea name="catatan_pemeliharaan" rows="3" class="form-control" placeholder="Masukan kegiatan atau kondisi yang dianggap penting">{{ $pemeliharaan->catatan_pemeliharaan }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Gambar (jpg/png)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        @if ($pemeliharaan->gambar)
                            <p class="mt-2">
                                <img src="{{ asset('storage/'.$pemeliharaan->gambar) }}" width="120" class="rounded shadow">
                            </p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label>Laporan (PDF)</label>
                        <input type="file" name="laporan" class="form-control" accept="application/pdf">
                        @if ($pemeliharaan->laporan)
                            <p><a href="{{ asset('storage/'.$pemeliharaan->laporan) }}" target="_blank">📄 Lihat Laporan 1</a></p>
                        @endif

                    </div>
                    <div class="col-md-6">
                        <label>Laporan 2 (PDF)</label>
                        <input type="file" name="laporan2" class="form-control" accept="application/pdf">
                        @if ($pemeliharaan->laporan2)
                            <p><a href="{{ asset('storage/'.$pemeliharaan->laporan2) }}" target="_blank">📄 Lihat Laporan 2</a></p>
                        @endif
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var textAreas = document.getElementsByTagName('textarea');
Array.prototype.forEach.call(textAreas, function(elem) {
    elem.placeholder = elem.placeholder.replace(/\\n/g, '\n');
});
</script>
@endsection
