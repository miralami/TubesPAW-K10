@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Daftar Transaksi</h2>
    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary mb-3">Buat Transaksi Baru</a>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
      <thead>
        <tr><th>ID</th><th>Produk</th><th>Qty</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        @forelse($transactions as $t)
        <tr>
          <td>{{ $t->id }}</td>
          <td>{{ $t->product->name }}</td>
          <td>{{ $t->quantity }}</td>
          <td>Rp{{ number_format($t->total_price,0,',','.') }}</td>
          <td>{{ $t->status }}</td>
          <td>
            <a href="{{ route('admin.transactions.show',$t->id) }}" class="btn btn-info btn-sm">Lihat</a>
            <a href="{{ route('admin.transactions.edit',$t->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('admin.transactions.destroy',$t->id) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6">Belum ada transaksi.</td></tr>
        @endforelse
      </tbody>
    </table>
</div>
@endsection
