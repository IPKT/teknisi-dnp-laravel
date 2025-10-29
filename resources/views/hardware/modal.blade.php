<div class="modal fade" id="modalHardware" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formHardware" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- <input type="hidden" name="id" id="sparepart-id"> --}}

                    <div class="row g-3">
                        <input type="text" id="idHardware" hidden>
                        <div class="col-md-6">
                            <label for="jenis_hardware" class="form-label">Jenis Barang<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="jenisHardware" name="jenis_hardware" list="listJenisHardware"
                                class="form-control" placeholder="jangan membuat nama baru" required>
                            <datalist id="listJenisHardware">
                                @foreach ($jenisHardwareList as $jenis)
                                    <option value="{{ $jenis }}">
                                @endforeach
                            </datalist>
                             <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_peralatan" class="form-label">Jenis Peralatan<span
                                    class="text-danger">*</span></label>
                            {{-- <input type="text" name="jenis_peralatan" class="form-control" required> --}}
                            <select id="jenisPeralatan" name="jenis_peralatan" class="form-select" id="jenis_peralatan"
                                required>
                                <option value="">-- Pilih Jenis Peralatan --</option>
                                @foreach ($jenis_peralatan as $jenis)
                                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                                @endforeach
                            </select>
                             <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="sumber_pengadaan" class="form-label">Sumber Pengadaan<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="sumberPengadaan" name="sumber_pengadaan"
                                list="sumberPengadaanList" class="form-control" required>
                            <datalist id="sumberPengadaanList">
                                @foreach ($sumberPengadaanList as $s)
                                    <option value="{{ $s }}">
                                @endforeach
                            </datalist>
                             <div class="invalid-feedback"></div>

                        </div>


                        <div class="col-md-6">
                            <label for="tahun_masuk" class="form-label">Tahun Masuk<span
                                    class="text-danger">*</span></label>
                            <input type="number" id="tahunMasuk" name="tahun_masuk" class="form-control" required
                                maxlength="4" min="2000" max="2050">
                                 <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" id="tanggalMasuk" name="tanggal_masuk" class="form-control">
                             <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="merk" class="form-label">Merk<span class="text-danger">*</span></label>
                            <input type="text" id="merk" name="merk" class="form-control" required>
                             <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="tipe" class="form-label">Tipe<span class="text-danger">*</span></label>
                            <input type="text" id="tipe" name="tipe" class="form-control" required>
                             <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" id="serialNumber" name="serial_number" class="form-control">
                             <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gambar</label>
                            <input type="file" id="gambar" name="gambar" class="form-control"
                                accept=".jpg, .jpeg, .png, .webp">
                                 <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                            <select name="status" class="form-select" id="status">
                                <option selected value="ready">Ready</option>
                                <option value="terpasang">Terpasang</option>
                                <option value="terkirim">Terkirim</option>
                                <option value="dilepas">Dilepas</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="display: none;" id="divTanggalKeluar">
                            <label for="tanggal_keluar" class="form-label">Tanggal Pemasangan / Pengiriman<span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_keluar" id="tanggalKeluar" class="form-control">
                        </div>
                        <div class="col-md-6" style="display: none;" id="divTanggalDilepas">
                            <label for="tanggal_dilepas" class="form-label">Tanggal Dilepas<span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_dilepas" id="tanggalDilepas" class="form-control">
                        </div>
                        <div class="col-md-6" id="divLokasiPemasangan" style="display: none;">
                            <label for="lokasi_pemasangan" class="form-label">Lokasi Pemasangan<span
                                    class="text-danger">*</span></label>
                            {{-- <input type="text" name="lokasi_pemasangan" list="lokasiPemasanganList" id="inputLokasiPemasangan" class="form-control" > --}}
                            <select name="lokasi_pemasangan" class="form-select" id="lokasiPemasangan">
                                <option value="">-- Pilih Lokasi Pemasangan --</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="divLokasiPengiriman" style="display: none;">
                            <label for="lokasi_pengiriman" class="form-label">Lokasi Pengiriman<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="lokasi_pengiriman" id="lokasiPengiriman"
                                class="form-control">
                                 <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6" id="divInputNomorSurat" style="display: none;">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomorSurat" class="form-control">
                             <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6" id="divInputFileBerkas" style="display: none;">
                            <label class="form-label">Berkas Pemasangan</label>
                            <input type="file" name="berkas" class="form-control" accept="application/pdf"
                                id="berkas">
                            <small class="text-muted">File sebelumnya: <span
                                    id="edit-hardware-file-preview"></span></small>
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
