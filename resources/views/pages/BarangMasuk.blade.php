@extends('layout.app', ['hideNavAndFooter' => false, 'showSidebar' => true])

@section('title', 'Barang Masuk')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header bg-white position-relative py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div id="dtFilterContainer" class="me-3"></div>

                    @if (Auth::user()->role === 'user')
                        <button type="button" class="btn btn-lg btn-success d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#modalTambahBarang">
                            <i class="bi bi-plus-lg me-1 fw-bold"></i><span>Tambah</span>
                        </button>
                    @endif
                </div>

                <h3 class="m-0 text-center header-center">Transaksi Barang Masuk</h3>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    @include('partial.NotifMessages')
                    <table id="tblBarangMasuk" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr class="text-center">
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $row)
                                <tr>
                                    <td>{{ optional($row->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td class="text-end">{{ $row->jumlah }}</td>
                                    <td>{{ $row->supplier }}</td>
                                    <td class="text-center">
                                        @if ($row->is_approved == 0)
                                            <span class="badge bg-warning text-dark">Belum Approve</span>
                                        @elseif ($row->is_approved == 1)
                                            <span class="badge bg-success">Sudah Approve</span>
                                        @elseif ($row->is_approved == 2)
                                            <span class="badge bg-danger">Tidak Approve</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $row->id_brg_masuk }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @include('partial.ModalEditBarangMasuk', ['row' => $row])

                                        @if (Auth::user()->role === 'admin' && (int) ($row->is_approved ?? 0) === 0)
                                            <form action="{{ route('barang-masuk.approve', $row->id_brg_masuk) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success me-1"
                                                    title="Approve">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('barang-masuk.notApprove', $row->id_brg_masuk) }}"
                                                method="POST" class="d-inline js-not-approve-form">
                                                @csrf
                                                @method('PUT')

                                                {{-- sediakan field dari awal --}}
                                                <input type="hidden" name="alasan" value="">

                                                <button type="submit" class="btn btn-sm btn-outline-dark me-1"
                                                    title="Tidak Approve">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('barang-masuk.destroy', $row->id_brg_masuk) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" id="delete-barang">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('partial.ModalBarangMasuk')
@endpush

@section('scripts')
    <script>
        // ATUR DATATABLES
        $(function() {
            const dt = $('#tblBarangMasuk').DataTable({
                scrollX: false,
                pageLength: 10,
                paging: true,
                searching: true,
                ordering: true,
                order: [
                    [0, 'desc']
                ],
                pagingType: 'simple_numbers',
                autoWidth: false,
                language: {
                    lengthMenu: 'Tampilkan data _MENU_',
                    search: '',
                    searchPlaceholder: 'Cari barang...',
                    info: 'Menampilkan _START_-_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Tidak ada data yang cocok',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i> Sebelumnya',
                        next: 'Berikutnya <i class="bi bi-chevron-right"></i>'
                    }
                },
                dom: "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'f>>" +
                    "t" +
                    "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>",
                drawCallback: function() {
                    // Tetapkan width tabel konsisten
                    $('#tblBarangMasuk').css('width', '100%');
                }
            });

            // Styling Bootstrap 5
            $('.dataTables_length select')
                .addClass('form-select form-select-sm')
                .css('width', '70px');

            $('.dataTables_filter input')
                .addClass('form-control form-control-sm')
                .css({
                    'border-radius': '8px',
                    'padding': '0.5rem 1rem'
                });

            $('.dataTables_paginate .pagination')
                .addClass('pagination-sm mb-0');

            // Style pagination buttons
            $('.dataTables_paginate .page-link')
                .css({
                    'color': '#495057',
                    'border': '1px solid #dee2e6',
                    'border-radius': '6px',
                    'margin': '0 3px',
                    'font-weight': '500'
                });

            $('.dataTables_paginate .page-item.active .page-link')
                .css({
                    'background-color': '#4a5568',
                    'border-color': '#4a5568',
                    'color': 'white'
                });

            $('.dataTables_paginate .page-item.disabled .page-link')
                .css({
                    'color': '#adb5bd',
                    'background-color': 'transparent'
                });

            // Style table header
            $('#tblBarangMasuk thead th')
                .css({
                    'background-color': '#4a5568',
                    'color': 'white',
                    'font-weight': '600',
                    'border': 'none'
                });

            // Hover effect rows
            $('#tblBarangMasuk tbody tr').hover(
                function() {
                    $(this).css('background-color', '#f8f9fa');
                },
                function() {
                    $(this).css('background-color', '');
                }
            );
        });

        // Styling untuk pesan empty
        $('#tblBarangMasuk').on('draw.dt', function() {
            const emptyCell = $('.dataTables_empty');
            if (emptyCell.length) {
                emptyCell
                    .closest('tbody')
                    .addClass('text-center')
                    .css('height', '150px');

                emptyCell
                    .addClass('fw-semibold text-muted')
                    .html('<i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada data');
            }
        });

        // Hapus barang
        document.querySelectorAll('#delete-barang').forEach(button => {
            button.addEventListener('click', function() {
                // inisialisasi variabel form
                const form = this.closest('form');

                // memberikan pesan ketika delete form
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Data akan hilang selamanya!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#388143",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            text: "Berhasil dihapus!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                form.submit();
                            }
                        });
                    }
                });
            });
        });

        // Tidak Approve
        $(document).on('submit', '.js-not-approve-form', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Alasan Tidak Approve',
                input: 'text',
                inputLabel: 'Tulis alasan singkat',
                inputPlaceholder: 'Contoh: Dokumen kurang lengkap',
                inputAttributes: {
                    maxlength: 200,
                    autocomplete: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Kirim',
                cancelButtonText: 'Batal',
                inputValidator: v => (!v || !v.trim()) && 'Alasan wajib diisi ya :)'
            }).then(res => {
                if (res.isConfirmed) {
                    // isi hidden input yang sudah ada
                    $(form).find('input[name="alasan"]').val(res.value.trim());

                    // submit pakai native submit supaya nggak ngetrigger handler lagi
                    HTMLFormElement.prototype.submit.call(form);
                }
            });
        });
    </script>
@endsection
