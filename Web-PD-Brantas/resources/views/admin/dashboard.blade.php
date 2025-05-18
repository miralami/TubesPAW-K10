@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Greeting --}}
    <h2 class="fw-bold mb-1">Selamat Datang, Admin!</h2>
    <p class="text-muted mb-4">Kelola produk, pengguna & pesanan melalui panel di bawah.</p>

    {{-- Stat cards --}}
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-primary p-3"><i class="bi bi-box-seam fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Total Produk</h6>
                        <h4 class="fw-bold mb-0">{{ $productCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-success p-3"><i class="bi bi-people fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Pengguna Terdaftar</h6>
                        <h4 class="fw-bold mb-0">{{ $userCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-warning p-3"><i class="bi bi-receipt fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Pesanan Hari Ini</h6>
                        {{-- <h4 class="fw-bold mb-0">{{ $todayOrders }}</h4> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Weather widget (lokasi user) sudah ditampilkan di atas otomatis --}}

    {{-- Quick-links  --}}
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-plus-lg display-6 text-primary mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Tambah Produk</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-clock-history display-6 text-success mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Riwayat Pesanan</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.akun.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-person-check display-6 text-info mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Kelola Pengguna</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('help') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-question-circle display-6 text-warning mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Pusat Bantuan</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
