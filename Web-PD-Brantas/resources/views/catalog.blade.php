@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Katalog --}}
    <h2 class="text-center mb-5 text-dark-custom">Product Catalog</h2>

    <div class="row">
        {{-- ===== Sidebar Search & Filter ===== --}}
        <aside class="col-lg-3 mb-4">
            <form action="{{ route('catalog.index') }}" method="GET" class="card card-filter p-3">
                {{-- Search --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="q" class="form-control"
                           value="{{ request('q') }}" placeholder="Cari produk…">
                </div>

                {{-- Filter Kategori --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected':'' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-custom-login w-100">Terapkan</button>
            </form>
        </aside>

        {{-- ===== Grid Produk ===== --}}
        <section class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product h-100 shadow-sm position-relative" data-aos="zoom-in"
                         data-aos-delay="{{ $loop->index * 60 }}">

                        {{-- Badge Kategori di pojok kiri-atas --}}
                        <span class="badge badge-cat position-absolute top-0 start-0 m-2">
                            {{ $product->category }}
                        </span>

                        {{-- Gambar Produk --}}
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="img-card"
                             alt="{{ $product->name }}">

                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title mb-1 text-dark-custom">{{ $product->name }}</h6>

                            <small class="d-block mb-2 text-muted">
                                {{ Str::limit($product->description, 60) }}
                            </small>

                            <p class="fw-semibold text-primary mb-2">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            {{-- Info stok & sold --}}
                            <small class="text-muted mb-3">
                                Stok: {{ $product->stock }} |
                                Terjual: {{ $product->sold }}
                            </small>

                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-sm btn-outline-accent mt-auto">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada produk ditemukan.</p>
                </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ mirror: false, delay: 50, offset: 120 });
</script>
@endpush
