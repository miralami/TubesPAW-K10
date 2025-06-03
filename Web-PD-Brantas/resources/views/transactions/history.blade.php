@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="mb-4">Riwayat Transaksi Anda</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($transactions->isEmpty())
        <p>Anda belum memiliki transaksi.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>
                                @foreach($transaction->items as $item)
                                    {{ $item->product->name ?? '-' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($transaction->items as $item)
                                    {{ $item->quantity }}<br>
                                @endforeach
                            </td>
                            <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $status = strtolower($transaction->status);
                                    $badgeClass = match($status) {
                                        'selesai' => 'success',
                                        'pending' => 'warning',
                                        'dalam perjalanan' => 'info',
                                        'dibatalkan' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection