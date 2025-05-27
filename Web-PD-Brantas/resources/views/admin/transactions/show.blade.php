@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="mx-auto shadow rounded" style="max-width: 500px;">
        <div class="border-bottom d-flex justify-content-between align-items-center px-4 py-3">
            <h5 class="mb-0">Detail Transaksi #{{ $transaction->id }}</h5>
            <a href="{{ route('admin.transactions.index') }}" class="btn-close" aria-label="Close"></a>
        </div>
        <div class="px-4 py-3">
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Produk</span>
                    <span>{{ $transaction->product->name }}</span>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Jumlah</span>
                    <span>{{ $transaction->quantity }}</span>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Total Harga</span>
                    <span class="fw-semibold">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <span>{{ $transaction->status }}</span>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Tanggal</span>
                    <span>{{ $transaction->created_at->format('d-m-Y H:i') }}</span>
                </div>
            </div>
        </div>
        <div class="border-top text-center px-4 py-3">
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
