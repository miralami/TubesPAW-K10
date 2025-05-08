@extends('layouts.admin')

@section('content')
<div class="container">
  <h2>Buat Transaksi</h2>
  <form action="{{ route('admin.transactions.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Produk</label>
      <select name="product_id" class="form-control" required>
        @foreach($products as $p)
          <option value="{{ $p->id }}">{{ $p->name }} (Rp{{ number_format($p->price,0,',','.') }})</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="quantity" class="form-control" value="1" min="1" required>
    </div>
    <div class="mb-3">
      <label>Status</label>
      <input type="text" name="status" class="form-control" value="pending" required>
    </div>
    <button class="btn btn-success">Simpan</button>
  </form>
</div>
@endsection
