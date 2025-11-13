@extends('layout.app', ['hideNavAndFooter' => true, 'showSidebar' => false, 'styleCss' => true])

@section('title', 'Halaman Register')

@section('styles')
    <style>
        #registerSection {
            background: transparent !important;
            position: relative;
            z-index: 2;
        }

        #registerSection .card {
            background: #ffffff;
        }

        #registerSection .form-control,
        #registerSection .form-select {
            height: 48px;
            border-color: #dee2e6;
            transition: all 0.3s ease;
        }

        #registerSection .form-control:focus,
        #registerSection .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }

        #registerSection .input-group-text {
            border-color: #dee2e6;
            transition: all 0.3s ease;
        }

        #registerSection .form-control:focus~.input-group-text,
        #registerSection .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        #registerSection .input-group:focus-within .input-group-text i {
            color: #0d6efd !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        #registerSection .btn-primary {
            transition: all 0.3s ease;
        }

        #registerSection .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        #registerSection .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .bg-video {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }

        .bg-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, .45),
                    rgba(0, 0, 0, .45));
        }

        @media (prefers-reduced-motion: reduce) {
            .bg-video video {
                display: none;
            }

            .bg-overlay {
                background: rgba(0, 0, 0, .15);
            }
        }

        @media (max-width: 576px) {
            #registerSection .card-body {
                padding: 2rem 1.5rem !important;
            }
        }
    </style>
@endsection

@section('content')
    {{-- VIDEO --}}
    <div class="bg-video">
        <video autoplay muted loop playsinline preload="auto" poster="{{ asset('assets/img/Logo_Mie_Sedaap.png') }}">
            <source src="{{ asset('assets/video/video-mie.mp4') }}" type="video/mp4">
        </video>
    </div>

    {{-- KONTEN --}}
    <section class="min-vh-100 d-flex align-items-center py-5 position-relative" id="registerSection">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card border-0 shadow-lg rounded-4 bg-white bg-opacity-75 backdrop-blur">
                        <div class="card-body p-4 p-md-5">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/wings.png') }}" alt="Logo Wings"
                                    style="width: 100px; height: 100px; object-fit: contain; margin-bottom: 15px;">
                                <h3 class="fw-bold text-dark mb-2">Buat Akun Baru</h3>
                                <p class="text-muted mb-0">Lengkapi formulir di bawah untuk mendaftar</p>
                            </div>

                            <!-- Form -->
                            <form id="registerForm" action="{{ route('register.action') }}" method="POST"
                                enctype="multipart/form-data" novalidate>
                                {{ csrf_field() }}

                                <div class="mb-4">
                                    <label for="nama" class="form-label fw-semibold text-dark mb-2">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0" name="nama"
                                            id="nama" placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                    <div class="invalid-feedback">Nama lengkap harus diisi.</div>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark mb-2">
                                        Alamat Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email" class="form-control border-start-0 ps-0" name="email"
                                            id="email" placeholder="johndoe@gmail.com" required>
                                    </div>
                                    <div class="invalid-feedback">Email harus valid.</div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark mb-2">
                                        Kata Sandi <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0 border-end-0 ps-0"
                                            name="password" id="password" placeholder="Minimal 8 karakter" required>
                                        <span class="input-group-text bg-light border-start-0 cursor-pointer"
                                            id="togglePassword">
                                            <i class="bi bi-eye text-muted" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">Kata sandi harus diisi minimal 8 karakter.</div>
                                    <small class="text-muted">Gunakan kombinasi huruf, angka, dan simbol</small>
                                </div>

                                <div class="mb-4">
                                    <label for="role" class="form-label fw-semibold text-dark mb-2">
                                        Role <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-shield-check text-muted"></i>
                                        </span>
                                        <select class="form-select border-start-0 ps-0" id="role" name="role"
                                            required>
                                            <option selected disabled value="">Pilih role Anda</option>
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Role harus dipilih.</div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label small text-muted" for="terms">
                                            Saya setuju dengan <a href="#"
                                                class="text-primary text-decoration-none">Syarat & Ketentuan</a>
                                            dan <a href="#" class="text-primary text-decoration-none">Kebijakan
                                                Privasi</a>
                                        </label>
                                        <div class="invalid-feedback">Anda harus menyetujui syarat dan ketentuan.</div>
                                    </div>
                                </div>

                                <div class="d-grid mb-4">
                                    <button class="btn btn-primary btn-lg py-3 fw-semibold" type="submit">
                                        <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                                    </button>
                                </div>

                                {{-- Form Login --}}
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}"
                                            class="text-primary text-decoration-none fw-semibold">
                                            Masuk di sini
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Form Validation
        (function() {
            'use strict';
            const form = document.getElementById('registerForm');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endsection
