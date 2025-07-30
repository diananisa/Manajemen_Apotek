<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker - QRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Sidebar --}}
        <div class="col-md-2 bg-white border-end p-3">
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-primary fw-bold" href="#"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('presensi.store') }}"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Konten --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="{{ route('presensi.index') }}" method="GET" class="mb-3">
                    <div class="input-group w-400">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">Dinda</div>
                        <small class="text-muted">Apoteker</small>
                    </div>
                </div>
            </div>

            {{-- QRIS Image & Button --}}
            <div class="row mb-5 g-2">
                <div class="text-center mb-4">
                    <img src="{{ asset('asset/Group 17.png') }}" alt="QRIS" width="350">
                    <p class="mt-3 text-muted">Silakan scan QR untuk menyelesaikan pembayaran</p>
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
                        <input type="hidden" name="metode" value="qris">
                        <input type="hidden" name="kode" value="{{ $kode }}">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Payment Berhasil
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>