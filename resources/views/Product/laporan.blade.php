<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>
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
                    <a class="nav-link active text-primary fw-bold" href="{{ route('Product.index') }}"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('Presensi.index') }}"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
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
                <form method="GET" action="{{ route('Product.laporan') }}" class="flex-grow-1 me-4" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama obat...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('Product.laporan') }}" class="btn btn-outline-secondary ms-2">Reset</a>
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
            
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('Product.laporan') }}" class="mb-3">
                <div class="row g-2 align-items-end">
                    {{-- Jenis Obat --}}
                    <div class="col-md-3">
                        <label class="form-label">Jenis Obat</label>
                        <select name="jenis_obat" class="form-select">
                            <option value="">-- Semua --</option>
                            @foreach ($jenisOptions ?? [] as $opt)
                            <option value="{{ $opt }}" {{ request('jenis_obat') == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Status Stock --}}
                    <div class="col-md-3">
                        <label class="form-label">Status Stock</label>
                        <select name="status_stock" class="form-select">
                            <option value="">-- Semua --</option>
                            <option value="banyak" {{ request('status_stock') == 'banyak' ? 'selected' : '' }}>Banyak</option>
                            <option value="menipis" {{ request('status_stock') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                            <option value="hampir_habis" {{ request('status_stock') == 'hampir_habis' ? 'selected' : '' }}>Hampir Habis</option>
                            <option value="habis" {{ request('status_stock') == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                    </div>
                </div>
            </form>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Laporan Stock Obat</h4>
            </div>

            {{-- Table Supplier --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Id Obat</th>
                            <th>Nama Obat</th>
                            <th>Supplier</th>
                            <th>Jenis Obat</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Jenis Satuan</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Carbon\Carbon; @endphp
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->Id_Obat }}</td>
                                <td>{{ $product->Nama_Obat }}</td>
                                <td>{{ $product->supplier->Nama_Supplier ?? '-' }}</td>
                                <td>{{ $product->supplier->Jenis_Barang_Obat ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($product->Tanggal_Kadaluarsa)->format('d - m - Y') }}</td>
                                <td>{{ $product->Jenis_Satuan }}</td>
                                <td>{{ $product->Jumlah }}</td>
                                <td>
                                    @php
                                        $stock = $product->Jumlah;
                                        if ($stock > 50) {
                                            $status = '<span class="badge bg-success">Banyak</span>';
                                        } elseif ($stock > 10) {
                                            $status = '<span class="badge bg-warning text-dark">Menipis</span>';
                                        } elseif ($stock > 0) {
                                            $status = '<span class="badge bg-danger">Hampir Habis</span>';
                                        } else {
                                            $status = '<span class="badge bg-secondary">Habis</span>';
                                        }
                                    @endphp
                                    {!! $status !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data Product.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> {{-- Akhir Main Content --}}
    </div>
</div>
<script src="{{ asset('js/topsidebar.js') }}"></script>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
