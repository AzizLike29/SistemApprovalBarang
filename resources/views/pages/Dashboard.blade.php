@extends('layout.app', ['hideNavAndFooter' => false, 'showSidebar' => true])

@section('title', 'Dashboard')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Dashboard</h2>
                <p class="text-muted">Halo, Selamat datang 👋</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Total Barang -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-box-seam text-primary fs-2"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Barang</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalBarang ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Semua item dalam sistem
                        </small>
                    </div>
                </div>
            </div>

            <!-- Barang Belum Approve -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-hourglass-split text-warning fs-2"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Belum Approve</h6>
                                <h3 class="mb-0 fw-bold">{{ $belumApprove ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                        <small class="text-muted">
                            <i class="bi bi-clock-history me-1"></i>
                            Menunggu persetujuan
                        </small>
                    </div>
                </div>
            </div>

            <!-- Barang Sudah Approve -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-check-circle text-success fs-2"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Sudah Approve</h6>
                                <h3 class="mb-0 fw-bold">{{ $sudahApprove ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                        <small class="text-muted">
                            <i class="bi bi-check-all me-1"></i>
                            Telah disetujui
                        </small>
                    </div>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-exclamation-triangle text-danger fs-2"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Stok Menipis</h6>
                                <h3 class="mb-0 fw-bold">{{ $stokMenipis ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                        <small class="text-muted">
                            <i class="bi bi-arrow-down-circle me-1"></i>
                            Perlu restock segera
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Aksi Cepat (Coming Soon)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Barang
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-list-ul me-2"></i>Lihat Semua Barang
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-clock me-2"></i>Pending Approval
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Stok Menipis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.3s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        });
    </script>
@endsection
