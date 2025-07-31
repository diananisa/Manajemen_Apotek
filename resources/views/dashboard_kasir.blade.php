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
            <!-- <button class="navbar-toggle" type="button" data-bs-tonggle="collapse">
                <span class="navbar-toggle-icon"></span>
            </button> -->
            {{-- @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    {{ $errors->first() }}
                </div>
            @endif --}}
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_kasir') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <!-- <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li> -->
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('product.utama') }}"><i class="bi bi-box-seam me-2"></i>Product</a>
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
                {{-- NANTI DI GANTI SESUAI PENCARIAN --}}
                <form action="{{ route('dashboard_kasir') }}" method="get" class="mb-3"> <!--NATI GANTI SESUAI ui ux -->
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
            <div class="container mt-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Sales Details</h4>
                <canvas id="salesChart" height="100"></canvas>
                <div class="mt-3 d-flex justify-content-end">
                    <select class="form-select w-auto">
                        <option selected>October</option>
                        <option>September</option>
                        <option>August</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
    
        const salesData = [
            { x: 5000, y: 22 },
            { x: 10000, y: 45 },
            { x: 15000, y: 43 },
            { x: 20000, y: 100 },
            { x: 25000, y: 52 },
            { x: 30000, y: 48 },
            { x: 35000, y: 24 },
            { x: 40000, y: 47 },
            { x: 45000, y: 75 },
            { x: 50000, y: 60 },
            { x: 55000, y: 49 },
            { x: 60000, y: 55 },
        ];
    
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.map(item => item.x),
                datasets: [{
                    label: 'Sales',
                    data: salesData.map(item => item.y),
                    fill: true,
                    borderColor: 'rgba(0,123,255,1)',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    tension: 0.3,
                    pointBackgroundColor: '#007bff',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: value => value + '%'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Sales (in K)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + '%';
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
        </div>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
