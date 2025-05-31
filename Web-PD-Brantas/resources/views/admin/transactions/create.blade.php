@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Transaksi</h1>

    <form action="{{ route('admin.transactions.store') }}" method="POST">
        @csrf

        <div id="items-container">
            <div class="item-row row mb-3">
                <div class="col-md-5">
                    <label>Produk</label>
                    <select name="items[0][product_id]" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Rp{{ number_format($product->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Jumlah</label>
                    <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-item">+ Tambah Produk</button>

        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" selected>pending</option>
                <option value="dalam perjalanan">dalam perjalanan</option>
                <option value="selesai">selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let index = 1;

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');
        const itemRow = document.createElement('div');
        itemRow.classList.add('item-row', 'row', 'mb-3');
        itemRow.innerHTML = `
            <div class="col-md-5">
                <select name="items[${index}][product_id]" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Rp{{ number_format($product->price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${index}][quantity]" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            </div>
        `;
        container.appendChild(itemRow);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
</script>
@endpush
