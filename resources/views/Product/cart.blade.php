<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="bg-light">
@csrf
<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Sidebar --}}
        
        <div class="col-md-2 bg-white border-end p-3">
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>
            <button class="navbar-toggle" type="button" data-bs-tonggle="collapse">
                <span class="navbar-toggle-icon"></span>
            </button>
            {{-- @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    {{ $errors->first() }}
                </div>
            @endif --}}
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_kasir') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- <h3>Dashboard</h3> -->
                 <!-- Search Form -->
                {{-- NANTI DI GANTI SESUAI PENCARIAN --}}
                <form action="{{ route('dashboard_kasir') }}" method="POST" class="mb-3"> <!--NATI GANTI SESUAI ui ux -->
                    <div class="input-group w-400">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">{{ session('Username')}}</div>
                        <small class="text-muted">{{session('role')}}</small>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('uploads/' . $product->gambar) }}" class="card-img-top" alt="{{ $product->Nama_Obat }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $product->Nama_Obat }}</h5>
                                <p class="text-primary mb-1">Rp. {{ number_format($product->Total_Harga, 0, ',', '.') }} / Strip</p>
                                <p class="mb-2 text-muted">Stock: {{ $product->Jumlah }} box</p>
                                <form action="#" method="POST">
                                    @csrf
                                    {{-- action disesuaikan kalau ada keranjang --}}
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                        ADD TO CART
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
