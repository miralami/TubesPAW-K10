{{-- resources/views/admin/products/_form.blade.php --}}
@php
    // cek apakah kita di mode edit atau create
    $isEdit = isset($product);
@endphp

<div class="modal-content">
  <form action="{{ $action }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
      @method('PUT')
    @endif

    <div class="modal-header">
      <h5 class="modal-title">
        {{ $isEdit ? 'Edit Produk' : 'Tambah Produk' }}
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
      <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $product->name ?? '') }}"
               required>
      </div>
      <div class="mb-3">
        <label>Harga</label>
        <input type="number"
               name="price"
               class="form-control"
               value="{{ old('price', $product->price ?? '') }}"
               required>
      </div>
      <div class="mb-3">
        <label>Stok</label>
        <input type="number"
               name="stock"
               class="form-control"
               value="{{ old('stock', $product->stock ?? '') }}"
               required>
      </div>
      <div class="mb-3">
        <label>Kategori</label>
        <input type="text"
               name="category"
               class="form-control"
               value="{{ old('category', $product->category ?? '') }}"
               required>
      </div>
      <div class="mb-3">
        <label>Foto Produk</label>
        <input type="file"
               name="image"
               class="form-control"
               accept="image/*">
        @if($isEdit && $product->image)
          <img src="{{ asset('storage/' . $product->image) }}"
               alt=""
               class="mt-2"
               width="100">
        @endif
      </div>
      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description"
                  class="form-control"
                  rows="3">{{ old('description', $product->description ?? '') }}</textarea>
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit"
              class="btn {{ $isEdit ? 'btn-success' : 'btn-primary' }}">
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}
      </button>
    </div>
  </form>
</div>
