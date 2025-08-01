<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                    <a class="nav-link {{ request()->routeIs('dashboard_kasir') ? 'active' : '' }}" href="{{ route('dashboard_kasir') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Product.utama') ? 'active' : '' }}" href="{{ route('Product.utama') }}">
                        <i class="bi bi-box-seam me-2"></i>Product
                    </a>
                </li>
                @php
                    use App\Http\Controllers\PresensiController;
                    $statusKehadiran = app(PresensiController::class)->cekStatusHariIni();
                @endphp

                <li class="nav-item">
                    @if($statusKehadiran === 'Tidak Hadir' || $statusKehadiran === null)
                        <a class="nav-link {{ request()->routeIs('Presensi.kasir.belum') ? 'active' : '' }}"
                        href="{{ route('Presensi.kasir.belum') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Presensi
                        </a>
                    @else
                        <a class="nav-link {{ request()->routeIs('Presensi.kasir.sudah') ? 'active' : '' }}"
                        href="{{ route('Presensi.kasir.sudah') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Presensi
                        </a>
                    @endif
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

            <div style="height: 80px;"></div>

            {{-- Konten Success --}}
                <div class="d-flex justify-content-center mt-5">
                <div class="col-md-8 col-lg-6">
                    <div class="alert alert-success text-center shadow-sm p-5 rounded-4">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Pembayaran Berhasil!</h4>
                        <p class="text-muted">Terima kasih! Transaksi Anda telah berhasil diproses.</p>

                        <a href="{{ route('cart.reset') }}" class="btn btn-primary mt-3 rounded-pill px-4">
                            <i class="bi bi-arrow-left-circle"></i> Kembali ke Halaman Utama
                        </a>

                        <a href="{{ route('print.pdf', ['kode' => session('kode_transaksi')]) }}"
                        class="btn btn-outline-secondary mt-2 rounded-pill px-4" target="_blank">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>