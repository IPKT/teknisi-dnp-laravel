@extends('layouts.app', ['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Hardware</h4>
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahHardware">Tambah
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
                <table id="hardware-table" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Jenis Barang</th>
                            <th>Merk</th>
                            <th>Tipe</th>
                            <th>SN</th>
                            <th>Jenis Peralatan</th>
                            <th>Sumber</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="bodyHardwareTable">
                        @forelse($hardwares as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->jenis_hardware }}</td>
                                <td>{{ $s->merk }}</td>
                                <td>{{ $s->tipe }}</td>
                                <td>{{ $s->serial_number }}</td>
                                <td>{{ $s->jenis_peralatan }}</td>
                                <td>{{ $s->sumber_pengadaan }}</td>
                                <td>{{ $s->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class=""><a href="#"
                                                    class="dropdown-item btn-edit-hardware small py-1"
                                                    data-id="{{ $s->id }}">Edit</a></li>
                                            <li><a href="#" class="dropdown-item btn-delete-hardware small py-1"
                                                    data-id="{{ $s->id }}">Hapus</a></li>
                                        </ul>
                                    </div>
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

    @include('hardware.modal_tambah')
    @include('hardware.modal_edit')
@endsection

@section('scripts')
    {{-- <script>
    document.getElementById('formTambahSparepart').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        console.log(formData);

        fetch("{{ route('sparepart.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // location.reload();
                // Tambahkan baris baru ke tabel
                const tbody = document.getElementById('bodySparepartTable');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${tbody.children.length + 1}</td>
                    <td>${data.sparepart.jenis_barang}</td>
                    <td>${data.sparepart.merk}</td>
                    <td>${data.sparepart.tipe}</td>
                    <td>${data.sparepart.serial_number}</td>
                    <td>${data.sparepart.jenis_peralatan}</td> 
                    <td>Aksi</td>     
                `;
                tbody.appendChild(row);

                // Reset form dan tutup modal
                form.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahSparepart'));
                modal.hide();
                // tambahEventListenerBtnEdit();
                // tambahEventListenerBtnDelete();
            } else {
                alert('Gagal menyimpan data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan');
        });
    });

</script> --}}

    {{-- Tambah hardware --}}
    <script>
        document.getElementById('selectStatusHardware').addEventListener('change', function(e) {
            // const pelepasanInput = document.getElementById('inputTanggalPelepasan');
            const inputTanggalKeluar = document.getElementById('inputTanggalKeluar');
            const divTanggalKeluar = document.getElementById('divTanggalKeluar');
            const inputLokasiPengiriman = document.getElementById('inputLokasiPengiriman');
            const divLokasiPengiriman = document.getElementById('divLokasiPengiriman');
            const inputLokasiPemasangan = document.getElementById('inputLokasiPemasangan');
            const divLokasiPemasangan = document.getElementById('divLokasiPemasangan');
            const divInputNomorSurat = document.getElementById('divInputNomorSurat');
            const inputNomorSurat = document.getElementById('inputNomorSurat')
            const divInputFileBerkas = document.getElementById('divInputFileBerkas');
            const inputFileBerkas = document.getElementById('inputFileBerkas');
            const divTanggalDilepas = document.getElementById('divTanggalDilepas');
            const inputTanggalDipelas = document.getElementById('inputTanggalDipelas');
            if (e.target.value === 'ready') {
                divTanggalKeluar.style.display = 'none';
                inputTanggalKeluar.required = false;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                divLokasiPemasangan.style.display = 'none';
                inputLokasiPemasangan.required = false;
                divInputFileBerkas.style.display = "none";
                inputFileBerkas.required = 'false';
                divInputNomorSurat.style.display = "none";
                inputNomorSurat.required = false;
            } else if (e.target.value === 'terpasang') {
                divTanggalKeluar.style.display = 'block';
                inputTanggalKeluar.required = true;
                divLokasiPemasangan.style.display = 'block';
                inputLokasiPemasangan.required = true;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                divInputFileBerkas.style.display = "block";
                // inputFileBerkas.required = 'true';
                divInputNomorSurat.style.display = "block";
                // inputNomorSurat.required = false;
                // pelepasanInput.value = ''; // optional: reset value
            } else if (e.target.value === 'terkirim') {
                divTanggalKeluar.style.display = 'block';
                inputTanggalKeluar.required = true;
                divLokasiPemasangan.style.display = 'none';
                inputLokasiPemasangan.required = false;
                divLokasiPengiriman.style.display = 'block';
                inputLokasiPengiriman.required = true;
                divInputFileBerkas.style.display = "block";
                // inputFileBerkas.required = 'true';
                divInputNomorSurat.style.display = "block";
                inputNomorSurat.required = false;
                // pelepasanInput.value = ''; // optional: reset value
            } else if (e.target.value === 'dilepas') {
                divTanggalKeluar.style.display = 'block';
                // inputTanggalKeluar.required = true;
                divLokasiPemasangan.style.display = 'block';
                inputLokasiPemasangan.required = true;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                divInputFileBerkas.style.display = "block";
                // inputFileBerkas.required = 'true';
                divInputNomorSurat.style.display = "block";
                inputNomorSurat.required = false;
                divTanggalDilepas.style.display = "block";
                inputTanggalDilepas.required = true;

                // pelepasanInput.value = ''; // optional: reset value
            }
        });

        document.getElementById('jenis_peralatan').addEventListener('change', function() {
            const jenis = this.value;
            const peralatanSelect = document.getElementById('inputLokasiPemasangan');

            // Kosongkan dulu
            peralatanSelect.innerHTML = '<option value="">-- Pilih Lokasi Pemasangan --</option>';

            if (jenis) {
                fetch(`/get-peralatan-by-jenis?jenis=${encodeURIComponent(jenis)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(alat => {
                            const option = document.createElement('option');
                            option.value = alat.id;
                            option.textContent = `${alat.kode} - ${alat.lokasi}`;
                            peralatanSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Gagal ambil data peralatan:', error);
                    });
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
                .then(async response => {
                    const status = response.status;
                    const text = await response.text();

                    if (!response.ok) {
                        console.error(`HTTP ${status} Error:\n`, text);
                        alert(`Gagal menyimpan data (HTTP ${status}):\n` + text);
                        throw new Error(`HTTP ${status}`);
                    }

                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            // const tbody = document.getElementById('bodyHardwareTable');
                            // const row = document.createElement('tr');
                            // row.innerHTML = `
                        //     <td>${tbody.children.length + 1}</td>
                        //     <td>${data.hardware.jenis_barang}</td>
                        //     <td>${data.hardware.merk}</td>
                        //     <td>${data.hardware.tipe}</td>
                        //     <td>${data.hardware.serial_number}</td>
                        //     <td>${data.hardware.jenis_peralatan}</td>
                        //     <td>${data.hardware.sumber_pengadaan}</td>
                        //     <td>${data.hardware.status}</td>
                        //     <td>
                        //         <div class="dropdown">
                        //             <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        //             <i class="bi bi-three-dots-vertical"></i>
                        //             </button>
                        //             <ul class="dropdown-menu">
                        //             <li><a href="#" class="dropdown-item btn-edit" data-id="">Edit</a></li>
                        //             <li><a href="#" class="dropdown-item btn-delete" data-id="">Hapus</a></li>
                        //             </ul>
                        //         </div>
                        //     </td>
                        // `;
                            // tbody.appendChild(row);
                            location.reload();

                            form.reset();
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'modalTambahHardware'));
                            modal.hide();
                        } else {
                            console.warn('Respon sukses tapi flag success = false:', data);
                            alert('Gagal menyimpan data: ' + JSON.stringify(data));
                        }
                    } catch (err) {
                        console.error('Gagal parsing JSON:', err, '\nRaw response:', text);
                        alert('Respon tidak bisa diproses:\n' + text);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Terjadi kesalahan saat menyimpan:\n' + error.message);
                });
        });
    </script>
    {{-- END Tambah Hardware --}}

    {{-- Edit Hardware --}}
    <script>
        function tambahEventListenerBtnEdit() {
            document.querySelectorAll('.btn-edit-hardware').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/hardware/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            console.log("data", data);
                            document.getElementById('editJenisHardware').value = data.jenis_hardware;
                            document.getElementById('editJenisPeralatan').value = data
                                .jenis_peralatan;
                            document.getElementById('editSumberPengadaan').value = data
                                .sumber_pengadaan;
                            document.getElementById('editTahunMasuk').value = data
                                .tahun_masuk;
                            document.getElementById('editTanggalMasuk').value = data
                                .tahun_masuk;
                            document.getElementById('editMerk').value = data
                                .merk;
                            document.getElementById('editTipe').value = data
                                .tipe;
                            document.getElementById('editSerialNumber').value = data.serial_number;
                            document.getElementById('editStatusHardware').value = data.status;
                            document.getElementById('editTanggalKeluar').value = data
                                .tanggal_keluar;
                            document.getElementById('editTanggalDipelas').value = data
                                .tanggal_dilepas;
                            document.getElementById('editLokasiPemasangan').value = data
                                .lokasi_pemasangan;
                            document.getElementById('editLokasiPengiriman').value = data
                                .lokasi_pengiriman;
                            document.getElementById('editNomorSurat').value = data
                                .nomor_surat;
                            document.getElementById('editKeterangan').value = data.keterangan;
                            // document.getElementById('edit-hardware-lokasi-pengiriman').value = data
                            //     .lokasi_pengiriman;
                            // document.getElementById('edit-hardware-keterangan').value = data.keterangan;
                            //             if (data.berkas != null) {
                            //                 document.getElementById('edit-hardware-file-preview').innerHTML = `
                        // <a href="/storage/${data.berkas}" target="_blank">Lihat Dokumen Lama</a>
                        // `;
                            //             }

                            // document.getElementById('edit-hardware-status').value = data.status;
                            // const statusHardwareEdit = document.getElementById('edit-sardware-status')
                            //     .value;
                            // const inputTanggalKeluar = document.getElementById(
                            //     'edit-sardware-tanggal-keluar');
                            // const divTanggalKeluar = document.getElementById('divTanggalKeluarEdit');
                            // const inputLokasiPengiriman = document.getElementById(
                            //     'edit-sardware-lokasi-pengiriman');
                            // const divLokasiPengiriman = document.getElementById(
                            //     'divLokasiPengirimanEdit');
                            // const inputLokasiPemasangan = document.getElementById(
                            //     'edit-sardware-lokasi-pemasangan');
                            // const divLokasiPemasangan = document.getElementById(
                            //     'divLokasiPemasanganEdit');
                            // if (statusHardwareEdit === 'ready') {
                            //     divTanggalKeluar.style.display = 'none';
                            //     inputTanggalKeluar.required = false;
                            //     divLokasiPengiriman.style.display = 'none';
                            //     inputLokasiPengiriman.required = false;
                            //     divLokasiPemasangan.style.display = 'none';
                            //     inputLokasiPemasangan.required = false;
                            // } else if (statusHardwareEdit === 'terpasang') {
                            //     divTanggalKeluar.style.display = 'block';
                            //     inputTanggalKeluar.required = true;
                            //     divLokasiPemasangan.style.display = 'block';
                            //     inputLokasiPemasangan.required = true;
                            //     divLokasiPengiriman.style.display = 'none';
                            //     inputLokasiPengiriman.required = false;
                            //     // pelepasanInput.value = ''; // optional: reset value
                            // } else if (statusHardwareEdit === 'terkirim') {
                            //     divTanggalKeluar.style.display = 'block';
                            //     inputTanggalKeluar.required = true;
                            //     divLokasiPemasangan.style.display = 'none';
                            //     inputLokasiPemasangan.required = false;
                            //     divLokasiPengiriman.style.display = 'block';
                            //     inputLokasiPengiriman.required = true;
                            //     // pelepasanInput.value = ''; // optional: reset value
                            // }


                            const modal = new bootstrap.Modal(document.getElementById(
                                'modalEditHardware'));
                            // if (document.getElementById('edit-hardware-status').value === 'dilepas') {
                            //     document.getElementById('inputTanggalPelepasanEdit').style.display = 'block';
                            // } else {
                            //     document.getElementById('inputTanggalPelepasanEdit').style.display = 'none';
                            // }
                            modal.show();

                        });
                });
            });
        }
        tambahEventListenerBtnEdit();

        document.getElementById('edit-hardware-status').addEventListener('change', function(e) {
            // const pelepasanInput = document.getElementById('inputTanggalPelepasan');
            const inputTanggalKeluar = document.getElementById('edit-hardware-tanggal-keluar');
            const divTanggalKeluar = document.getElementById('divTanggalKeluarEdit');
            const inputLokasiPengiriman = document.getElementById('edit-hardware-lokasi-pengiriman');
            const divLokasiPengiriman = document.getElementById('divLokasiPengirimanEdit');
            const inputLokasiPemasangan = document.getElementById('edit-hardware-lokasi-pemasangan');
            const divLokasiPemasangan = document.getElementById('divLokasiPemasanganEdit');
            if (e.target.value === 'ready') {
                divTanggalKeluar.style.display = 'none';
                inputTanggalKeluar.required = false;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                divLokasiPemasangan.style.display = 'none';
                inputLokasiPemasangan.required = false;
            } else if (e.target.value === 'terpasang') {
                divTanggalKeluar.style.display = 'block';
                inputTanggalKeluar.required = true;
                divLokasiPemasangan.style.display = 'block';
                inputLokasiPemasangan.required = true;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                // pelepasanInput.value = ''; // optional: reset value
            } else if (e.target.value === 'terkirim') {
                divTanggalKeluar.style.display = 'block';
                inputTanggalKeluar.required = true;
                divLokasiPemasangan.style.display = 'none';
                inputLokasiPemasangan.required = false;
                divLokasiPengiriman.style.display = 'block';
                inputLokasiPengiriman.required = true;
                // pelepasanInput.value = ''; // optional: reset value
            }
        });

        document.getElementById('formEditHardware').addEventListener('submit', function(e) {
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
    {{-- END Edit hardware --}}

    {{-- DATA TABLE --}}
    <script>
        $(document).ready(function() {
            $('#hardware-table').DataTable({
                info: false,
                lengthChange: false,
                pageLength: 15
            });
        });
    </script>
    {{-- END DATA TABLE --}}
@endsection
