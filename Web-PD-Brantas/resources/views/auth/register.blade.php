@extends('layouts.app')

@section('title', 'Register')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
    body {
        background-color: #0f2c59;
        min-height: 100vh;
    }

    .auth-card {
        max-width: 420px;
        width: 100%;
        backdrop-filter: blur(4px);
        background-color: rgba(248, 250, 252, 0.85);
        border-radius: 10px;
    }

    .btn-custom-register {
        background-color: #20B2AA;
        color: white;
        border: none;
    }

    .btn-custom-register:hover {
        background-color: #199e97;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height:80vh">
    <div class="card shadow-lg auth-card p-4" data-aos="zoom-in">
        <h3 class="text-center fw-bold mb-4">Register</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}

            @error('g-recaptcha-response')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-custom-register w-100">
                Daftar
            </button>
        </form>

        <div class="text-center small mt-3">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-semibold">Login di sini</a>
        </div>
    </div>
</div>
@endsection
