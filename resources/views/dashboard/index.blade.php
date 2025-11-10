@extends('layouts.app', ['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Peralatan</h4>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <h6>Total Peralatan</h6>
                            <h3>{{ $seluruh_peralatan['jumlah'] }}</h3>
                            <p>ON : {{ $seluruh_peralatan['on'] }} | OFF : {{ $seluruh_peralatan['off'] }}</p>
                        </div>
                    </div>
                </div>
                @foreach ($peralatan as $jenis => $value)
                    <div class="col-md-3">
                        <div class="card text-bg-info">
                            <div class="card-body">
                                <h6>{{ $jenis }}</h6>
                                <h3>{{ $value['jumlah'] }}</h3>
                                <p>ON : {{ $value['on'] }} | OFF : {{ $value['off'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-3">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <h6>Belum Dikunjungi Tahun {{ Carbon\Carbon::now()->year }}</h6>
                            <h3>{{ $belumDikunjungiTahunIni }}</h3>
                            <p style="visibility: hidden;">ON : 0 | OFF : 0</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Pemeliharaan</h4>
            <div class="row g-3">
                <!-- Grafik di kiri -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6>Grafik Kunjungan Bulanan</h6>
                            <canvas id="grafikKunjungan"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card statistik di kanan -->
                <div class="col-md-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card text-bg-primary h-100">
                                <div class="card-body">
                                    <h6>Total Pemeliharaan {{ Carbon\Carbon::now()->year }}</h6>
                                    <h3>{{ $pemeliharaan['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-bg-info h-100">
                                <div class="card-body">
                                    <h6>Site dikunjungi</h6>
                                    <h3>{{ $pemeliharaan['site_dikunjungi'] }} atau {{ $pemeliharaan['persen'] }}%</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-bg-info h-100">
                                <div class="card-body">
                                    <h6>Pemeliharaan Bulan {{ Carbon\Carbon::now()->isoFormat('MMMM') }}</h6>
                                    <h3>{{ $pemeliharaan['bulan_ini'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-bg-info h-100">
                                <div class="card-body">
                                    <h6>Pemeliharaan Bulan {{ Carbon\Carbon::now()->subMonth()->isoFormat('MMMM') }}</h6>
                                    <h3>{{ $pemeliharaan['bulan_lalu'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikKunjungan');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($grafikBulan->pluck('label')) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode($grafikBulan->pluck('total')) !!},
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
