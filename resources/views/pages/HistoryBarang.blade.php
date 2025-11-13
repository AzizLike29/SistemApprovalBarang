@extends('layout.app', ['hideNavAndFooter' => false, 'showSidebar' => true])

@section('title', 'History Barang')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body text-center p-4">
                <h3 class="fw-bold">Tampilan History Barang</h3>
            </div>

            <div class="card-body p-4">
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <a href="{{ route('history.download.pdf') }}" class="btn btn-outline-dark btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="tblHistoryBarang" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr class="text-center">
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th>Modul</th>
                                <th>Ref</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $row)
                                <tr>
                                    <td class="text-nowrap">
                                        {{ \Illuminate\Support\Carbon::parse($row->waktu)->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>{{ $row->user_nama ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary text-uppercase">{{ $row->action }}</span>
                                        @if ($row->status === 'success')
                                            <span class="badge bg-success ms-1">Success</span>
                                        @else
                                            <span class="badge bg-danger ms-1">Failed</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $row->module }}</td>
                                    <td class="text-center">{{ $row->ref_id ?? '—' }}</td>
                                    <td>
                                        {{ $row->description }}
                                        @if (!empty($row->alasan))
                                            <div class="text-muted small mt-1"><em>Alasan:</em> {{ $row->alasan }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Tombol sebelumnya --}}
                            <li class="page-item {{ $logs->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link text-secondary bg-light border-secondary"
                                    href="{{ $logs->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>

                            {{-- Nomor halaman --}}
                            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $logs->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $page == $logs->currentPage() ? 'bg-secondary text-white border-secondary' : 'text-secondary bg-light border-secondary' }}"
                                        href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Tombol selanjutnya --}}
                            <li class="page-item {{ $logs->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link text-secondary bg-light border-secondary"
                                    href="{{ $logs->nextPageUrl() ?? '#' }}" aria-label="Next">
                                    &raquo;
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ATUR DATATABLES
        $(function() {
            const dt = $('#tblHistoryBarang').DataTable({
                scrollX: false,
                pageLength: 10,
                paging: true,
                info: false,
                searching: true,
                ordering: true,
                order: [
                    [0, 'desc']
                ],
                autoWidth: false,
                language: {
                    lengthMenu: 'Tampil data _MENU_',
                    search: '',
                    searchPlaceholder: 'Cari barang...',
                    zeroRecords: 'Tidak ada data yang cocok',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                },
                dom: "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'f>>t",
                drawCallback: function() {
                    $('#tblHistoryBarang').css('width', '100%');
                }
            });

            // Styling Bootstrap 5
            $('.dataTables_length select')
                .addClass('form-select form-select-sm')
                .css('width', '80px');

            $('.dataTables_filter input')
                .addClass('form-control form-control-sm')
                .css({
                    'border-radius': '8px',
                    'padding': '0.5rem 1rem'
                });

            // Style header tabel
            $('#tblHistoryBarang thead th').css({
                'background-color': '#4a5568',
                'color': 'white',
                'font-weight': '600',
                'border': 'none'
            });

            // Hover effect baris
            $('#tblHistoryBarang tbody tr').hover(
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
    </script>
@endsection
