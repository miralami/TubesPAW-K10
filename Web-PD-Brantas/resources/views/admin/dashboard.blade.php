@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Greeting --}}
    <h2 class="fw-bold mb-1">Selamat Datang, Admin!</h2>
    <p class="text-muted mb-4">Kelola produk, pengguna & pesanan melalui panel di bawah.</p>

    {{-- Stat cards + gabungan Total Terjual & Top 5 Produk Terlaris --}}
    <div class="row g-4 mb-4">
        {{-- Total Produk --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-primary p-3"><i class="bi bi-box-seam fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Total Produk</h6>
                        <h4 class="fw-bold mb-0">{{ $productCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengguna Terdaftar --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-success p-3"><i class="bi bi-people fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Pengguna Terdaftar</h6>
                        <h4 class="fw-bold mb-0">{{ $userCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pesanan Hari Ini --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-warning p-3"><i class="bi bi-receipt fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Pesanan Hari Ini</h6>
                        <h4 class="fw-bold mb-0">{{ $todayOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gabungan Total Terjual + Top 5 Produk Terlaris (menyatu) --}}
        <div class="col-sm-6 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    {{-- Bagian atas: Total Terjual --}}
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-info p-3"><i class="bi bi-bar-chart fs-5"></i></span>
                        <div>
                            <h6 class="mb-0">Total Terjual</h6>
                            <h4 class="fw-bold mb-0">{{ $soldCount }}</h4>
                        </div>
                    </div>

                    {{-- Separator --}}
                    <hr>

                    {{-- Bagian bawah: Top 5 Produk Terlaris --}}
                    <h6 class="mt-3 mb-3">Top 5 Produk Terlaris</h6>
                    <canvas id="topProductsChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- /.row --}}

    {{-- Quick-links  --}}
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-plus-lg display-6 text-primary mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Tambah Produk</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-clock-history display-6 text-success mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Riwayat Pesanan</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.akun.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-person-check display-6 text-info mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Kelola Pengguna</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('help') }}" class="text-decoration-none">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body py-4">
                        <i class="bi bi-question-circle display-6 text-warning mb-3"></i>
                        <h6 class="mb-0 fw-semibold">Pusat Bantuan</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Load Chart.js dan inisiasi Chart setelah elemen canvas ter-render --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Ambil data dari PHP
    const labels = @json($topProducts->pluck('name'));
    const data   = @json($topProducts->pluck('sold'));

    // Jika tidak ada data, hentikan
    if (labels.length === 0) {
      return;
    }

    // Dapatkan context canvas
    const ctx = document.getElementById('topProductsChart').getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Terjual',
          data,
          backgroundColor: 'rgba(13,110,253,0.6)',
          borderColor:   'rgba(13,110,253,1)',
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y',  // horizontal bar. Hapus kalau ingin vertikal
        scales: {
          x: { beginAtZero: true }
        },
        plugins: {
          legend: { display: false }
        },
        layout: {
          padding: { top: 10, right: 10, bottom: 10, left: 10 }
        }
      }
    });
  });
</script>
@endsection
