<div class="modal fade" id="modalEdit-{{ $rows->id_brg_keluar }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('barang-keluar.update', $rows->id_brg_keluar) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body p-2">
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label class="form-label d-block text-start">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required
                                    value="{{ old('tanggal', \Carbon\Carbon::parse($rows->tanggal)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label class="form-label d-block text-start">Nama Barang</label>
                                <select id="nama_barang" name="nama_barang" class="form-select" required>
                                    <option value="" disabled
                                        {{ old('nama_barang', $rows->nama_barang) ? '' : 'selected' }}>— Pilih —
                                    </option>
                                    @foreach ($opsiBarangMasuk as $opt)
                                        <option value="{{ $opt->nama_barang }}" data-jumlah="{{ $opt->jumlah }}"
                                            data-idmasuk="{{ $opt->id_brg_masuk }}"
                                            {{ old('nama_barang', $rows->nama_barang) === $opt->nama_barang ? 'selected' : '' }}>
                                            {{ $opt->nama_barang }} (stok terakhir: {{ $opt->jumlah }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label class="form-label d-block text-start">Jumlah</label>
                                <input type="number" min="1" id="jumlah" name="jumlah" class="form-control"
                                    value="{{ old('jumlah', $rows->jumlah) }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label class="form-label d-block text-start">Tujuan</label>
                                <input type="text" name="tujuan" class="form-control" maxlength="255" required
                                    value="{{ old('tujuan', $rows->tujuan) }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label d-block text-start">Keperluan</label>
                                <input type="text" name="keperluan" class="form-control" maxlength="255" required
                                    value="{{ old('keperluan', $rows->keperluan) }}">
                            </div>
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
