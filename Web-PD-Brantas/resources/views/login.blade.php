@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
    .auth-card{
        max-width:420px;
        width:100%;
        backdrop-filter:blur(4px);
        background:rgba(255,255,255,.9);
    }
</style>
@endpush

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height:80vh">
    <div class="card shadow-lg auth-card p-4" data-aos="zoom-in">
        <h3 class="text-center fw-bold mb-4">Sign In</h3>

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

            <button type="submit" class="btn btn-primary w-100">
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
