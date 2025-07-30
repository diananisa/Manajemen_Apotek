<!-- resources/views/Cart/cash.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Cash</title>
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

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <h3 class="mb-4">Pembayaran Cash</h3>

            {{-- FORM 1: Hitung Kembalian --}}
            @if(!request()->has('dibayar'))
                <form action="{{ route('method.cash', ['kode' => $kode]) }}" method="POST">
                    @csrf

                    <div class="mb-4 text-center">
                        <img src="{{ asset('asset/cash.png') }}" alt="Cash Payment" width="300">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Pembayaran</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($total, 0, ',', '.') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="dibayar" class="form-label fw-semibold">Jumlah Uang Dibayarkan</label>
                        <input type="number" name="dibayar" class="form-control" placeholder="Masukkan jumlah uang dari pembeli" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Hitung Kembalian</button>

                    {{-- Ganti Metode --}}
                    <a href="{{ route('Cart.method') }}" class="btn btn-warning">
                        <i class="bi bi-repeat"></i> Ganti Payment
                    </a>
                </form>

            @else
                {{-- FORM 2: Tampilkan hasil dan checkout --}}
                @php
                    $dibayar = intval(request('dibayar'));
                    $kembalian = $dibayar - $total;
                @endphp

                <div class="mb-4 text-center">
                    <img src="{{ asset('asset/cash.png') }}" alt="Cash Payment" width="300">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Total Pembayaran</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($total, 0, ',', '.') }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jumlah Uang Dibayarkan</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($dibayar, 0, ',', '.') }}" readonly>
                </div>

                <div class="mt-3">
                    <h5>Kembalian:
                        <strong>
                            Rp {{ $kembalian >= 0 ? number_format($kembalian, 0, ',', '.') : '0' }}
                        </strong>
                    </h5>

                    @if ($kembalian < 0)
                        <div class="text-danger">Uang dibayar kurang dari total belanja!</div>
                    @endif
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('method.cash', ['kode' => $kode]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Ubah Jumlah Uang
                    </a>

                    @if ($kembalian >= 0)
                        {{-- FORM 3: Checkout --}}
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="metode" value="cash">
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-cash-coin"></i> Bayar Sekarang
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
