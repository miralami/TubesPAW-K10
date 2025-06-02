@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Greeting --}}
    <h2 class="fw-bold mb-1">Selamat Datang, Admin!</h2>
    <p class="text-muted mb-4">Kelola produk, pengguna & pesanan melalui panel di bawah.</p>

    {{-- Stat cards --}}
    <div class="row g-4 mb-4">
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

        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="badge bg-warning p-3"><i class="bi bi-receipt fs-5"></i></span>
                    <div>
                        <h6 class="mb-0">Pesanan Hari Ini</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Total Terjual --}}
  <div class="col-sm-6 col-lg-4">
    <div class="card shadow-sm border-0">
      <div class="card-body d-flex align-items-center gap-3">
        <span class="badge bg-info p-3"><i class="bi bi-bar-chart fs-5"></i></span>
        <div>
          <h6 class="mb-0">Total Terjual</h6>
          <h4 class="fw-bold mb-0">{{ $soldCount }}</h4>
        </div>
      </div>
    </div>
  </div>

    {{-- Top 5 Produk Terlaris --}}
    <div class="col-sm-6 col-lg-4">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
        <h6 class="mb-3">Top 5 Produk Terlaris</h6>
        <canvas id="topProductsChart" style="height:200px"></canvas>
        </div>
    </div>
    </div>

    {{-- kartu-kartu lain: Total Produk, Pengguna, Pesanan Hari Ini --}}
    <div class="col-sm-6 col-lg-4">
        {{-- ...Total Produk... --}}
    </div>
    <div class="col-sm-6 col-lg-4">
        {{-- ...Pengguna Terdaftar... --}}
    </div>
    <div class="col-sm-6 col-lg-4">
        {{-- ...Pesanan Hari Ini... --}}
    </div>
</div>

    {{-- Weather widget (lokasi user) sudah ditampilkan di atas otomatis --}}

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
<script>
  // Ambil data dari PHP
  const labels = @json($topProducts->pluck('name'));
  const data   = @json($topProducts->pluck('sold'));

  // Dapatkan context canvas
  const ctx = document.getElementById('topProductsChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',            // bisa juga 'horizontalBar' dengan Chart.js v2
    data: {
      labels,
      datasets: [{
        label: 'Terjual',
        data,
        backgroundColor: 'rgba(13,110,253,0.6)',  // satu warna, bisa di-array kalau mau variasi
        borderColor:   'rgba(13,110,253,1)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',       // buat horizontal bar; kalau mau vertikal buang ini
      scales: {
        x: { beginAtZero: true }
      },
      plugins: {
        legend: { display: false }  // sembunyikan legenda “Terjual”
      },
      layout: {
        padding: { top: 10, right: 10, bottom: 10, left: 10 }
      }
    }
  });
</script>

@endsection
