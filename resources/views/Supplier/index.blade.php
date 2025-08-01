<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                    <a class="nav-link text-dark" href="{{ route('dashboard_apoteker') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('Supplier.index') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('Product.index') }}"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
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

                <!-- Search Form -->
                <form method="GET" action="{{ route('Supplier.index') }}" class="flex-grow-1 me-4" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama supplier...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('Supplier.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                        @endif
                    </div>
                </form>

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

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Supplier</h4>
                <a href="{{ route('Supplier.add') }}" class="btn btn-primary">
                    @csrf
                    <i class="bi bi-plus-lg"></i> Tambah Supplier
                </a>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table Supplier --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Id Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Jenis Barang/Obat</th>
                            <th>Nama PIC</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Carbon\Carbon; @endphp
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->Id_supplier }}</td>
                                <td>{{ $supplier->Nama_Supplier }}</td>
                                <td>{{ $supplier->Kontak }}</td>
                                <td>{{ $supplier->Alamat }}</td>
                                <td>{{ $supplier->Jenis_Barang_Obat }}</td>
                                <td>{{ $supplier->Nama_PIC }}</td>
                                <td>{{ $supplier->Status }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($supplier->Tanggal_Masuk)->format('d - m - Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($supplier->Tanggal_Kadaluarsa)->format('d - m - Y') }}</td> --}}
                                {{-- <td>{{ $supplier->Jumlah }}</td>
                                <td>Rp. {{ number_format($supplier->Total_Harga, 0, ',', '.') }}</td>--}}
                                <td>
                                    <a href="{{ route('Supplier.edit', $supplier->Id_supplier) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('Supplier.destroy', $supplier->Id_supplier) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data supplier.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> {{-- Akhir Main Content --}}

        {{-- <table class="table"></table>
        <thead>
            <tr>
                <th scope="id_supplier">Id Supplier</th>
                <th scope="nama_supplier">Nama Supplier</th>
                <th scope="nama_produck">Nama Produck</th>
                <th scope="tanggal_masuk">Tanggal Masuk</th>
                <th scope="tanggal_kadaluarsa">Tanggal_Kadaluarsa</th>
                <th scope="total_harga">Total Harga</th>
                <th scope="stock">Stock</th>
            </tr>
        </thead> --}}         

    </div>
<script src="{{ asset('js/topsidebar.js') }}"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
