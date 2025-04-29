<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - PD. Brantas</title>
    <link href="https:
</head>
<body>
<div class="d-flex" style="min-height: 100vh;">
    <nav class="bg-primary text-white p-3" style="width: 250px;">
        <h4>Admin Panel</h4>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="/admin" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link text-white">Kelola Produk</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light mt-3 w-100">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>
<script src="https:
</body>
</html>
