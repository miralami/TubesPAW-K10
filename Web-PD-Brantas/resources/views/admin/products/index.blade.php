@extends('layouts.admin')

@section('title', 'Product')

@push('styles')
<style>
    /* utilitas warna badge transparan ala dashboard */
    .bg-primary-soft   {background:rgba(13,110,253,.15);}
    .bg-success-soft   {background:rgba(25,135,84,.15);}
    .bg-warning-soft   {background:rgba(255,193,7,.15);}
    .bg-danger-soft    {background:rgba(220,53,69,.15);}
    .card-stat .icon   {width:38px;height:38px}
    .table tbody tr:hover{background:#fafbff}
</style>
@endpush

@section('content')
<div class="content-wrapper">

    {{-- ===== Header + CTA ===== --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Product</h2>
            <p class="text-muted mb-0" style="max-width:420px">
                A pharmacy purchase refers to the act of buying medications, medical supplies,
                and other healthcare-related products.
            </p>
        </div>

        <a href="#createProductModal" data-bs-toggle="modal" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Add New Product
        </a>
    </div>

    {{-- ===== Statistic cards ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-primary-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-box text-primary"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $totalProduct }}</h4>
                    </div>
                    <small class="text-muted">Total Product</small>
                    <div class="small text-success mt-1"><i class="fa fa-arrow-up"></i> +30 from last week</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-success-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-arrow-trend-up text-success"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $newProduct }}</h4>
                    </div>
                    <small class="text-muted">New Product</small>
                    <div class="small text-success mt-1">+8 from last week</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-warning-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-arrow-down-wide-short text-warning"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $lowStock }}</h4>
                    </div>
                    <small class="text-muted">Low Stock Item</small>
                    <div class="small text-success mt-1">+12 from last week</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-danger-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-xmark text-danger"></i>
                        </span>
                    </div>
                    <small class="text-muted">Out of Stock</small>
                    <div class="small text-danger mt-1">-08 from last week</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Search & filter ===== --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body pb-1">

        <form method="GET" class="row gx-3 gy-2 align-items-center mb-3">
            <div class="col-auto flex-grow-1">
                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search…">
            </div>

            <div class="col-auto">
                <select name="category"
                        class="form-select"
                        onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}"
                            @selected($cat == request('category'))>
                    {{ $cat }}
                    </option>
                @endforeach
                </select>
            </div>
            </form>

        </div>
    </div>

    {{-- ===== File import / export ===== --}}
    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center mb-3">
        @csrf
        <div class="col-auto">
            <input type="file" name="file" required class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <button class="btn btn-success btn-sm"><i class="fa fa-file-import me-1"></i>Import Excel</button>
            <a href="{{ route('admin.products.export') }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-file-export me-1"></i>Export</a>
        </div>
    </form>

    {{-- ===== Data table ===== --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:35px"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Terjual</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td><input type="checkbox" class="form-check-input"></td>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ Str::limit($p->description, 50) }}</td>
                        <td>Rp{{ number_format($p->price, 2) }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>{{ $p->category }}</td>
                        <td>
                        @if($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}"
                                alt="img"
                                width="60"
                                class="rounded">
                        @else
                            —
                        @endif
                        </td>
                        <td>{{ $p->sold }}</td>
                        <td class="text-center">
                        <a href="#editProductModal{{ $p->id }}"
                            data-bs-toggle="modal"
                            class="btn btn-sm btn-warning text-white me-1"
                            title="Edit">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $p) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Delete">
                            <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                        No products found.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} entries
                </small>

                {{ $products->links() }}
                </div>

    </div>

</div>

{{-- ===== Modal Create ===== --}}
<div class="modal fade" id="createProductModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    @include('admin.products._form', [
        'action' => route('admin.products.store'),
        'method' => 'POST',
        'product' => null
    ])
  </div>
</div>

{{-- ===== Modal Edit untuk tiap product ===== --}}
@foreach($products as $product)
  <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
      @include('admin.products._form', [
          'action'  => route('admin.products.update', $product),
          'method'  => 'PUT',
          'product' => $product
      ])
    </div>
  </div>
@endforeach

@endsection
