<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Edit</title>
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
                    <a class="nav-link {{ request()->routeIs('dashboard_apoteker') ? 'active' : '' }}" href="{{ route('dashboard_apoteker') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Supplier.index') ? 'active' : '' }}" href="{{ route('Supplier.index') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Product.index') ? 'active' : '' }}" href="{{ route('Product.index') }}">
                        <i class="bi bi-box-seam me-2"></i>Product Stock
                    </a>
                </li>
                @php
                    use App\Http\Controllers\PresensiController;
                    $statusKehadiran = app(PresensiController::class)->cekStatusHariIni();
                @endphp

                <li class="nav-item">
                    @if($statusKehadiran === 'Tidak Hadir' || $statusKehadiran === null)
                        <a class="nav-link {{ request()->routeIs('Presensi.apoteker.belum') ? 'active' : '' }}"
                        href="{{ route('Presensi.apoteker.belum') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Presensi
                        </a>
                    @else
                        <a class="nav-link {{ request()->routeIs('Presensi.apoteker.sudah') ? 'active' : '' }}"
                        href="{{ route('Presensi.apoteker.sudah') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Presensi
                        </a>
                    @endif
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

            <h3 class="mb-4">Edit Supplier</h3>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            @endif

            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <form action="{{ route('Supplier.update') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="Id_supplier" class="form-label">ID Supplier</label>
                            <input type="text" class="form-control" name="Id_supplier" value="{{ $supplier->Id_supplier }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="Nama_Supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" name="Nama_Supplier" value="{{ $supplier->Nama_Supplier }}">
                        </div>

                        <div class="mb-3">
                            <label for="Kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" name="Kontak" value="{{ $supplier->Kontak }}">
                        </div>

                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="Alamat" value="{{ $supplier->Alamat }}">
                        </div>

                        <div class="mb-3">
                            <label for="Jenis_Barang_Obat" class="form-label">Jenis Barang/Obat</label>
                            <input type="text" class="form-control" name="Jenis_Barang_Obat" value="{{ $supplier->Jenis_Barang_Obat }}">
                        </div>

                        <div class="mb-3">
                            <label for="Nama_PIC" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control" name="Nama_PIC" value="{{ $supplier->Nama_PIC }}">
                        </div>

                        <div class="mb-3">
                            <label for="Status" class="form-label">Status</label>
                            <input type="hidden" name="Status" value="Tidak Aktif">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="Status" name="Status" value="Aktif"
                                    {{ old('Status', $supplier->Status ?? '') === 'Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Status">Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('Supplier.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('js/topsidebar.js') }}"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
