<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/topsidebar.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar bg-white">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>
            
            {{-- Menu --}}
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('dashboard_kasir') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('Product.utama') }}">
                        <i class="bi bi-box-seam me-2"></i>Product
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-primary fw-bold" href="#">
                        <i class="bi bi-clipboard-check me-2"></i>Presensi
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="main-content flex-grow-1 p-4" style="background: url('{{ asset('asset/background.png') }}') no-repeat center center / cover;">
            <!-- Top Bar -->
            <div class="top-bar d-flex justify-content-between align-items-center shadow-sm rounded-pill">

                <!-- Tombol Toggle Sidebar -->
                <button id="toggleSidebar" class="btn btn-outline-primary btn-sm me-3">
                    <i class="bi bi-list"></i>
                </button>

                <!-- User Info -->
                <div class="user-menu-wrapper d-flex align-items-center gap-3 position-relative">

                    <!-- Tombol Keranjang -->
                    <a href="{{ route('cart.view') }}"
                        class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center cart-btn">
                        <i class="bi bi-cart3 fs-4"></i>
                    </a>

                    <!-- User Info (Dropdown Toggle) -->
                    <div id="userMenuToggle" class="d-flex align-items-center gap-2" style="cursor:pointer;">
                        <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                        <div>
                            <div class="fw-bold">{{ session('Username') }}</div>
                            <small class="text-muted">{{ session('role') }}</small>
                        </div>
                        <i class="bi bi-caret-down-fill text-muted small"></i>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="user-dropdown shadow-sm rounded-3 p-2">
                        <a href="#" class="dropdown-item py-2 px-3">
                            <i class="bi bi-person me-2"></i> Profil
                        </a>
                        <a href="#" class="dropdown-item py-2 px-3">
                            <i class="bi bi-gear me-2"></i> Pengaturan
                        </a>
                        <hr class="my-1">
                        <form action="{{ route('logout') }}" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2 px-3 w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div style="height: 50px;"></div>

            {{-- Notifikasi Presensi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-5 g-2">
                <form action="{{ route('Presensi.store') }}" method="POST" class="d-inline">
                    @csrf
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                        <div class="text-center bg-white shadow-sm rounded-4 p-5" style="max-width: 500px; width: 100%;">
                            
                            <img src="{{ asset('asset/checklist.png') }}" width="180" class="mb-4">
                            
                            <h4 class="text-danger fw-bold mb-3">Anda Belum Presensi</h4>
                            <p class="text-muted mb-4">Silakan lakukan presensi untuk hari ini.</p>
                            
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('dashboard_kasir') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    Presensi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
<script src="{{ asset('js/topsidebar.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
