@extends('layout.app', ['hideNavAndFooter' => false, 'showSidebar' => true])

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body text-center p-4">
                <h3>Halaman Kelola Profil</h3>
                <span class="text-secondary">Silahkan ubah akun datamu ya..</span>
            </div>
        </div>
        @include('partial.NotifMessages')
        <div class="card shadow">
            <div class="card-body">
                @foreach ($users as $profile)
                    <form action="{{ route('account.edit', $profile->id_users) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 mt-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $profile->nama }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $profile->email }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Kata Sandi</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="*************">
                            </div>
                        </div>
                        <div class="mb-3 mt-3 row">
                            <label for="telp" class="col-sm-2 col-form-label">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="telp" name="no_telp"
                                    placeholder="08xxxxxxxxx" pattern="[0-9]+" inputmode="numeric">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select id="role" name="role" class="form-select" required>
                                    <option value="" disabled
                                        {{ old('role', $profile->role ?? '') === '' ? 'selected' : '' }}>
                                        -- Pilih Role --
                                    </option>
                                    <option value="admin"
                                        {{ old('role', $profile->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user"
                                        {{ old('role', $profile->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary btn-block">Perbarui</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
