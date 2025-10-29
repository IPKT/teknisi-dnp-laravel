@extends('layouts.app')

@section('title', 'Detail Peralatan')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        {{-- DETAIL PERALATAN --}}
        <h4 class="mb-4">Detail Peralatan {{ $peralatan->jenis }} {{ $peralatan->kode }}</h4>
        <div class="row g-2">
            <div class="col-md-6">
                {{-- 🗺️ Peta Lokasi --}}
                <div id="map" style="height: 350px;"></div>
            </div>
            <div class="col-md-6">
                {{-- 📌 Detail Peralatan --}}
                {{-- <ul class="list-group">
                    <li class="list-group-item"><strong>Jenis:</strong> {{ $peralatan->jenis }}</li>
                    <li class="list-group-item"><strong>Lokasi:</strong> {{ $peralatan->lokasi }}</li>
                    <li class="list-group-item"><strong>Koordinat:</strong> {{ $peralatan->koordinat }}</li>
                    <li class="list-group-item"><strong>Jumlah Pemeliharaan:</strong> {{ $jumlahPemeliharaan }}</li>
                    @if($terbaru)
                        <li class="list-group-item"><strong>Terbaru:</strong> {{ $terbaru->tanggal }} - {{ $terbaru->catatan }}</li>
                    @endif
                </ul> --}}

                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Kode</td>
                            <td>:</td>
                            <td>{{ $peralatan->kode }}</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>{{ $peralatan->lokasi }}</td>
                        </tr>
                        <tr>
                            <td>Detail Lokasi</td>
                            <td>:</td>
                            <td>{{ $peralatan->detail_lokasi }}</td>
                        </tr>
                        <tr>
                            <td>Koordinat</td>
                            <td>:</td>
                            <td>{{ $peralatan->koordinat }}</td>
                        </tr>
                        <tr>
                            <td>Nama PIC</td>
                            <td>:</td>
                            <td>{{ $peralatan->nama_pic }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan PIC</td>
                            <td>:</td>
                            <td>{{ $peralatan->jabatan_pic }}</td>
                        </tr>
                        <tr>
                            <td>Kontak PIC</td>
                            <td>:</td>
                            <td>{{ $peralatan->kontak_pic }}</td>
                        </tr>
                        <tr>
                            <td>Catatan Teknisi</td>
                            <td>:</td>
                            <td>{{ $peralatan->catatan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-4">
        {{-- HISTORY PEMELIHARAAN --}}

        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Data Pemeliharaan</h5>
                    <a href="{{ route('pemeliharaan.create') }}" class="btn btn-sm btn-success">Tambah</a>
                </div>
              <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle" id="tablePemeliharaan">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Peralatan</th>
                            <th>Tanggal</th>
                            <th>Pelaksana</th>
                            <th>Rekomendasi</th>
                            <th>Catatan</th>
                            <th>Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeliharaan as $p)
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
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- <tr><td colspan="8" class="text-center text-muted">Belum ada data pemeliharaan</td></tr> --}}
                             <tr>
                                <td>1</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
              </div>

            </div>
        </div>

       {{-- HARDWARE --}}
        <div class="row my-3">
            <div class="col-md-12">
                 <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Hardware</h5>
                    <a href="{{route('hardware.peralatan', [$peralatan->id, $peralatan->kode])}}" class="btn btn-sm btn-success">Lihat Histori Hardware
                    </a>
                </div>
               <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="tableHardware">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Hardware</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Serial Number</th>
                                <th>Tanggal Pemasangan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bodyHardwareTable">
                            @forelse($hardware as $h)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><a class="text-primary text-decoration-none" style="cursor:pointer;"
                                        onclick="showHardwareDetail({{ $h->id }})">
                                        {{ $h->jenis_hardware }}
                                    </a></td>
                                    <td>{{ $h->merk }}</td>
                                    <td>{{ $h->tipe }}</td>
                                    <td>{{ $h->serial_number }}</td>
                                    <td>{{ $h->tanggal_keluar }}</td>
                                    <td>{{ $h->status }}</td>
                                </tr>
                            @empty
                                {{-- <tr><td colspan="8" class="text-center text-muted">Belum ada data pemeliharaan</td></tr> --}}
                                <tr>
                                    <td>1</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
               </div>
            </div>
        </div>

         {{-- DOKUMEN --}}
        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Dokumen Penting</h5>
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahDokumen">Tambah
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped align-middle" id="tableDokumen">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tangggal</th>
                                <th>Nama Dokumen</th>
                                <th>Keterangan</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyDokumenTable">
                            @forelse($dokumen as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d->tanggal_dokumen}}</td>
                                    <td>{{ $d->nama_dokumen }}</td>
                                    <td>{{ $d->keterangan_dokumen }}</td>
                                    <td><a href="/storage/{{$d->file_dokumen}}" target="_blank">Lihat Dokumen</a></td>
                                    <td>
                                        @if(in_array(auth()->user()->role, ['admin', 'teknisi']) || $d->author == auth()->user()->id)
                                        <button class="btn btn-sm btn-warning btn-edit-dokumen mb-2 mb-md-0" data-id="{{$d->id}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete-dokumen" data-id="{{$d->id}}" data-nama_dokumen="{{$d->nama_dokumen}}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr><td colspan="6" class="text-center text-muted">Belum ada dokumen penting</td></tr> --}}
                                 <tr>
                                    <td>1</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- MODAL Tambah Hardware --}}
<div class="modal fade" id="modalTambahHardware" tabindex="-1" aria-labelledby="modalTambahHardwareLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formTambahHardware">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Hardware</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <input type="hidden" name="id_peralatan" value="{{ $peralatan->id }}">
            <div class="col-md-6">
              {{-- <label>Jenis Hardware</label>
              <input type="text" name="jenis_hardware" class="form-control" required> --}}
                <label>Jenis Hardware</label>
                <select name="jenis_hardware" class="form-select" required>
                    <option value="">-- Pilih Jenis Hardware --</option>
                    @foreach ($jenis_hardware as $jenis)
                        <option value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
              <label>Merk</label>
              <input type="text" name="merk" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Tipe</label>
              <input type="text" name="tipe" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Serial Number</label>
              <input type="text" name="serial_number" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Tanggal Pemasangan</label>
              <input type="date" name="tanggal_pemasangan" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Status</label>
              <select name="status" class="form-select" id="selectStatusHardware">
                <option selected value="terpasang">Terpasang</option>
                <option  value="dilepas">Dilepas</option>
              </select>
            </div>
            <div class="col-md-6" id="inputTanggalPelepasan"  style="display: none;">
              <label>Tanggal Pelepasan</label>
              <input type="date" name="tanggal_pelepasan" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- END MODAL Tambah Hardware --}}

{{-- MODAL Edit Hardware --}}
<div class="modal fade" id="modalEditHardware" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditHardware">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Hardware</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-hardware-id">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Jenis Hardware</label>
              <input type="text" name="jenis_hardware" id="edit-hardware-jenis" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Merk</label>
              <input type="text" name="merk" id="edit-hardware-merk" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Tipe</label>
              <input type="text" name="tipe" id="edit-hardware-tipe" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Serial Number</label>
              <input type="text" name="serial_number" id="edit-hardware-serial" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Tanggal Pemasangan</label>
              <input type="date" name="tanggal_pemasangan" id="edit-hardware-tanggal" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Status</label>
              <select name="status" id="edit-hardware-status" class="form-select">
                <option value="terpasang">Terpasang</option>
                <option value="dilepas">Dilepas</option>
              </select>
            </div>
            <div class="col-md-6" id="inputTanggalPelepasanEdit" style="display:none;">
              <label>Tanggal Pelepasan</label>
              <input type="date" name="tanggal_pelepasan" class="form-control" id="edit-hardware-tanggal-pelepasan">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- END MODAL Edit Hardware --}}

{{-- MODAL Tambah Dokumen --}}
<div class="modal fade" id="modalTambahDokumen" tabindex="-1" aria-labelledby="modalTambahDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formTambahDokumen" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Dokumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <input type="hidden" name="id_peralatan" value="{{ $peralatan->id }}">
            <div class="col-md-12">
              <label>Nama Dokumen</label>
              <input type="text" name="nama_dokumen" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Tanggal Dokumen</label>
              <input type="date" name="tanggal_dokumen" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Keterangan</label>
              <input type="text" name="keterangan_dokumen" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label>File</label>
                <input type="file" name="file_dokumen" class="form-control" accept="application/pdf">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- END MODAL Tambah Dokumen --}}

{{-- MODAL EDIT Dokumen --}}
<div class="modal fade" id="modalEditDokumen" tabindex="-1" aria-labelledby="modalTambahDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditDokumen" enctype="multipart/form-data">
    @csrf
    @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Dokumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
           <input type="hidden" name="id" id="edit-dokumen-id">
            <div class="col-md-12">
              <label>Nama Dokumen</label>
              <input type="text" name="nama_dokumen" id="edit-dokumen-nama_dokumen" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Tanggal Dokumen</label>
              <input type="date" name="tanggal_dokumen" id="edit-dokumen-tanggal_dokumen" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Keterangan</label>
              <input type="text" name="keterangan_dokumen" id='edit-dokumen-keterangan_dokumen' class="form-control" required>
            </div>
            <div class="col-md-12">
                <label>File Dokumen</label>
                <input type="file" name="file_dokumen" id="edit-dokumen-file_dokumen" class="form-control">
                <small class="text-muted">File sebelumnya: <span id="edit-dokumen-file-preview"></span></small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- END MODAN EDIT Dokumen --}}

@include('hardware.modal_show')
@endsection

@section('scripts')
{{-- 🗺️ Leaflet Map --}}
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> --}}
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
    const koordinat = "{{ $peralatan->koordinat }}"; // format: "lat,lng"
    const [lat, lng] = koordinat.split(',').map(Number);

    const map = L.map('map').setView([lat, lng], 9);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    const iconType = "{{ $peralatan->status_terkini }}" == "ON" ? greenIcon : blackIcon;
    L.marker([lat, lng],{icon: iconType}).addTo(map)
        .bindPopup("{{ $peralatan->kode }}<br>{{ $peralatan->lokasi }}")
        .openPopup();
</script>
{{-- DATA TABLE --}}
<script>
  $(document).ready(function() {
    $('#tableHardware').DataTable({
        info: false,
        lengthChange: false,
        pageLength: 15
    });
});

  $(document).ready(function() {
    $('#tablePemeliharaan').DataTable({
        info: false,
        lengthChange: false,
        pageLength: 15
    });
});

  $(document).ready(function() {
    $('#tableDokumen').DataTable({
        info: false,
        lengthChange: false,
        pageLength: 15
    });
});

</script>

{{-- Tambah Hardware --}}
<script>
document.getElementById('selectStatusHardware').addEventListener('change', function(e) {
const pelepasanInput = document.getElementById('inputTanggalPelepasan');

if (e.target.value === 'dilepas') {
    pelepasanInput.style.display = 'block';
    pelepasanInput.required = true;
} else {
    pelepasanInput.style.display = 'none';
    pelepasanInput.required = false;
    pelepasanInput.value = ''; // optional: reset value
}
});

document.getElementById('formTambahHardware').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("{{ route('hardware.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
            // Tambahkan baris baru ke tabel
            // const tbody = document.getElementById('bodyHardwareTable');
            // const row = document.createElement('tr');
            // row.innerHTML = `
            //     <td>${tbody.children.length + 1}</td>
            //     <td>${data.hardware.jenis_hardware}</td>
            //     <td>${data.hardware.merk}</td>
            //     <td>${data.hardware.tipe}</td>
            //     <td>${data.hardware.serial_number}</td>
            //     <td>${data.hardware.tanggal_pemasangan}</td>
            //     <td>${data.hardware.status}</td>
            //     <td><button class="btn btn-sm btn-primary btn-edit-hardware" data-id="${data.hardware.id}">
            //             <i class="bi bi-pencil"></i>
            //         </button>
            //         <button class="btn btn-sm btn-danger btn-delete-hardware" data-id="${data.hardware.id}" data-jenis="${data.hardware.jenis_hardware}">
            //             <i class="bi bi-trash"></i>
            //         </button>
            //     </td>
            // `;
            // tbody.appendChild(row);

            // Reset form dan tutup modal
            form.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahHardware'));
            modal.hide();
            tambahEventListenerBtnEdit();
            tambahEventListenerBtnDelete();
        } else {
            alert('Gagal menyimpan data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
});
</script>
{{-- EDIT HARDWARE --}}
<script>

document.getElementById('edit-hardware-status').addEventListener('change', function(e) {
const pelepasanInputEdit = document.getElementById('inputTanggalPelepasanEdit');

if (e.target.value === 'dilepas') {
    pelepasanInputEdit.style.display = 'block';
    pelepasanInputEdit.required = true;
} else {
    pelepasanInputEdit.style.display = 'none';
    pelepasanInputEdit.required = false;
    pelepasanInputEdit.value = ''; // optional: reset value
}
});

function tambahEventListenerBtnEdit(){
document.querySelectorAll('.btn-edit-hardware').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        fetch(`/hardware/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit-hardware-id').value = data.id;
                document.getElementById('edit-hardware-jenis').value = data.jenis_hardware;
                document.getElementById('edit-hardware-merk').value = data.merk;
                document.getElementById('edit-hardware-tipe').value = data.tipe;
                document.getElementById('edit-hardware-serial').value = data.serial_number;
                document.getElementById('edit-hardware-tanggal').value = data.tanggal_pemasangan;
                document.getElementById('edit-hardware-tanggal-pelepasan').value = data.tanggal_pelepasan;
                document.getElementById('edit-hardware-status').value = data.status;
                // document.getElementById('edit-hardware-status').value = data.status;

                const modal = new bootstrap.Modal(document.getElementById('modalEditHardware'));
                if (document.getElementById('edit-hardware-status').value === 'dilepas') {
                    document.getElementById('inputTanggalPelepasanEdit').style.display = 'block';
                } else {
                    document.getElementById('inputTanggalPelepasanEdit').style.display = 'none';
                }
                modal.show();

            });
    });
});
}
tambahEventListenerBtnEdit();

document.getElementById('formEditHardware').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('edit-hardware-id').value;
    const formData = new FormData(this);

    fetch(`/hardware/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // atau update baris tabel secara dinamis
        }
    });
});

</script>
{{-- END EDIT HARDWARE --}}

{{-- DELETE HARDWARE --}}
<script>
function tambahEventListenerBtnDelete(){
    document.querySelectorAll('.btn-delete-hardware').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const jenis_hardware = this.dataset.jenis;
            if (!confirm(`Yakin ingin menghapus hardware ${jenis_hardware} {{$peralatan->kode}} ?`)) return;
            fetch(`/hardware/${id}`, {
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
}

tambahEventListenerBtnDelete();
</script>
{{-- END DELETE HARDWARE --}}

{{-- TAMBAH DOKUMEN --}}
<script>
    document.getElementById('formTambahDokumen').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('dokumen.store') }}", {
            method: "POST",
            headers: {
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tambahkan baris baru ke tabel
                // const tbody = document.getElementById('bodyDokumenTable');
                // const row = document.createElement('tr');
                // row.innerHTML = `
                //     <td>${tbody.children.length + 1}</td>
                //     <td>${data.dokumen.nama_dokumen}</td>
                //     <td>${data.dokumen.keterangan_dokumen}</td>
                //     <td><a href="/storage/${data.dokumen.file_dokumen}" target="_blank">Lihat Dokumen</a></td>
                //     <td><button class="btn btn-sm btn-warning btn-edit-dokumen" data-id="${data.dokumen.id}">
                //             <i class="bi bi-pencil-square"></i>
                //         </button>
                //         <button class="btn btn-sm btn-danger btn-delete-dokumen" data-id="${data.dokumen.id}" data-nama_dokumen="${data.nama_dokumen}">
                //             <i class="bi bi-trash"></i>
                //         </button>
                //     </td>
                // `;
                // tbody.appendChild(row);

                 location.reload();

                // Reset form dan tutup modal
                form.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahDokumen'));
                modal.hide();
                tambahEventListenerBtnEditDokumen();
                tambahEventListenerBtnDeleteDokumen();
            } else {
                alert('Gagal menyimpan data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan');
        });
    });
</script>
{{-- END TAMBAH DOKUMEN --}}


{{-- EDIT DOKUMEN --}}
<script>
function tambahEventListenerBtnEditDokumen(){
document.querySelectorAll('.btn-edit-dokumen').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        console.log(id);
        fetch(`/dokumen/${id}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                document.getElementById('edit-dokumen-id').value = data.id;
                document.getElementById('edit-dokumen-nama_dokumen').value = data.nama_dokumen;
                document.getElementById('edit-dokumen-tanggal_dokumen').value = data.tanggal_dokumen;
                document.getElementById('edit-dokumen-keterangan_dokumen').value = data.keterangan_dokumen;
                // document.getElementById('edit-dokumen-file_dokumen').value = data.file_dokumen;
                document.getElementById('edit-dokumen-file-preview').innerHTML = `
                <a href="/storage/${data.file_dokumen}" target="_blank">Lihat Dokumen Lama</a>
                `;

                const modal = new bootstrap.Modal(document.getElementById('modalEditDokumen'));
                modal.show();
            });
    });
});
}
tambahEventListenerBtnEditDokumen();

document.getElementById('formEditDokumen').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('edit-dokumen-id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/dokumen/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // atau update baris tabel secara dinamis
        }
    });
});

</script>
{{-- END EDIT DOKUMEN --}}

{{-- DELETE DOKUMEN  --}}
<script>
    function tambahEventListenerBtnDeleteDokumen(){
        document.querySelectorAll('.btn-delete-dokumen').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama_dokumen = this.dataset.nama_dokumen;
                if (!confirm(`Yakin ingin menghapus Dokumen ${nama_dokumen} {{$peralatan->kode}} ?`)) return;
                fetch(`/dokumen/${id}`, {
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
    }

    tambahEventListenerBtnDeleteDokumen();
</script>
{{-- END DELETE DOKUMEN --}}

@endsection
