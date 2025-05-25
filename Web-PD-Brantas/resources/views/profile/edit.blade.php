@extends('layouts.app')   {{-- atau layouts.admin, sesuaikan --}}
@section('title', 'Edit Profil')

@section('content')
<div class="container py-5" style="max-width:640px">
    <h2 class="mb-4 fw-semibold">Edit Profil</h2>

    {{-- tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST"
      enctype="multipart/form-data"
      class="card-profile" style="max-width:640px">
    @csrf
    @method('PUT')

    <div class="card-body p-4">

        {{-- Nama --}}
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name"
                   value="{{ old('name', Auth::user()->name) }}"
                   class="form-control @error('name') is-invalid @enderror" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   value="{{ old('email', Auth::user()->email) }}"
                   class="form-control @error('email') is-invalid @enderror" required>
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="address"
                   value="{{ old('address', Auth::user()->address) }}"
                   class="form-control @error('email') is-invalid @enderror" required>
        </div>
        
        {{-- Password Baru --}}
        <div class="mb-3">
            <label class="form-label">Password Baru
                <span class="text-muted">(kosongkan jika tidak mengganti)</span>
            </label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   autocomplete="new-password">
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">← Batal</a>
            <button type="submit" class="btn btn-primary px-4">Simpan</button>
        </div>
    </div>
</form>

</div>
@endsection
