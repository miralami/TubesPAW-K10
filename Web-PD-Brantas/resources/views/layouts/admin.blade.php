<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body{overflow-x:hidden}

    /* sidebar wrapper */
    .sidebar{
        min-height:100vh;
        background:#212529;                       /* dark slate */
        width:240px;
    }

    /* brand / header */
    .sidebar-brand{
        font-size:1.1rem;
        font-weight:600;
        letter-spacing:.5px;
        color:#fff;
        padding:1rem 1.2rem .5rem;
        display:flex;
        align-items:center;
        gap:.5rem;
    }
    .sidebar-brand i{font-size:1.2rem;color:#0d6efd}

    /* nav links */
    .sidebar .nav-link{
        color:#d9d9d9;
        padding:.65rem 1.2rem;
        font-size:.925rem;
        display:flex;
        align-items:center;
        gap:.75rem;
        border-left:3px solid transparent;
        transition:background .2s,border-color .2s;
    }
    .sidebar .nav-link:hover{
        background:#343a40;
        color:#fff;
    }
    .sidebar .nav-link.active{
        background:#343a40;
        color:#fff;
        border-color:#0d6efd;                     /* left accent */
        font-weight:600;
    }

    /* bottom area */
    .sidebar-footer{
        margin-top:auto;
        padding:1rem;
        border-top:1px solid rgba(255,255,255,.08);
    }
</style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="sidebar d-none d-md-flex flex-column p-0">
            {{-- Brand / logo --}}
            <div class="sidebar-brand">
                <i class="bi bi-speedometer2"></i> Admin Panel
            </div>

            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i> Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}"
                    href="{{ route('admin.transactions.index') }}">
                    <i class="bi bi-receipt"></i> Transaksi
                    </a>
                </li>
            </ul>

            {{-- Footer buttons --}}
            <div class="sidebar-footer">
                <a href="{{ route('landing.index') }}"
                class="btn btn-outline-light btn-sm w-100 mb-2">
                ← Ke Landing Page
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
        <!-- Content -->
        <main class="col ms-md-3 p-4">
            @yield('content')
        </main>

    </div>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
