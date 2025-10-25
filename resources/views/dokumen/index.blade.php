@extends('layouts.app', ['title' => 'Data Pemeliharaan'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Pemeliharaan</h4>
        <a href="{{ route('pemeliharaan.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah</a>
    </div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
               <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Peralatan</th>
                        <th>Tanggal</th>
                        <th>Kondisi Awal</th>
                        <th>Jenis Pemeliharaan</th>
                        <th>Pelaksana</th>
                        <th>Gambar</th>
                        <th>Laporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->peralatan->kode ?? '-' }}</td>
                            <td>{{ $p->tanggal ?? '-' }}</td>
                            <td>{{ $p->kondisi_awal }}</td>
                            <td>{{ $p->jenis_pemeliharaan }}</td>
                            <td>{{ $p->pelaksana }}</td>
                            <td>
                                @if($p->gambar)
                                    <img src="{{ asset('storage/'.$p->gambar) }}" width="60" class="rounded shadow">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($p->laporan)
                                    <a href="{{ asset('storage/'.$p->laporan) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i></a>
                                @endif
                                @if($p->laporan2)
                                    <a href="{{ asset('storage/'.$p->laporan2) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i> 2</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pemeliharaan.edit', $p->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('pemeliharaan.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted">Belum ada data pemeliharaan</td></tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection


