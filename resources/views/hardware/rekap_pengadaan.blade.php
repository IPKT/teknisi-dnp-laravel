@extends('layouts.app', ['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{$judul}} @if($tahun != 'All')
                Tahun {{ $tahun }}
            @endif
        </h4>
        @if ($sumber_pengadaan == 'Pengadaan DNP')
            <a href="{{ route('hardware.detail_pengadaan_dnp', $tahun) }}" class="btn btn-success">Lihat Detail Pengadaan
            </a>
        @else
            <a href="{{ route('hardware.detail_pengadaan', $tahun) }}" class="btn btn-success">Lihat Detail Pengadaan
            </a>
        @endif
            
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @foreach ($rekap_peralatan as $jenis => $rekap)
                <h4 class="mt-4">{{ $jenis }}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="hardware-table-{{ \Str::slug($jenis) }}">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Jenis Hardware</th>
                                <th>Ready</th>
                                <th>Terpasang</th>
                                <th>Terkirim</th>
                                <th>Dilepas</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekap as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->jenis_hardware }}</td>
                                    <td>{{ $item->ready }}</td>
                                    <td>{{ $item->terpasang }}</td>
                                    <td>{{ $item->terkirim }}</td>
                                    <td>{{ $item->dilepas }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('table[id^="hardware-table-"]').each(function() {
                $(this).DataTable({
                    info: false,
                    lengthChange: false,
                    pageLength: 15
                });
            });
        });
    </script>
@endsection
