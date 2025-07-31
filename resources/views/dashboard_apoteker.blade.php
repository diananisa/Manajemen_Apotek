<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
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
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_apoteker') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('product.index') }}"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('presensi.belum') }}"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
            
        </div>


        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- <h3>Dashboard</h3> -->
                     <!-- Search Form -->
                    <form action="{{ route('dashboard_apoteker') }}" method="GET" class="mb-3">
                        <div class="input-group w-400">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
    
                    <div class="nav justify-content-end">
    
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-cart3 fs-4 text-primary"></i>
                            <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                            <div>
                                <div class="fw-bold">{{ session('Username')}}</div>
                                <small class="text-muted">{{session('role')}}</small>
                            </div>
    
                        </div>
                    </div>
    
            </div>
            
              <h3>Dashboard</h3>

            {{-- Statistic Cards --}}
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Total Pelanggan</h6>
                            <h3>4,093</h3>
                            <span class="text-success small">↑ 8.5% from yesterday</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Barang Terjual</h6>
                            <h3>10,293</h3>
                            <span class="text-success small">↑ 1.3% from past week</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Total Penjualan</h6>
                            <h3>Rp259,000</h3>
                            <span class="text-danger small">↓ 4.3% from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Kadaluarsa --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Kadaluarsa</strong>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Kadaluarsa</th>
                                <th>Tanggal Masuk</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Paramex</td>
                                <td>30-07-2025</td>
                                <td>30-01-2024</td>
                                <td>10</td>
                                <td><span class="badge bg-warning text-dark">Segera Kadaluarsa</span></td>
                            </tr>
                            <tr>
                                <td>Paramex</td>
                                <td>21-07-2025</td>
                                <td>21-01-2024</td>
                                <td>20</td>
                                <td><span class="badge bg-warning text-dark">Segera Kadaluarsa</span></td>
                            </tr>
                            <tr>
                                <td>Paramex</td>
                                <td>19-06-2025</td>
                                <td>19-12-2024</td>
                                <td>10</td>
                                <td><span class="badge bg-danger">Sudah Kadaluarsa</span></td>
                            </tr>
                            <tr>
                                <td>Paramex</td>
                                <td>10-06-2025</td>
                                <td>10-12-2024</td>
                                <td>30</td>
                                <td><span class="badge bg-danger">Sudah Kadaluarsa</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
