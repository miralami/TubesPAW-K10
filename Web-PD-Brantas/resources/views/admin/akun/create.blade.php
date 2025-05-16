@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Buat Akun Baru</h2>
    <form action="{{ route('admin.akun.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Peran (Role)</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="pelanggan">User</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
