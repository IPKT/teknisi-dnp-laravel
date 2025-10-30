<!-- Modal -->
<div class="modal fade" id="hardwareShowModal" tabindex="-1" aria-labelledby="hardwareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hardwareModalLabel">Detail Hardware</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody id="hardwareDetailBody">
                        <!-- Dynamic rows will be injected here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- SHOW HARDWARE --}}
<script>
    function showHardwareDetail(id) {
        const baseUrl = "{{ route('hardware.show', 'REPLACE_ID') }}";
        const url = baseUrl.replace('REPLACE_ID', id);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const fields = {
                    jenis_hardware: 'Jenis Hardware',
                    jenis_peralatan: 'Jenis Peralatan',
                    tahun_masuk: 'Tahun Masuk',
                    tanggal_masuk: 'Tanggal Masuk',
                    merk: 'Merk',
                    tipe: 'Tipe',
                    serial_number: 'Serial Number',
                    status: 'Status',
                    sumber_pengadaan: 'Sumber Pengadaan',
                    tanggal_keluar: 'Tanggal Pasang/Kirim',
                    tanggal_dilepas: 'Tanggal Dilepas',
                    kode_lokasi_pemasangan: 'Lokasi Pemasangan',
                    lokasi_pengiriman: 'Lokasi Pengiriman',
                    nomor_surat: 'Nomor Surat',
                    keterangan: 'Keterangan',
                    berkas: 'Berkas',
                    gambar: 'Gambar'
                };
                // const lokasiPemasangan = data.lokasi_pemasangan;
                const tbody = document.getElementById('hardwareDetailBody');
                tbody.innerHTML = ''; // Clear previous content

                Object.entries(fields).forEach(([key, label]) => {
                    if (data[key]) {
                        let value = data[key];

                        if (key === 'berkas') {
                            value = `<a href="/storage/${value}" target="_blank">Download</a>`;
                        } else if (key === 'gambar') {
                            value =
                                `<img src="/storage/${value}" class="img-fluid" style="max-height:200px;">`;
                        } else if (key === 'kode_lokasi_pemasangan') {
                            value = `<a href="${data.lokasi_pemasangan_url}">${value}</a>`;
                        }

                        tbody.innerHTML += `
                                <tr>
                                <th>${label}</th>
                                <td>${value}</td>
                                </tr>
                            `;
                    }
                });

                const modal = new bootstrap.Modal(document.getElementById('hardwareShowModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Gagal ambil data hardware:', error);
            });
    }
</script>
