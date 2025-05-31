@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Daftar Transaksi</h2>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary shadow-sm">
            + Transaksi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td class="align-middle">#{{ $t->id }}</td>
                            <td class="align-middle">
                                <ul class="mb-0 ps-3">
                                    @foreach($t->items as $item)
                                        <li>{{ $item->product->name }} <span class="text-muted">({{ $item->quantity }})</span></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="align-middle">Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                            <td class="align-middle">
                                @if(strtolower($t->status) === 'selesai')
                                    <span class="badge bg-success px-3 py-2">Selesai</span>
                                @elseif(strtolower($t->status) === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">{{ ucfirst($t->status) }}</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.transactions.show', $t->id) }}" class="btn btn-sm btn-outline-info">Lihat</a>
                                    <a href="{{ route('admin.transactions.edit', $t->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
