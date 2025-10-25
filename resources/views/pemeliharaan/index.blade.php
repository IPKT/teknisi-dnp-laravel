@extends('layouts.app', ['title' => 'Data Pemeliharaan'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Pemeliharaan</h4>
        <a href="{{ route('pemeliharaan.create') }}" class="btn btn-success"> Tambah</a>
    </div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

    <div class="card shadow-sm">
        <div class="card-body">
             <div class="table-responsive">
                  <table class="table table-hover align-middle" id="tablePemeliharaan">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Peralatan</th>
                            <th>Tanggal</th>
                            <th>Pelaksana</th>
                            <th>Rekomendasi</th>
                            <th>Catatan</th>
                            {{-- <th>Gambar</th> --}}
                            <th>Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeliharaans as $p)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="{{ route('pemeliharaan.show', $p->id) }}" class="">
                                    {{ $p->peralatan->kode }}
                                    </a>
                                </td>
                                <td>{{ $p->tanggal ?? '-' }}</td>
                                
                                <td>
                                <?php 
                                $pelaksana =str_replace("\r\n","<br>",$p->pelaksana);
                                echo $pelaksana;
                                ?>
                                </td>
                                <td>
                                <?php 
                                $rekomendasi =str_replace("\r\n","<br>",$p->rekomendasi);
                                echo $rekomendasi;
                                ?>
                                </td>
                                <td>{{$p->catatan_pemeliharaan}}</td>
                                {{-- <td>
                                    @if($p->gambar)
                                        <img src="{{ asset('storage/'.$p->gambar) }}" width="60" class="rounded shadow">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td> --}}
                                <td>
                                    @if($p->laporan)
                                        <a href="{{ asset('storage/'.$p->laporan) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2 mb-md-0"><i class="bi bi-file-earmark-pdf"></i></a>
                                    @endif
                                    @if($p->laporan2)
                                        <a href="{{ asset('storage/'.$p->laporan2) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i> 2</a>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array(auth()->user()->role, ['admin', 'teknisi']) || $p->author == auth()->user()->id)
                                    <a href="{{ route('pemeliharaan.edit', $p->id) }}" class="btn btn-sm btn-warning mb-2 mb-md-0"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('pemeliharaan.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pemeliharaan {{$p->peralatan->kode}}?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
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
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#tablePemeliharaan').DataTable({
        info: false,
        lengthChange: false,
        pageLength: 15
    });
});
</script>
@endsection


