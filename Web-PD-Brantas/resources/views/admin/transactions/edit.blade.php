@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Transaksi #{{ $transaction->id }}</h2>
    
    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h5>Produk dalam Transaksi</h5>
        <div id="transaction-items">
            @foreach($transaction->items as $index => $item)
                <div class="row mb-3 align-items-end item-row">
                    <div class="col-md-6">
                        <label>Produk</label>
                        <select name="items[{{ $index }}][product_id]" class="form-control" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" {{ $item->product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah</label>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-item">Tambah Produk</button>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>pending</option>
                <option value="dalam perjalanan" {{ $transaction->status == 'dalam perjalanan' ? 'selected' : '' }}>dalam perjalanan</option>
                <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>selesai</option>
                <option value="dibatalkan" {{ $transaction->status == 'dibatalkan' ? 'selected' : '' }}>dibatalkan</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

{{-- Template item baru --}}
<template id="item-template">
    <div class="row mb-3 align-items-end item-row">
        <div class="col-md-6">
            <label>Produk</label>
            <select name="items[__index__][product_id]" class="form-control" required>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Jumlah</label>
            <input type="number" name="items[__index__][quantity]" class="form-control" value="1" min="1" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let itemIndex = {{ count($transaction->items) }};

    document.getElementById('add-item').addEventListener('click', function () {
        const template = document.getElementById('item-template').innerHTML;
        const newItem = template.replace(/__index__/g, itemIndex);
        document.getElementById('transaction-items').insertAdjacentHTML('beforeend', newItem);
        itemIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
</script>
@endpush
