<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel PD Brantas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="sidebar d-none d-md-flex">
            <!-- Brand -->
            <div class="sidebar-brand">
                <i class="bi bi-water"></i> PD Brantas Admin
            </div>

            <!-- Navigation -->
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
                        <i class="bi bi-receipt"></i> Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/akun*') ? 'active' : '' }}" href="{{ route('admin.akun.index') }}">
                        <i class="bi bi-people"></i> Akun
                    </a>
                </li>
            </ul>

            <!-- Profile -->
            <div class="sidebar-profile">
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Photo">
                <div class="profile-info">
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="role">{{ auth()->user()->role ?? 'Admin PD Brantas' }}</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sidebar-footer">
                <a href="{{ route('landing.index') }}" class="btn btn-outline-light btn-sm w-100 mb-2">
                    ← Ke Landing Page
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col ms-md-3 p-4">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tambahkan stack script untuk JS tambahan -->
@stack('scripts')

</body>
</html>
