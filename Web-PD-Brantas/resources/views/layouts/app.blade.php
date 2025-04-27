<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --brantas-navy: #0d1a3f;
            --brantas-light: #f5f7fa;
        }
        .sidebar {
            background-color: var(--brantas-navy);
            color: white;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
        .uk-card {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .uk-card:hover {
            transform: scale(1.02);
        }
        img {
            border-radius: 4px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3 d-flex flex-column">
        <div class="text-center mb-4">
            <img src="LOGO_URL_KAMU" alt="PD Brantas" style="max-width: 80px;">
            <h4 class="mt-2">PD Brantas</h4>
        </div>

        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-2">
                <div class="text-uppercase fw-bold">Manajemen</div>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="#"><i class="bi bi-house-door"></i> Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-grid"></i> Produk</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link" href="#"><i class="bi bi-clock-history"></i> Transaksi</a>
            </li>
        </ul>

        <div class="mt-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i> Sign Out</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
