<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('barang-masuk.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                placeholder="Masukkan nama barang" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Supplier</label>
                            <input type="text" name="supplier" class="form-control"
                                placeholder="Masukkan nama supplier" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
