<div class="modal fade" id="modalTambahHardware" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="formTambahHardware" method="POST" enctype="multipart/form-data">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Hardware</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          {{-- <input type="hidden" name="id" id="sparepart-id"> --}}

          <div class="row g-3">
              <div class="col-md-6">
                <label for="jenis_hardware" class="form-label">Jenis Barang<span class="text-danger">*</span></label>
                <input type="text" name="jenis_hardware" list="listJenisHardware" class="form-control" required>
                <datalist id="listJenisHardware">
                @foreach($jenisHardwareList as $jenis)
                  <option value="{{ $jenis }}">
                @endforeach
              </datalist>
              </div>
              <div class="col-md-6">
                <label for="jenis_peralatan" class="form-label">Jenis Peralatan<span class="text-danger">*</span></label>
                {{-- <input type="text" name="jenis_peralatan" class="form-control" required> --}}
                <select name="jenis_peralatan" class="form-select" required>
                  @foreach($jenis_peralatan as $jenis)
                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="sumber_pengadaan" class="form-label">Sumber Pengadaan<span class="text-danger">*</span></label>
                <input type="text" name="sumber_pengadaan" list="sumberPengadaanList" class="form-control" required>
                <datalist id="sumberPengadaanList">
                @foreach($sumberPengadaanList as $s)
                  <option value="{{ $s }}">
                @endforeach
                </datalist>

              </div>
              

              <div class="col-md-6">
                <label for="tahun_masuk" class="form-label">Tahun Masuk<span class="text-danger">*</span></label>
                <input type="number" name="tahun_masuk" class="form-control" required maxlength="4" min="2000" max="2050">
              </div>

              <div class="col-md-6">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control">
              </div>

              <div class="col-md-6">
                <label for="merk" class="form-label">Merk<span class="text-danger">*</span></label>
                <input type="text" name="merk" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label for="tipe" class="form-label">Tipe<span class="text-danger">*</span></label>
                <input type="text" name="tipe" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" name="serial_number" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">File</label>
                <input type="file" name="berkas" class="form-control" accept="application/pdf">
            </div>
            <div class="col-md-6">
                <label class="form-label">Gambar</label>
                <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png, .webp">
            </div>
              <div class="col-md-6">
              <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
              <select name="status" class="form-select" id="selectStatusSparepart">
                <option selected value="ready">Ready</option>
                <option  value="terpasang">Terpasang</option>
                <option  value="terkirim">Terkirim</option>
              </select>
              </div>
               <div class="col-md-6" style="display: none;" id="divTanggalKeluar">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar<span class="text-danger">*</span></label>
                <input type="date" name="tanggal_keluar" id="inputTanggalKeluar" class="form-control" >
              </div>
               <div class="col-md-6" style="display: none;" id="divTanggalDilepas">
                <label for="tanggal_dilepas" class="form-label">Tanggal Dilepas<span class="text-danger">*</span></label>
                <input type="date" name="tanggal_dilepas" id="inputTanggalDipelas" class="form-control" >
              </div>
              <div class="col-md-6" id="divLokasiPemasangan" style="display: none;">
                <label for="lokasi_pemasangan" class="form-label">Lokasi Pemasangan<span class="text-danger">*</span></label>
                {{-- <input type="text" name="lokasi_pemasangan" list="lokasiPemasanganList" id="inputLokasiPemasangan" class="form-control" > --}}
                  <select name="jenis_hardware" class="form-select" id="inputLokasiPemasangan" required>
                    <option value="">-- Pilih Jenis Hardware --</option>
                    @foreach ($peralatans as $p)
                        <option value="{{ $p->id }}">{{ $p->kode }}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-6" id="divLokasiPengiriman" style="display: none;">
                <label for="lokasi_pengiriman" class="form-label">Lokasi Pengiriman<span class="text-danger">*</span></label>
                <input type="text" name="lokasi_pengiriman"  id="inputLokasiPengiriman" class="form-control" >
              </div>
              <div class="col-md-12">
                <label for="serial_number" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" id="edit-sparepart-keterangan" class="form-control">
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