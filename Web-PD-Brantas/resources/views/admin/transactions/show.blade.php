@extends('layouts.admin')

@section('content')
<div class="container">
  <h2>Detail Transaksi #{{ $transaction->id }}</h2>
  <ul>
    <li>Produk: {{ $transaction->product->name }}</li>
    <li>Jumlah: {{ $transaction->quantity }}</li>
    <li>Total Harga: Rp{{ number_format($transaction->total_price,0,',','.') }}</li>
    <li>Status: {{ $transaction->status }}</li>
    <li>Tanggal: {{ $transaction->created_at->format('d-m-Y H:i') }}</li>
  </ul>
  <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
