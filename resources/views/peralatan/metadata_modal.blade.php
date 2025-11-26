<div class="modal fade" id="metadataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="POST" action="{{ route('peralatan.updateMetadata', $peralatan->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Metadata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div id="metadata-container">
                        @if ($peralatan->metadata)
                            @foreach ($peralatan->metadata as $key => $value)
                                <div class="row g-2 align-items-center mb-2 meta-row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="metadata_keys[]"
                                            value="{{ $key }}" placeholder="Key">
                                    </div>
                                    <div
                                        class="{{ in_array(auth()->user()->role, ['admin', 'teknisi']) ? 'col-5' : 'col-6' }}">
                                        <input type="text" class="form-control" name="metadata_values[]"
                                            value="{{ $value }}" placeholder="Value">
                                    </div>
                                    @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                                        <div class="col-1">
                                            <button type="button" class="btn btn-close bg-danger p-2"
                                                onclick="confirm('anda yakin menghapus metadata') ? this.closest('.meta-row').remove() : null ">x</button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                        <button type="button" class="btn btn-secondary btn-sm mt-3" onclick="addMetadataRow()">
                            + Tambah Metadata
                        </button>
                    @endif
                </div>
                @if (in_array(auth()->user()->role, ['admin', 'teknisi']))
                    <div class="modal-footer">
                        {{-- <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                @endif

            </form>

        </div>
    </div>
</div>

<script>
    function addMetadataRow(key = '', value = '') {
        let html = `
        <div class="row g-2 align-items-center mb-2 meta-row">
            <div class="col-6">
                <input type="text" class="form-control" name="metadata_keys[]" value="${key}" placeholder="Key">
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="metadata_values[]" value="${value}" placeholder="Value">
            </div>
            <div class="col-1">
                  <button type="button" class="btn btn-close bg-danger p-2"
                                                onclick="confirm('anda yakin menghapus metadata') ? this.closest('.meta-row').remove() : null ">x</button>
            </div>
        </div>
    `;

        document.getElementById('metadata-container').insertAdjacentHTML('beforeend', html);
    }
</script>
