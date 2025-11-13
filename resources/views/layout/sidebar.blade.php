<div id="accordion" style="margin-top: 80px;">
    <a data-bs-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne"
        class="collapsed" style="text-decoration: none">
        <div class="d-flex justify-content-between mt-3">
            <div class="d-flex align-items-center">
                <div class="text-black fw-medium">
                    <img src="{{ asset('assets/img/user.png') }}" alt="user-profile" class="rounded-circle me-2"
                        width="35" height="35" />
                    {{ Auth::User()->nama }}
                </div>
            </div>
            <div class="text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-caret-down collapse-icon" viewBox="0 0 16 16">
                    <path
                        d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659" />
                </svg>
            </div>
        </div>
    </a>
    <div class="collapse" id="collapseOne">
        <div class="p-3" style="background: none">
            <a href="{{ route('accountForm') }}" style="text-decoration: none; color: black;">Kelola Profil</a>
        </div>
    </div>
</div>
<hr>

{{-- Dashboard --}}
<div class="d-grid mb-4">
    <a href="{{ route('dashboard') }}" type="button" style="padding:10px 20px; width:100%;"
        class="btn {{ ($link ?? '') === 'dashboard' ? 'btn-danger' : 'btn-light' }} 
        btn-block rounded d-flex align-items-center justify-content-start">
        <i class="bi bi-speedometer2 fs-6 me-2 fw-bold"></i>
        <span class="fs-6">Dashboard</span>
    </a>
</div>

{{-- Barang Masuk --}}
<div class="d-grid mb-4">
    <a href="{{ route('barang-masuk.index') }}" type="button" style="padding:10px 20px; width:100%;"
        class="btn {{ ($link ?? '') === 'barangMasuk' ? 'btn-danger' : 'btn-light' }} 
        btn-block rounded d-flex align-items-center justify-content-start">
        <i class="bi bi-box-seam fs-6 me-2 fw-bold"></i>
        <span class="fs-6">Barang Masuk</span>
    </a>
</div>

{{-- Barang Keluar --}}
<div class="d-grid mb-4">
    <a href="{{ route('barang-keluar.index') }}" type="button" style="padding:10px 20px; width:100%;"
        class="btn {{ ($link ?? '') === 'barangKeluar' ? 'btn-danger' : 'btn-light' }} 
        btn-block rounded d-flex align-items-center justify-content-start">
        <i class="bi bi-bag-check fs-6 me-2 fw-bold"></i>
        <span class="fs-6">Barang Keluar</span>
    </a>
</div>

{{-- History Barang --}}
<div class="d-grid mb-4">
    <a href="{{ route('historyBarang') }}" type="button" style="padding:10px 20px; width:100%;"
        class="btn {{ ($link ?? '') === 'historyBarang' ? 'btn-danger' : 'btn-light' }} 
        btn-block rounded d-flex align-items-center justify-content-start">
        <i class="bi bi-clock-history fs-6 me-2 fw-bold"></i>
        <span class="fs-6">History Barang</span>
    </a>
</div>

<div class="d-grid">
    <a class="text-decoration-none" href="/logout">
        <button type="button" class="learn-more btn btn-secondary btn-block w-100">
            <span class="circle" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-box-arrow-right" viewBox="0 0 16 16" style="color: white;">
                    <path fill-rule="evenodd"
                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                    <path fill-rule="evenodd"
                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
            </span>
            <span class="button-text fw-semibold">Logout</span>
        </button>
    </a>
</div>
