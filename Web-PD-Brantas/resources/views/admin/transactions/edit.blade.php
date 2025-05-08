@extends('layouts.admin')

@section('content')
<div class="container">
  <h2>Edit Transaksi #{{ $transaction->id }}</h2>
  <form action="{{ route('transactions.update',$transaction->id) }}" method="POST">
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
      <input type="text" name="status" class="form-control"
             value="{{ $transaction->status }}" required>
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
</div>
@endsection
