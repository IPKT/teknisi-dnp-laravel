@extends('layouts.app',['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

@section('content')
<div id="map" style="height: 350px;" class="mb-4"></div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Peralatan {{ isset($jenis) && $jenis !== 'All' ? $jenis : '' }}</h4>
    <a href="{{ route('peralatan.create') }}" class="btn btn-success">
        Tambah
    </a>
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
            <table class="table table-hover align-middle" id="tablePeralatan">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Kondisi</th>
                    <th>Jenis</th>
                    <th>Koordinat</th>
                    <th>Lokasi</th>
                    <th>Nama PIC</th>
                    <th>Kontak</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peralatans as $alat)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="{{ route('peralatan.show', $alat->id) }}" class="">
                           {{ $alat->kode }}
                        </a></td>
                    <td>
                        <span class="badge bg-{{ $alat->kondisi_terkini == 'ON' ? 'success' : ($alat->kondisi_terkini == 'OFF' ? 'secondary' : 'danger') }}">
                            {{ $alat->kondisi_terkini }}
                        </span>
                    </td>
                    <td>{{ $alat->jenis }}</td>
                    <td>{{ $alat->koordinat }}</td>
                    <td>{{ $alat->lokasi }}</td>
                    <td>{{ $alat->nama_pic }}</td>
                    <td>{{ $alat->kontak_pic }}</td>
                    <td class="text-center">
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'teknisi')
                        <a href="{{ route('peralatan.edit', $alat->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @endif
                        @if(auth()->user()->role == 'admin')
                        
                            <form action="{{ route('peralatan.destroy', $alat->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini site {{$alat->kode}}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
        var greenIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [20, 30],
        iconAnchor: [10, 30],
        popupAnchor: [1, -34],
        shadowSize: [30, 30]
    });
    var blackIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
    const map = L.map('map').setView([-8.4095, 115.1889], 9); // Center Bali

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const data = @json($peralatans);

    const layers = {}; // LayerGroup per jenis

    data.forEach(item => {
        const iconColor = item.kondisi_terkini == 'ON' ? greenIcon : blackIcon;
        const permanentOrNot = item.kondisi_terkini == 'ON' ? false : true 
        const [lat, lng] = item.koordinat.split(',').map(Number);
        const baseUrl = "{{ route('peralatan.show', ':id') }}"; // placeholder :id
        const url = baseUrl.replace(':id', item.id);    

        const marker = L.marker([lat,lng], {
            // radius: 8,
            icon: iconColor
        }).bindTooltip(`<strong>${item.kode} </strong>`,{permanent:permanentOrNot}).on('click', function () {
            window.location.href = url;
        });

        if (!layers[item.jenis]) {
            layers[item.jenis] = L.layerGroup().addTo(map);
        }

        marker.addTo(layers[item.jenis]);
    });

    // Layer control
    L.control.layers(null, layers, { collapsed: true }).addTo(map);
</script>

{{-- DATA TABLE --}}
<script>
$(document).ready(function() {
    $('#tablePeralatan').DataTable({
        info: false,
        lengthChange: false,
        pageLength: 15
    });
});
</script>

{{-- DATA TABLE --}}
@endsection
