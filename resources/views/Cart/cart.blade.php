<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_kasir') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#">
                        <i class="bi bi-box-seam me-2"></i>Product Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        <i class="bi bi-clipboard-check me-2"></i>Presensi
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- Form Pencarian --}}
                <form action="{{ route('product.utama') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group w-400">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                {{-- Profil --}}
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">{{ session('Username') }}</div>
                        <small class="text-muted">{{ session('role') }}</small>
                    </div>
                </div>
            </div>

            <h3>Keranjang Belanja</h3>

            @if(isset($cart) && count($cart) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($cart as $Id_Obat => $item)
                    @php
                        $hargaSatuan = is_numeric($item['Total_Harga']) ? $item['Total_Harga'] : 0;
                        $jumlah = is_numeric($item['quantity']) ? $item['quantity'] : 0;
                        $totalHarga = $hargaSatuan * $jumlah;
                        $grandTotal += $totalHarga;
                    @endphp
                    <tr>
                        <td>{{ $item['Nama_Obat'] }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Keseluruhan</strong></td>
                    <td><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>

            </table>
            @else
                <div class="alert alert-info">
                    Keranjang masih kosong.
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <a href="{{ route('product.utama') }}" class="btn btn-secondary"><- Kembali</a>
                <a href="{{ route('Cart.method') }}">
                    {{-- @csrf --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </a>
                {{-- <form action="{{ route('product.destroy', $product->Id_Obat) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')"> --}}

            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
