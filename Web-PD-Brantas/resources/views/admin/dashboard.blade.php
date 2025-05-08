@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Selamat Datang, Admin!</h1>
        <p class="lead">Ini adalah area admin untuk mengelola produk, pengguna, dan data penting lainnya.</p>

        <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text">{{ $productCount }} produk</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pengguna Terdaftar</h5>
                    <p class="card-text">{{ $userCount }} pengguna</p>
                </div>
            </div>
        </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan Hari Ini</h5>
                        <p class="card-text">8 pesanan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
