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

    <link href="{{ asset('css/topsidebar.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar bg-white">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>

            {{-- Menu --}}
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('dashboard_manager') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('Supplier.laporan') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('Product.laporan') }}">
                        <i class="bi bi-box-seam me-2"></i>Product Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-primary fw-bold"href="#">
                        <i class="bi bi-clipboard-check me-2"></i>Presensi
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="main-content flex-grow-1 p-4" style="background: url('{{ asset('asset/background.png') }}') no-repeat center center / cover;">
            <!-- Top Bar -->
            <div class="top-bar d-flex justify-content-between align-items-center shadow-sm rounded-pill">

                <!-- Tombol Toggle Sidebar -->
                <button id="toggleSidebar" class="btn btn-outline-primary btn-sm me-3">
                    <i class="bi bi-list"></i>
                </button>

                <!-- User Info -->
                <div class="user-menu-wrapper position-relative">
                    <div id="userMenuToggle" class="d-flex align-items-center gap-3 user-info" style="cursor:pointer;">
                        <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                        <div>
                            <div class="fw-bold">{{ session('Username') }}</div>
                            <small class="text-muted">{{ session('role') }}</small>
                        </div>
                        <i class="bi bi-caret-down-fill text-muted small"></i>
                    </div>

                    <!-- Dropdown -->
                    <div id="userDropdown" class="user-dropdown shadow-sm rounded-3 p-2">
                        <a href="#" class="dropdown-item py-2 px-3">
                            <i class="bi bi-person me-2"></i> Profil
                        </a>
                        <a href="#" class="dropdown-item py-2 px-3">
                            <i class="bi bi-gear me-2"></i> Pengaturan
                        </a>
                        <hr class="my-1">
                        <form action="{{ route('logout') }}" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2 px-3 w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div style="height: 80px;"></div>

            <div class="row mb-5 g-2">
                <form action="{{ route('Presensi.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                     @csrf
                    {{-- Filter Tipe Harian / Bulanan --}}
                    <div class="col-md-2">
                        <div class="card text-center shadow-sm p-2">
                            <select name="tipe" class="form-select">
                                <option value="harian" {{ request('tipe') == 'harian' ? 'selected' : '' }}>Harian</option>
                                <option value="bulanan" {{ request('tipe') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="col-md-2">
                        <div class="card text-center shadow-sm p-2">
                            <input type="date" name="tanggal" value="{{ request('tanggal') ?? now()->format('Y-m-d') }}" class="form-control">
                        </div>
                    </div>

                    {{-- Filter Pencarian Nama --}}
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-2">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama karyawan..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}

                </div>
            @endif --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use Carbon\Carbon;
                            $no = 1;
                        @endphp
                        @forelse ($presensis as $presensi)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $presensi->Username }}</td>
                                <td>{{ Carbon::parse($presensi->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $presensi->jam }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data presensi tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            {{-- <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Pilih</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Harian</a></li>
                    <li><a class="dropdown-item" href="#">Bulanan</a></li>
                </ul>
            </div>  --}}

        </div>
    </div>

<script src="{{ asset('js/topsidebar.js') }}"></script>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
