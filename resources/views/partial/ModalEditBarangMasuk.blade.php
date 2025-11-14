<div class="modal fade" id="modalEdit-{{ $row->id_brg_masuk }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('barang-masuk.update', $row->id_brg_masuk) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body text-start">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required
                                value="{{ old('tanggal', \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" maxlength="255" required
                                value="{{ old('nama_barang', $row->nama_barang) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required
                                value="{{ old('jumlah', $row->jumlah) }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Supplier</label>
                            <input type="text" name="supplier" class="form-control" maxlength="255" required
                                value="{{ old('supplier', $row->supplier) }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
