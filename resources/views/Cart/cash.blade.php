<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Cash</title>
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
                    <a class="nav-link active text-dark" href="{{ route('dashboard_kasir') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('Product.utama') }}"><i class="bi bi-box-seam me-2"></i>Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-cash-coin"></i> Pembayaran Tunai
                </div>
                <div class="card-body">

                    {{-- FORM 1: Hitung Kembalian --}}
                    @if(!request()->has('dibayar'))
                        <form action="{{ route('method.cash', ['kode' => $kode]) }}" method="POST">
                            @csrf

                            <div class="mb-4 text-center">
                                <img src="{{ asset('asset/cash.png') }}" alt="Cash Payment" width="250">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Pembayaran</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($total, 0, ',', '.') }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="dibayar" class="form-label fw-semibold">Jumlah Uang Dibayarkan</label>
                                <input type="number" name="dibayar" class="form-control" placeholder="Masukkan jumlah uang dari pembeli" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="bi bi-calculator"></i> Hitung Kembalian
                                </button>
                                <a href="{{ route('Cart.method') }}" class="btn btn-warning flex-fill">
                                    <i class="bi bi-repeat"></i> Ganti Payment
                                </a>
                            </div>
                        </form>

                    @else
                        {{-- FORM 2: Tampilkan hasil dan checkout --}}
                        @php
                            $dibayar = intval(request('dibayar'));
                            $kembalian = $dibayar - $total;
                        @endphp

                        <div class="mb-4 text-center">
                            <img src="{{ asset('asset/cash.png') }}" alt="Cash Payment" width="250">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Pembayaran</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($total, 0, ',', '.') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Uang Dibayarkan</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($dibayar, 0, ',', '.') }}" readonly>
                        </div>

                        <div class="mt-3 alert {{ $kembalian < 0 ? 'alert-danger' : 'alert-success' }}">
                            <h5 class="mb-0">
                                Kembalian: 
                                <strong>
                                    Rp {{ $kembalian >= 0 ? number_format($kembalian, 0, ',', '.') : '0' }}
                                </strong>
                            </h5>
                            @if ($kembalian < 0)
                                <small>Uang dibayar kurang dari total belanja!</small>
                            @endif
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('method.cash', ['kode' => $kode]) }}" class="btn btn-warning flex-fill">
                                <i class="bi bi-pencil"></i> Ubah Jumlah Uang
                            </a>

                            @if ($kembalian >= 0)
                                {{-- FORM 3: Checkout --}}
                                <form action="{{ route('checkout') }}" method="POST" class="flex-fill">
                                    @csrf
                                    <input type="hidden" name="metode" value="cash">
                                    <input type="hidden" name="kode" value="{{ $kode }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-cash-coin"></i> Bayar Sekarang
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
<script src="{{ asset('js/dashboard_kasir.js') }}"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
