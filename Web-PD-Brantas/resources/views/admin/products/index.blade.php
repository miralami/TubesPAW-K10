@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Produk</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah Produk --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
        Tambah Produk
    </button>

    {{-- Tombol Import dan Export --}}
    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 mb-3">
        @csrf
        <input type="file" name="file" required class="form-control" style="max-width: 300px;">
        <button class="btn btn-success">Import Excel</button>
        <a href="{{ route('admin.products.export') }}" class="btn btn-secondary">Export Excel</a>
    </form>

    {{-- Tabel Produk --}}
    <table class="table table-bordered table-hover table-rounded shadow-sm">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($products->count())
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category }}</td>
                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" width="80"></td>
                <td>{{ $product->description }}</td>
                <td>
                    <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">Edit</button>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            {{-- Modal Edit --}}
            <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Produk</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Harga</label>
                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Stok</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Kategori</label>
                                    <input type="text" name="category" class="form-control" value="{{ $product->category }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Foto Produk</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label>Deskripsi</label>
                                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

{{-- Modal Tambah Produk --}}
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="{{ route('admin.products.store') }}" method="POST" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Foto Produk</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="category" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
