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

    <style>
    body { overflow-x: hidden; }

    .sidebar {
        min-height: 100vh;
        background: #212529;
        width: 240px;
        display: flex;
        flex-direction: column;
        padding: 0;
    }

    .sidebar-brand {
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: .5px;
        color: #fff;
        padding: 1rem 1.2rem .5rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .sidebar-brand i { font-size: 1.2rem; color: #0d6efd; }

    .sidebar .nav-link {
        color: #d9d9d9;
        padding: .65rem 1.2rem;
        font-size: .925rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        transition: background .2s, color .2s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }

    .sidebar .nav-link.active {
        border-left: 3px solid #0d6efd;
        font-weight: 600;
    }

    .sidebar-profile {
        margin: 1rem;
        padding: .75rem;
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(8px);
        border-radius: .5rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .sidebar-profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        filter: blur(0.5px);
    }
    .sidebar-profile .profile-info .name {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
    }
    .sidebar-profile .profile-info .role {
        font-size: .85rem;
        color: #d9d9d9;
    }

    .sidebar-footer {
        margin-top: auto;
        padding: 1rem;
        border-top: 1px solid rgba(255,255,255,.08);
    }
    </style>
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
