@extends('layouts.app', ['title' => ''])

{{-- @section('title', 'Data Peralatan') --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Hardware</h4>
        @if(in_array(auth()->user()->role, ['admin', 'teknisi']))
        <a href="#" class="btn btn-success" id="btnTambahHardware">Tambah
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
            <div class="table-responsive">
                <table id="hardware-table" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Jenis Hardware</th>
                            <th>Merk</th>
                            <th>Tipe</th>
                            <th>SN</th>
                            <th>Jenis Peralatan</th>
                            <th>Sumber</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            @if(in_array(auth()->user()->role, ['admin', 'teknisi']))
                            <th></th>
                            @endif
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
                                <td>{{ $s->tahun_masuk }}</td>
                                <td>{{ $s->status }}</td>
                                 @if(in_array(auth()->user()->role, ['admin', 'teknisi']))
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
                                                    data-id="{{ $s->id }}"
                                                    data-jenis_hardware="{{ $s->jenis_hardware }}">Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                                @endif
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

    {{-- @include('hardware.modal_tambah') --}}
    {{-- @include('hardware.modal_edit') --}}
    @include('hardware.modal')
@endsection
@section('scripts')
    <script>
        function tampilkanErrorValidasi(errors) {
            // Bersihkan error sebelumnya
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            for (const [field, messages] of Object.entries(errors)) {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');

                    const feedback = document.createElement('div');
                    feedback.classList.add('invalid-feedback');
                    feedback.innerText = messages.join(', ');

                    input.parentNode.appendChild(feedback);
                }
            }
        }

        function cekStatusHardware(statusValue) {
            const inputTanggalKeluar = document.getElementById('tanggalKeluar');
            const divTanggalKeluar = document.getElementById('divTanggalKeluar');
            const inputLokasiPengiriman = document.getElementById('lokasiPengiriman');
            const divLokasiPengiriman = document.getElementById('divLokasiPengiriman');
            const inputLokasiPemasangan = document.getElementById('lokasiPemasangan');
            const divLokasiPemasangan = document.getElementById('divLokasiPemasangan');
            const divInputNomorSurat = document.getElementById('divInputNomorSurat');
            const inputNomorSurat = document.getElementById('nomorSurat')
            const divInputFileBerkas = document.getElementById('divInputFileBerkas');
            const inputFileBerkas = document.getElementById('berkas');
            const divTanggalDilepas = document.getElementById('divTanggalDilepas');
            const inputTanggalDilepas = document.getElementById('tanggalDilepas');
            if (statusValue === 'ready') {
                divTanggalKeluar.style.display = 'none';
                inputTanggalKeluar.required = false;
                divLokasiPengiriman.style.display = 'none';
                inputLokasiPengiriman.required = false;
                divLokasiPemasangan.style.display = 'none';
                inputLokasiPemasangan.required = false;
                divInputFileBerkas.style.display = "none";
                inputFileBerkas.required = false;
                divInputNomorSurat.style.display = "none";
                inputNomorSurat.required = false;
                divTanggalDilepas.style.display = "none";
                inputTanggalDilepas.required = false;
            } else if (statusValue === 'terpasang') {
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
                divTanggalDilepas.style.display = "none";
                inputTanggalDilepas.required = false;
            } else if (statusValue === 'terkirim') {
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
                divTanggalDilepas.style.display = "none";
                inputTanggalDilepas.required = false;
                // pelepasanInput.value = ''; // optional: reset value
            } else if (statusValue === 'dilepas') {
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
        }

        function addEventTambahFormSubmit() {
            document.getElementById('formHardware').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch("{{ route('hardware.store') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        const status = response.status;
                        const text = await response.text();

                        if (status === 422) {
                            const errorData = JSON.parse(text);
                            tampilkanErrorValidasi(errorData.errors);
                            return;
                        }

                        if (!response.ok) {
                            console.error(`HTTP ${status} Error:\n`, text);
                            alert(`Gagal menyimpan data (HTTP ${status}):\n` + text);
                            throw new Error(`HTTP ${status}`);
                        }

                        try {
                            const data = JSON.parse(text);
                            if (data.success) {
                                location.reload();

                                form.reset();
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'modalHardware'));
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
        }

        document.getElementById('btnTambahHardware').addEventListener('click', function() {
            const formHardware = document.getElementById('formHardware');
            formHardware.reset();
            addEventTambahFormSubmit()
            cekStatusHardware('ready');
            document.getElementById('modalTitle').innerHTML = 'Tambah Hardware';
            const modal = new bootstrap.Modal(document.getElementById(
                'modalHardware'));
            modal.show();



        })

        document.getElementById('status').addEventListener('change', function(e) {
            cekStatusHardware(e.target.value);

        });


        function pilihanLokasiPemasangan(jenisPeralatan, nilaiYangDipilih = null) {
            const jenis = jenisPeralatan;
            const peralatanSelect = document.getElementById('lokasiPemasangan');

            // Kosongkan dulu
            peralatanSelect.innerHTML = '<option value="">-- Pilih Lokasi Pemasangan --</option>';

            if (jenis) {
                fetch(`/get-peralatan-by-jenis?jenis=${encodeURIComponent(jenis)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(alat => {
                            const option = document.createElement('option');
                            // Pastikan alat.id adalah nilai yang kamu cari (value option)
                            option.value = alat.id;
                            option.textContent = `${alat.kode} - ${alat.lokasi}`;
                            peralatanSelect.appendChild(option);
                        });

                        // 🌟 FIX: Atur nilai yang dipilih di sini, setelah opsi ditambahkan
                        if (nilaiYangDipilih) {
                            peralatanSelect.value = nilaiYangDipilih;
                        }

                    })
                    .catch(error => {
                        console.error('Gagal ambil data peralatan:', error);
                    });
            }
        }

        document.getElementById('jenisPeralatan').addEventListener('change', function(e) {
            pilihanLokasiPemasangan(e.target.value);
        });
    </script>

    {{-- EDIT HARDWARE --}}
    <script>
        function tambahEventListenerBtnEdit() {
            document.querySelectorAll('.btn-edit-hardware').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/hardware/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            console.log("data", data);
                            pilihanLokasiPemasangan(data.jenis_peralatan, data.lokasi_pemasangan);
                            document.getElementById('idHardware').value = data.id;
                            document.getElementById('jenisHardware').value = data.jenis_hardware;
                            document.getElementById('jenisPeralatan').value = data
                                .jenis_peralatan;
                            document.getElementById('sumberPengadaan').value = data
                                .sumber_pengadaan;
                            document.getElementById('tahunMasuk').value = data
                                .tahun_masuk;
                            document.getElementById('tanggalMasuk').value = data
                                .tahun_masuk;
                            document.getElementById('merk').value = data
                                .merk;
                            document.getElementById('tipe').value = data
                                .tipe;
                            document.getElementById('serialNumber').value = data.serial_number;
                            document.getElementById('status').value = data.status;
                            document.getElementById('tanggalKeluar').value = data
                                .tanggal_keluar;
                            document.getElementById('tanggalDilepas').value = data
                                .tanggal_dilepas;
                            document.getElementById('lokasiPengiriman').value = data
                                .lokasi_pengiriman;
                            document.getElementById('nomorSurat').value = data
                                .nomor_surat;
                            document.getElementById('keterangan').value = data.keterangan;
                            // document.getElementById('edit-hardware-lokasi-pengiriman').value = data
                            //     .lokasi_pengiriman;
                            // document.getElementById('edit-hardware-keterangan').value = data.keterangan;
                            if (data.berkas != null) {
                                document.getElementById('edit-hardware-file-preview').innerHTML = `
                        <a href="/storage/${data.berkas}" target="_blank">Lihat Dokumen Lama</a>
                        `;
                            }

                            cekStatusHardware(data.status);
                            document.getElementById('modalTitle').innerHTML = 'Edit Hardware';
                            const modal = new bootstrap.Modal(document.getElementById(
                                'modalHardware'));
                            modal.show();

                        });

                    document.getElementById('modalHardware').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const id = document.getElementById('idHardware').value;
                        // const formData = new FormData(this);

                        const form = e.target;
                        const formData = new FormData(form);
                        formData.append('_method', 'PUT');



                        fetch(`/hardware/${id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token'),
                                    // 'X-HTTP-Method-Override': 'PUT',
                                    'Accept': 'application/json'

                                },
                                body: formData
                            })
                            .then(async response => {
                                const status = response.status;
                                const text = await response.text();

                                if (status === 422) {
                                    const errorData = JSON.parse(text);
                                    tampilkanErrorValidasi(errorData.errors);
                                    return;
                                }

                                if (!response.ok) {
                                    console.error(`HTTP ${status} Error:\n`, text);
                                    alert(`Gagal menyimpan data (HTTP ${status}):\n` +
                                        text);
                                    throw new Error(`HTTP ${status}`);
                                }

                                try {
                                    const data = JSON.parse(text);
                                    if (data.success) {
                                        location.reload();

                                        form.reset();
                                        const modal = bootstrap.Modal.getInstance(document
                                            .getElementById(
                                                'modalHardware'));
                                        modal.hide();
                                    } else {
                                        console.warn(
                                            'Respon sukses tapi flag success = false:',
                                            data);
                                        alert('Gagal menyimpan data: ' + JSON.stringify(
                                            data));
                                    }
                                } catch (err) {
                                    console.error('Gagal parsing JSON:', err,
                                        '\nRaw response:', text);
                                    alert('Respon tidak bisa diproses:\n' + text);
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                alert('Terjadi kesalahan saat menyimpan:\n' + error.message);
                            });
                    });


                });
            });
        }
        tambahEventListenerBtnEdit();

        // DELETE HARDWARE
        document.querySelectorAll('.btn-delete-hardware').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const jenisHardware = this.dataset.jenis_hardware;
                if (!confirm(`Yakin ingin menghapus Hardware ${jenisHardware} ?`))
                    return;
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
    </script>
@endsection
