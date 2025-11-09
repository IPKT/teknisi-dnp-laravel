<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('hardware.download') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Download Hardware</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="download_lokasi_pemasangan" class="form-label">Lokasi Pemasangan</label>
                        <input type="text" name="lokasi_pemasangan" id="download_lokasi_pemasangan" class="form-control"
                            placeholder="Lokasi Pemasangan" list="lokasiPemasanganList">
                        <datalist id="lokasiPemasanganList">
                            @foreach ($lokasiPemasanganList as $lp)
                                <option value="{{ $lp }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="download_sumber_pengadaan" class="form-label">Sumber Pengadaan</label>
                        <select name="sumber_pengadaan" id="download_sumber_pengadaan" class="form-select">
                            <option value="">-- Pilih Sumber --</option>
                            @foreach ($sumberPengadaanList as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="download_tahun_masuk" class="form-label">Tahun Masuk</label>
                        <select name="tahun_masuk" id="download_tahun_masuk" class="form-select">
                            <option value="">-- Tahun Masuk --</option>
                            @for ($y = now()->year; $y >= 2015; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                     <div class="mb-3">
                        <label for="download_status" class="form-label">Status</label>
                        <select name="status" id="download_status" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            @foreach ($statusHardwareList as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>
