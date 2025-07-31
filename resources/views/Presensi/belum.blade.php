<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a class="nav-link active text-primary fw-bold" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('product.index') }}"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('presensi.index') }}"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

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
                        <div class="fw-bold">{{ session('Username')}}</div>
                        <small class="text-muted">{{session('role')}}</small>
                    </div>
                </div>
            </div>

            {{-- Notifikasi Presensi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-5 g-2">
                <form action="{{ route('presensi.store') }}" method="POST" class="d-inline">
                    @csrf
                    <div class="text-center mt-5">
                        <h4 class="text-danger fw-bold">Anda Belum Presensi</h4>
                        <img src="{{ asset('asset/checklist.png') }}" width="250" class="my-6"><br>
                        <a href="{{ route('presensi.belum') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">Presensi</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
