<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('hardware.download') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Download Hardware Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lokasi_pemasangan" class="form-label">Lokasi Pemasangan</label>
                        <input type="text" name="lokasi_pemasangan" id="lokasi_pemasangan" class="form-control"
                            placeholder="Lokasi Pemasangan">
                    </div>
                    <div class="mb-3">
                        <label for="sumber_pengadaan" class="form-label">Sumber Pengadaan</label>
                        <select name="sumber_pengadaan" id="sumber_pengadaan" class="form-select">
                            <option value="">-- Pilih Sumber --</option>
                            <option value="Pengadaan DNP">Pengadaan DNP</option>
                            <option value="Pengadaan Internal">Pengadaan Internal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                        <select name="tahun_masuk" id="tahun_masuk" class="form-select">
                            <option value="">-- Tahun Masuk --</option>
                            @for ($y = now()->year; $y >= 2015; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
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
