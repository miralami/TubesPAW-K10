@extends('layouts.admin')

@section('content')
<div class="container">
  <h2>Edit Transaksi #{{ $transaction->id }}</h2>
  <form action="{{ route('admin.transactions.update',$transaction->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
      <label>Produk</label>
      <select name="product_id" class="form-control" required>
        @foreach($products as $p)
          <option value="{{ $p->id }}"
            {{ $transaction->product_id == $p->id ? 'selected' : '' }}>
            {{ $p->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="quantity" class="form-control"
             value="{{ $transaction->quantity }}" min="1" required>
    </div>
    <div class="mb-3">
      <label>Status</label>
      <select name="status" class="form-control" required>
        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>pending</option>
        <option value="dalam perjalanan" {{ $transaction->status == 'dalam perjalanan' ? 'selected' : '' }}>dalam perjalanan</option>
        <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>selesai</option>
      </select>
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
</div>
@endsection
