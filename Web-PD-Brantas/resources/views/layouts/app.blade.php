<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PD. Brantas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #121212; padding-top: 0.75rem; padding-bottom: 0.75rem;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/">PD. Brantas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center" style="gap: 2rem;">
                <li class="nav-item">
                    <a class="nav-link px-2 {{ request()->is('catalog') ? 'active fw-semibold' : '' }}" href="{{ route('catalog.index') }}">Catalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 {{ request()->is('cart') ? 'active fw-semibold' : '' }}" href="{{ route('cart.view') }}">Cart</a>
                </li>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link px-2 {{ request()->is('admin/dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('admin.dashboard') }}">Menu Admin</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm px-3">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm px-3" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; {{ date('Y') }} PD. Brantas. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@if(session('success'))
    <div id="snackbar" class="snackbar">
        {{ session('success') }}
    </div>

    <script>
        const snackbar = document.getElementById('snackbar');
        if (snackbar) {
            snackbar.classList.add('show');
            setTimeout(() => {
                snackbar.classList.remove('show');
            }, 3000); // hilang setelah 3 detik
        }
    </script>

    <style>
        .snackbar {
            visibility: hidden;
            min-width: 260px;
            max-width: 90%;
            background-color: #ffffff;
            color: #333;
            text-align: center;
            border-radius: 8px;
            padding: 14px 20px;
            position: fixed;
            left: 50%;
            top: 30px;
            transform: translateX(-50%);
            z-index: 9999;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            opacity: 0;
            transition: opacity 0.3s ease, top 0.4s ease;
        }

        .snackbar.show {
            visibility: visible;
            opacity: 1;
            top: 50px;
        }
    </style>
@endif


</body>
</html>

<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>
<script>
    gsap.registerPlugin(ScrollTrigger);
</script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ mirror:false, delay: 50, offset: 120 });
</script>
@stack('scripts')
