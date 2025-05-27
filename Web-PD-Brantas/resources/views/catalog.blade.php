@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5">Product Catalog</h2>

    <div class="row">
        {{-- ===== Sidebar Search & Filter ===== --}}
        <aside class="col-lg-3 mb-4">
            <form action="{{ route('catalog.index') }}" method="GET" class="card shadow-sm p-3">
                {{-- Search --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="q" class="form-control"
                           value="{{ request('q') }}" placeholder="Cari produk…">
                </div>

                {{-- Filter kategori --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>

                    <select name="category" class="form-select">
                        <option value="">Semua</option>
                        @foreach($categories as $cat)   {{-- ← pakai $categories dari controller --}}
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected':'' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Filter harga --}}


                <button class="btn btn-primary w-100">Terapkan</button>
            </form>
        </aside>

        {{-- ===== Grid Produk ===== --}}
        <section class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3"> {{-- 2 ▸ 3 ▸ 4 kolom --}}
                    <div class="card h-100 shadow-sm position-relative" data-aos="zoom-in"
                        data-aos-delay="{{ $loop->index * 60 }}">

                        {{-- badge kategori di pojok kiri-atas --}}
                        <span class="badge bg-secondary position-absolute top-0 start-0 m-2">
                            {{ $product->category }}
                        </span>

                        {{-- gambar --}}
                        <div style="height: 180px; overflow: hidden">
                            <img src="{{ asset($product->image) }}"
                                class="w-100 h-100 object-fit-cover"
                                alt="{{ $product->name }}">
                        </div>


                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title mb-1">{{ $product->name }}</h6>

                            <small class="d-block mb-2 text-muted">
                                {{ Str::limit($product->description, 60) }}
                            </small>

                            <p class="fw-semibold text-primary mb-2">
                                Rp{{ number_format($product->price,0,',','.') }}
                            </p>

                            {{-- info stok & sold --}}
                            <small class="text-muted mb-3">
                                Stok: {{ $product->stock }} |
                                Terjual: {{ $product->sold }}
                            </small>

                            <a href="{{ route('products.show', $product->id) }}"
                            class="btn btn-sm btn-outline-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-muted">Tidak ada produk ditemukan.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
