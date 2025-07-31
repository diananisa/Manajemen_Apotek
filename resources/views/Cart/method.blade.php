<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <a class="nav-link active text-dark" href="{{ route('dashboard_kasir') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('product.utama') }}"><i class="bi bi-box-seam me-2"></i>Product</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="#"><i class="bi bi-cart3 me-2"></i>Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-end align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">{{ session('Username')}}</div>
                        <small class="text-muted">{{session('role')}}</small>
                    </div>
                </div>
            </div>
            <div class="row mb-5 g-2">
                <div class="container text-center">
                    <h3 class="mb-4">Pilih Metode Pembayaran</h3>
                    <div class="d-flex justify-content-center gap-4 flex-wrap">

                        {{-- Tombol QRIS --}}
                        <form action="{{ route('bayar') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="metode" value="qris">
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <button type="submit" class="btn btn-outline-primary p-4">
                                <img src="{{ asset('asset/Group 63.png') }}" width="200"><br>QRIS
                            </button>
                        </form>

                        {{-- Tombol CASH --}}
                        <form action="{{ route('bayar') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="metode" value="cash">
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <button type="submit" class="btn btn-outline-success p-4">
                                <img src="{{ asset('asset/Group 64.png') }}" width="200"><br>Cash
                            </button>
                        </form>

                        {{-- Tombol DEBIT --}}
                        <form action="{{ route('bayar') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="metode" value="debit">
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <button type="submit" class="btn btn-outline-warning p-4">
                                <img src="{{ asset('asset/debit.png') }}" width="200"><br>Debit
                            </button>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('cart.view') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <script>
                    function submitMetode(metode) {
                        document.getElementById('metodeInput').value = metode;
                        document.getElementById('formMetode').submit();
                    }
                </script>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
