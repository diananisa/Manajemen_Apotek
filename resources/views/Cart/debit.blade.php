<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker - QRIS</title>
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
                    <a class="nav-link text-dark" href="{{ route('product.utama') }}"><i class="bi bi-box-seam me-2"></i>Product</a>
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
                <div class="d-flex align-items-center gap-3">
                    <a href="#"
                        class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart3 fs-4"></i>
                    </a>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">{{ session('Username') }}</div>
                        <small class="text-muted">{{ session('role') }}</small>
                    </div>
                </div>
            </div>

            <div style="height: 80px;"></div>

            {{-- DEBIT Image & Button --}}
            <div class="row mb-5 g-2">
                <div class="card shadow-sm border-0 mx-auto rounded-4" 
                    style="max-width: 100%; width: 100%; max-width: 500px; border-radius: 2rem !important;">
                    <div class="card-body text-center">
                        <img src="{{ asset('asset/debit1.png') }}" alt="Debit" 
                            class="img-fluid mb-3 rounded-3" 
                            style="max-width: 350px; width: 100%; height: auto;">
                        <p class="text-muted mb-0">
                            Silakan gunakan kartu debit anda untuk menyelesaikan pembayaran
                        </p>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-4 mt-4">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('cart.view') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    {{-- Ganti Metode --}}
                    <a href="{{ route('Cart.method') }}" class="btn btn-warning">
                        <i class="bi bi-repeat"></i> Ganti Payment
                    </a>

                    {{-- Payment Berhasil --}}
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="metode" value="debit">
                        <input type="hidden" name="kode" value="{{ $kode }}">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Payment Berhasil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('js/topsidebar.js') }}"></script>
<script src="{{ asset('js/dashboard_kasir.js') }}"></script>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>