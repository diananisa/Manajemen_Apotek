<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
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
                    <a class="nav-link text-dark" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('presensi.store') }}"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Konten Success --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="alert alert-success text-center">
                <h4 class="mb-3"><i class="bi bi-check-circle-fill"></i> Pembayaran Berhasil!</h4>
                <p>Terima kasih! Transaksi Anda telah berhasil diproses.</p>
                <a href="{{ route('product.utama') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>