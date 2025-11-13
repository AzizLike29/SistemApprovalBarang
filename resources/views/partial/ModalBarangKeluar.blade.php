<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('barang-keluar.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <select id="nama_barangs" name="nama_barang" class="form-select" required>
                                <option value="" disabled selected>— Pilih —</option>
                                @foreach ($opsiBarangMasuk as $row)
                                    <option value="{{ $row->nama_barang }}" data-jumlahs="{{ $row->jumlah }}"
                                        data-idmasuk="{{ $row->id_brg_masuk }}">
                                        {{ $row->nama_barang }} (stok terakhir: {{ $row->jumlah }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Jumlah</label>
                            <input type="number" min="1" id="jumlahs" name="jumlah" class="form-control"
                                required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" placeholder="Tujuan Keluar Barang"
                                required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keperluan</label>
                            <input type="text" name="keperluan" class="form-control"
                                placeholder="Masukkan keperluan keluar barang" required>
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
