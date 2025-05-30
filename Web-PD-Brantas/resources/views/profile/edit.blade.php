@extends('layouts.app')
@section('title', 'Edit Profil')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
    body {
        background-color: #0f2c59;
        min-height: 100vh;
    }

    .auth-card {
        max-width: 480px;
        width: 100%;
        backdrop-filter: blur(4px);
        background-color: rgba(248, 250, 252, 0.85);
        border-radius: 10px;
    }

    .btn-custom {
        background-color: #20B2AA;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #199e97;
        color: white;
    }

    .form-label {
        font-weight: 500;
    }

    .preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height:80vh">
    <div class="card shadow-lg auth-card p-4" data-aos="zoom-in">
        <h3 class="text-center fw-bold mb-4">Edit Profil</h3>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Foto Profil --}}
            <div class="text-center mb-3">
                @if(Auth::user()->profile_picture && file_exists(public_path('storage/' . Auth::user()->profile_picture)))
                    <img id="preview" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="preview-img" alt="Foto Profil">
                @else
                    <div id="preview-placeholder" class="preview-img mx-auto" style="background-color: #ccc;"></div>
                @endif
                <input type="file" name="profile_picture" id="profile_picture" class="form-control mt-2 mx-auto" style="max-width: 300px;" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                    class="form-control @error('name') is-invalid @enderror" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                    class="form-control @error('email') is-invalid @enderror" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}"
                    class="form-control @error('address') is-invalid @enderror" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru <span class="text-muted">(opsional)</span></label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-custom w-100">Simpan Perubahan</button>

            <div class="text-center mt-3">
                <a href="{{ url()->previous() }}" class="text-decoration-none small">← Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('profile_picture');
        const previewImage = document.getElementById('preview');

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImage) {
                        previewImage.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
