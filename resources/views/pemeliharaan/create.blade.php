@extends('layouts.app', ['title' => 'Tambah Pemeliharaan'])

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Tambah Pemeliharaan</h4>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('pemeliharaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        {{-- <div class="col-md-4">
                        <label>Jenis</label>
                        <select name="jenis" class="form-select">
                            <option>Intensitymeter Realshake</option>
                            <option>Seismometer</option>
                            <option>Accelero Non Colocated</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Peralatan</label>
                        <select name="id_peralatan" class="form-select" required>
                            <option value="">-- Pilih Peralatan --</option>
                            @foreach ($peralatans as $alat)
                                <option value="{{ $alat->id }}">{{ $alat->kode }} - {{ $alat->lokasi }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        <div class="col-md-4">
                            <label>Pilih Jenis Peralatan<span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-select">
                                <option value="">-- Pilih Jenis --</option>
                           @foreach ($jenis_peralatan as $jp)
                                    <option value="{{ $jp }}">{{ $jp }}</option>
                           @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Peralatan<span class="text-danger">*</span></label>
                            <select name="id_peralatan" id="id_peralatan" class="form-select" required>
                                <option value="">-- Pilih Peralatan --</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Kondisi Awal<span class="text-danger">*</span></label>
                            <select name="kondisi_awal" class="form-select">
                                <option selected value="ON">ON</option>
                                <option value="OFF">OFF</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal<span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Jenis Pemeliharaan<span class="text-danger">*</span></label>
                            <select name="jenis_pemeliharaan" class="form-select">
                                <option value="">-- Pilih Jenis Pemeliharaan--</option>
                                <option value="PM">Preventive Maintenance</option>
                                <option value="CM">Corrective Maintenance</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Pelaksana<span class="text-danger">*</span></label>
                            {{-- <input type="text" name="pelaksana" class="form-control"> --}}
                            <textarea class="form-control textAreaMultiline my-text-area" name="pelaksana" rows="3"
                                placeholder="1. Nama \n2. Nama" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Rekomendasi<span class="text-danger">*</span></label>
                            <textarea class="form-control textAreaMultiline my-text-area" name="rekomendasi" rows="3"
                                placeholder="1. Perlu.. \n2. Perlu.." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Kerusakan</label>
                            <input type="text" name="kerusakan" class="form-control"
                                placeholder="UPS, Sensor, Digitizer">
                        </div>
                        <div class="col-md-6">
                            <label>Laporan WA</label>
                            <textarea class="form-control textAreaMultiline" name="text_wa" rows="3" placeholder="copy laporan di WA Grup"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label>Catatan Penting Pemeliharaan</label>
                            <textarea name="catatan_pemeliharaan" rows="3" class="form-control"
                                placeholder="Masukan kegiatan atau kondisi yang dianggap penting"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Gambar (jpg/png)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label>Laporan (PDF)</label>
                            <input type="file" name="laporan" class="form-control" accept="application/pdf">
                        </div>
                        <div class="col-md-6">
                            <label>Laporan 2 (PDF)</label>
                            <input type="file" name="laporan2" class="form-control" accept="application/pdf">
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
        document.getElementById('jenis').addEventListener('change', function() {
            const jenis = this.value;
            const peralatanSelect = document.getElementById('id_peralatan');

            // Kosongkan dulu
            peralatanSelect.innerHTML = '<option value="">-- Pilih Peralatan --</option>';

            if (jenis) {
                const url = "{{ route('peralatan.getByJenis', ['jenis' => '__JENIS__']) }}".replace('__JENIS__',
                    jenis);
                fetch(url)
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
    </script>
    <script>
        var textAreas = document.getElementsByTagName('textarea');
        Array.prototype.forEach.call(textAreas, function(elem) {
            elem.placeholder = elem.placeholder.replace(/\\n/g, '\n');
        });
    </script>
@endsection
