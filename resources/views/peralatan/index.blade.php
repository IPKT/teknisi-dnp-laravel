@extends('layouts.app', ['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

<style>
    .custom-triangle-icon {
        text-align: center;
    }

    .legend h4 {
        margin: 0 0 5px;
        font-size: 14px;
    }

    .legend p {
        margin: 2px 0;
        font-size: 13px;
    }
</style>

@section('content')
    <div class="card shadow p-0 mb-4" style="display: none" id="divMap">
        <div id="map" style="height: 350px;" class="" class="border border-dark"></div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($jenis) && $jenis !== 'All' ? $jenis : 'Seluruh Aloptama' }}</h4>
        <div>
            @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                <a href="{{ route('peralatan.create') }}" class="btn btn-success my-1">
                    Tambah
                </a>
            @endif

            <a href="{{ route('peralatan.download', $jenis ?? 'aloptama') }}" class="btn btn-primary my-1">
                Download
            </a>
        </div>

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
                            <th @if (isset($jenis) && $jenis !== 'All') style="display:none" @endif>Jenis</th>
                            {{-- <th>Koordinat</th> --}}
                            <th>Lokasi</th>
                            <th>Pemeliharaan Terbaru</th>
                            <th>2025</th>
                            <th class="rekomendasi-col" style="width: 30%">Rekomendasi</th>
                            <th>Kerusakan</th>
                            <th>PIC</th>
                            @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                                <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peralatans->sortBy([['jenis', 'asc'],['kode', 'asc'],]) as $alat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('peralatan.show', $alat->id) }}" class="">
                                        {{ $alat->kode }}
                                    </a></td>
                                <td>
                                    <span
                                        class="badge bg-{{ $alat->kondisi_terkini == 'ON' ? 'success' : ($alat->kondisi_terkini == 'OFF' ? 'secondary' : 'danger') }}">
                                        {{ $alat->kondisi_terkini }}
                                    </span>
                                </td>
                                <td @if (isset($jenis) && $jenis !== 'All') style="display:none" @endif>{{ $alat->jenis }}</td>
                                {{-- <td>{{ $alat->koordinat }}</td> --}}
                                <td>{{ $alat->lokasi }}</td>
                                <td>{{ optional($alat->pemeliharaans()->orderByDesc('tanggal')->first())->tanggal }}
                                </td>
                                <td>{{ $alat->pemeliharaans()->where('tanggal', '>=', '2025-01-01')->count() }}</td>
                                <td>{!! str_replace("\r\n", '<br>', optional($alat->pemeliharaans()->orderByDesc('tanggal')->first())->rekomendasi) !!}
                                </td>
                                <td>{!! str_replace("\r\n", '<br>', optional($alat->pemeliharaans()->orderByDesc('tanggal')->first())->kerusakan) !!}
                                </td>
                                <td>{{ $alat->nama_pic }} <br>{{ $alat->kontak_pic }}</td>
                                {{-- <td>{{ $alat->kontak_pic }}</td> --}}
                                @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                                    {{-- <td class="text-center">

                                        <a href="{{ route('peralatan.edit', $alat->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>


                                        <form action="{{ route('peralatan.destroy', $alat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data ini site {{ $alat->kode }}?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class=""><a href="{{ route('peralatan.edit', $alat->id) }}"
                                                        class="dropdown-item btn-edit-peralatan small py-1"
                                                        data-id="{{ $alat->id }}">Edit</a></li>
                                                <li>
                                                    <a href="#" class="dropdown-item btn-delete-peralatan small py-1"
                                                        data-id="{{ $alat->id }}"
                                                        data-kode_alat="{{ $alat->kode }}">Hapus</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                @endif

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
    @if ($kelompok == 'aloptama')
        <script>
            document.getElementById("divMap").style.display = 'block';
            // Custom triangle SVG icon
            function createTriangleIcon(color) {
                return L.divIcon({
                    className: 'custom-triangle-icon',
                    html: `<svg width="12" height="12" viewBox="0 0 12 12">
                    <polygon points="6,0 12,12 0,12" fill="${color}" />
                   </svg>`,
                    iconSize: [12, 12],
                    iconAnchor: [6, 12],
                    popupAnchor: [0, -12]
                });
            }

            const greenIcon = createTriangleIcon('green');
            const blackIcon = createTriangleIcon('black');

            const map = L.map('map').setView([-8.4095, 115.1889], 9); // Center Bali

            // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     attribution: '© OpenStreetMap contributors'
            // }).addTo(map);

            // L.tileLayer('https://{s}.satellite-provider.com/{z}/{x}/{y}.png', {
            //     attribution: '© Satellite Provider'
            // }).addTo(map);


            // Base layers
            const baseLayers = {
                "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }),

                "CartoDB Positron (Light)": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://carto.com/">CartoDB</a>'
                }),

                "Esri World Gray": L.tileLayer(
                    'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
                        attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ'
                    })
            };

            // Set default base layer
            baseLayers["CartoDB Positron (Light)"].addTo(map);

            const data = @json($peralatans);
            const layers = {};
            let total = 0,
                onCount = 0,
                offCount = 0;

            data.forEach(item => {
                const iconColor = item.kondisi_terkini === 'ON' ? greenIcon : blackIcon;
                const permanentOrNot = item.kondisi_terkini === 'ON' ? false : true;
                const [lat, lng] = item.koordinat.split(',').map(Number);
                const baseUrl = "{{ route('peralatan.show', ':id') }}";
                const url = baseUrl.replace(':id', item.id);

                const marker = L.marker([lat, lng], {
                    icon: iconColor
                }).bindTooltip(`<strong>${item.kode}</strong>`, {
                    permanent: permanentOrNot
                }).on('click', function() {
                    window.location.href = url;
                });

                if (!layers[item.jenis]) {
                    layers[item.jenis] = L.layerGroup().addTo(map);
                }

                marker.addTo(layers[item.jenis]);

                // Count for legend
                total++;
                if (item.kondisi_terkini === 'ON') onCount++;
                else offCount++;
            });

            // Layer control
            L.control.layers(baseLayers, layers, {
                collapsed: true
            }).addTo(map);

            // Legend control
            const legend = L.control({
                position: 'bottomleft'
            });
            legend.onAdd = function() {
                const div = L.DomUtil.create('div', 'info legend');
                div.style.background = 'white';
                div.style.padding = '10px';
                div.style.border = '1px solid #ccc';
                div.innerHTML = `

            <h4></h4>
                <table class="">
                    <tr class="">
                        <td colspan="3" class="pb-2">{{ isset($jenis) && $jenis !== 'All' ? $jenis : '' }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>&nbsp:</td>
                        <td>${total}</td>
                    </tr>
                    <tr>
                        <td><svg width="15" height="15" viewBox="0 0 15 15">
                    <polygon points="7.5,0 15,15 0,15" fill="green" />
                   </svg>&nbspON</td>
                        <td>&nbsp:</td>
                        <td>${onCount}</td>
                    </tr>
                    <tr>
                        <td><svg width="15" height="15" viewBox="0 0 15 15">
                    <polygon points="7.5,0 15,15 0,15" fill="black" />
                   </svg>&nbspOFF</td>
                        <td>&nbsp:</td>
                        <td>${offCount}</td>
                    </tr>
                </table>
        `;
                return div;
            };
            legend.addTo(map);
        </script>
    @endif

    <script>
        document.querySelectorAll('.btn-delete-peralatan').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const kode = this.dataset.kode_alat;
                if (!confirm(`Yakin ingin menghapus Peralatan ${kode} ?`))
                    return;
                const url = "{{ route('peralatan.destroy', ['peralatan' => '__ID__']) }}"
                    .replace('__ID__', id);

                // fetch(`/hardware/${id}`, {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'X-HTTP-Method-Override': 'DELETE'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // atau hapus baris dari DOM
                        }
                    });
            });
        });
    </script>

    {{-- DATA TABLE --}}
    <script>
        $(document).ready(function() {
            $('#tablePeralatan').DataTable({
                info: false,
                lengthChange: true,
                pageLength: 15
            });
        });
    </script>

    {{-- DATA TABLE --}}
@endsection
