<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
            font-weight: bold;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar p-0">
    <div class="d-flex flex-column h-100">
        <div class="pt-3 px-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
                        Transaksi
                    </a>
                </li>
            </ul>
        </div>

        <!-- Spacer -->
        <div class="mt-auto p-3 border-top">
            <a href="{{ route('landing.index') }}" class="btn btn-outline-light btn-sm w-100 mb-2">← Ke Landing Page</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
            </form>
        </div>
    </div>
</nav>


        <!-- Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap JS CDN -->

</body>
</html>
