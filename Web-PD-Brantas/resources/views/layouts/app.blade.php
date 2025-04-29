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
<nav id="nav" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-light" href="/">PD. Brantas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('catalog.index') }}">Catalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('cart.view') }}">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Login (Coming Soon)</a>
                </li>
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
