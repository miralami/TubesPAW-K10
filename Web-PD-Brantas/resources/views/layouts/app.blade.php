<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PD. Brantas</title>

    {{-- Bootstrap & Bootstrap-icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>

@stack('scripts')
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top"
     style="background-color:#121212;padding:.75rem 0">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/">PD. Brantas</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center" style="gap:2rem">

                {{-- Catalog & Bantuan --}}
                <div class="d-flex align-items-center gap-4">
                    <li class="nav-item">
                        <a class="nav-link px-2 {{ request()->is('catalog') ? 'active fw-semibold' : '' }}"
                           href="{{ route('catalog.index') }}">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 {{ request()->is('bantuan') ? 'active fw-semibold' : '' }}"
                           href="{{ route('help') }}">Bantuan</a>
                    </li>
                </div>

                {{-- Riwayat Transaksi (Ikon), Cart, Profil / Login --}}
                <div class="d-flex align-items-center gap-3 ps-4 border-start border-secondary-subtle">
                    @auth
                    {{-- Ikon Riwayat Transaksi --}}
                    <li class="nav-item">
                        <a class="nav-link px-2 position-relative {{ request()->is('riwayat-transaksi') ? 'active fw-semibold' : '' }}"
                           href="{{ route('transactions.riwayat') }}" title="Riwayat Transaksi">
                            <i class="bi bi-journal-text fs-5"></i>
                        </a>
                    </li>

                    {{-- Ikon Cart --}}
                    <li class="nav-item">
                        <a class="nav-link px-2 position-relative {{ request()->is('cart') ? 'active fw-semibold' : '' }}"
                           href="{{ route('cart.view') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                        </a>
                    </li>
                    @endauth

                    {{-- Profil / Login --}}
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::user()->profile_picture && file_exists(public_path('storage/' . Auth::user()->profile_picture)))
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 8px;">
                                @else
                                    <div style="width: 40px; height: 40px; background-color: #ccc; border-radius: 50%; margin-right: 8px;"></div>
                                @endif
                                {{ Str::limit(Auth::user()->name, 12) }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Menu</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><span class="dropdown-item-text fw-semibold">{{ Auth::user()->name }}</span></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="px-3">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm px-3" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </div>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; {{ date('Y') }} PD. Brantas. All Rights Reserved.
</footer>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success') || session('error'))
    <div id="snackbar" class="snackbar {{ session('success') ? 'snackbar-success' : 'snackbar-error' }}">
        {{ session('success') ?? session('error') }}
    </div>
    <script>
        const s=document.getElementById('snackbar');
        if(s){s.classList.add('show');setTimeout(()=>s.classList.remove('show'),3000);}
    </script>
    <style>
        .snackbar {
            visibility: hidden;
            min-width: 260px;
            max-width: 90%;
            text-align: center;
            border-radius: 8px;
            padding: 14px 20px;
            position: fixed;
            left: 50%;
            top: 30px;
            transform: translateX(-50%);
            z-index: 9999;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: opacity 0.3s ease, top 0.4s ease;
            border: 2px solid transparent;
        }

        .snackbar.show {
            visibility: visible;
            opacity: 1;
            top: 50px;
        }

        .snackbar-success {
            background-color: #e6f7ec;
            color: #228c4f;
            border-color: #a3e4c1;
        }

        .snackbar-error {
            background-color: #fdecea;
            color: #d93025;
            border-color: #f5c2be;
        }
    </style>
@endif


<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>
<script>gsap.registerPlugin(ScrollTrigger);</script>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({mirror:false,delay:50,offset:120});</script>

@stack('scripts')
</body>
</html>
