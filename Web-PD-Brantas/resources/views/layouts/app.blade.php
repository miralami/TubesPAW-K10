<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>PD. Brantas</title>

    {{-- Bootstrap & Bootstrap-icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>

    {{-- Styles utama, termasuk seluruh CSS yang sudah kita update --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    <nav id="nav" class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/">PD. Brantas</a>
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
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

                    {{-- Riwayat Transaksi, Cart, Profil / Login --}}
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
                                <a class="nav-link dropdown-toggle d-flex align-items-center px-2"
                                   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->profile_picture && file_exists(public_path('storage/' . Auth::user()->profile_picture)))
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                             class="profile-img" alt="Profile">
                                    @else
                                        <div class="profile-placeholder"></div>
                                    @endif
                                    {{ Str::limit(Auth::user()->name, 12) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(Auth::user()->role === 'admin')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Menu</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <span class="dropdown-item-text fw-semibold">{{ Auth::user()->name }}</span>
                                    </li>
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
                                <a class="btn btn-custom-login btn-sm px-3" href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>
                        @endauth
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="container-fluid px-0">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        &copy; {{ date('Y') }} PD. Brantas. All Rights Reserved.
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('success') || session('error'))
        <div id="snackbar" class="snackbar {{ session('success') ? 'snackbar-success' : 'snackbar-error' }}">
            {{ session('success') ?? session('error') }}
        </div>
        <script>
            const s = document.getElementById('snackbar');
            if (s) {
                s.classList.add('show');
                setTimeout(() => s.classList.remove('show'), 3000);
            }
        </script>
    @endif

    <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
    <script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>
    <script>gsap.registerPlugin(ScrollTrigger);</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init({ mirror: false, delay: 50, offset: 120 });</script>

    <script>
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      document.body.classList.add('scrolled');
    } else {
      document.body.classList.remove('scrolled');
    }
  });
</script>

    @stack('scripts')
</body>
</html>
