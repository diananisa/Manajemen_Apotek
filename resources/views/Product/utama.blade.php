<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
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
                    <a class="nav-link active text-primary fw-bold" href="#"><i class="bi bi-box-seam me-2"></i>Product</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('cart.view') }}"><i class="bi bi-cart3 me-2"></i>Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- Search Form --}}
                <form method="GET" action="{{ route('product.utama') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama obat...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('product.utama') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                        @endif
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
            <div class="container py-4">
                <h3 class="fw-bold mb-4">Products</h3>
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <img src="{{ asset('uploads/' . $product->gambar) }}" class="card-img-top" alt="{{ $product->Nama_Obat }}" style="height: 180px; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->Nama_Obat }}</h5>
                                    <p class="card-text text-primary fw-semibold">Rp. {{ number_format((float)$product->Harga_Jual, 0, ',', '.') }}/{{ $product->Jenis_Satuan }}</p>
                                    <p class="card-text text-muted">Stock: {{ $product->Jumlah }} {{ $product->Jenis_Satuan }}</p>
                                    @if($product->Jumlah > 0)
                                        <form action="{{ route('cart.add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="Id_Obat" value="{{ $product->Id_Obat }}">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary w-100" disabled>
                                            <i class="bi bi-x-circle"></i> Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>  
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
