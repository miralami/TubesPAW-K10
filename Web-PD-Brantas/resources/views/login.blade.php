@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
    body {
        background-image: url('/images/bg.jpg'); /* Ganti dengan path gambar kamu */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 100vh;
    }

    .auth-card {
        max-width: 420px;
        width: 100%;
        backdrop-filter: blur(4px);
        background-color: rgba(248, 250, 252, 0.85); /* transparansi agar gambar terlihat */
        border-radius: 10px;
    }

    .btn-custom-login {
        background-color: #20B2AA; /* Warna mirip tombol Get Started */
        color: white;
        border: none;
    }

    .btn-custom-login:hover {
        background-color: #199e97; /* Efek hover */
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height:80vh">
    <div class="card shadow-lg auth-card p-4" data-aos="zoom-in">
        <h3 class="text-center fw-bold mb-4">Login</h3>

        {{-- flash success (mis. setelah register) --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- error list --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" required>
            </div>
            @error('g-recaptcha-response')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-custom-login w-100">
                Login
            </button>
        </form>

        <div class="text-center small">
            Belum punya akun?
            <a href="{{ route('register') }}" class="fw-semibold">Register</a>
        </div>
    </div>
</div>
@endsection
