<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
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

            <h3 class="mb-4">Tambah Product</h3>

            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <form action="{{ route('Product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control">
                            {{-- @error('gambar') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror --}}
                        </div>

                        <div class="mb-3">
                            <label for="Id_Obat" class="form-label">ID Obat</label>
                            <input type="text" class="form-control" name="Id_Obat" value="{{ $newId }}" readonly>
                            @error('Id_Obat') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Nama_Obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" name="Nama_Obat">
                            @error('Nama_Obat') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Tanggal_Kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control" name="Tanggal_Kadaluarsa">
                            @error('Tanggal_Kadaluarsa') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Pilih Supplier</label>
                            <select name="supplier_id" class="form-control">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->Nama_Supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Harga_Jual" class="form-label">Harga Jual</label>
                            <input type="text" class="form-control" name="Harga_Jual">
                            @error('Harga_Jual') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Jenis_Satuan" class="form-label">Jenis Satuan</label>
                            <input type="text" class="form-control" name="Jenis_Satuan">
                            @error('Jenis_Satuan') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Jumlah" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" name="Jumlah">
                            @error('Jumlah') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Total_Harga" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" name="Total_Harga">
                            @error('Total_Harga') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('Product.index') }}" class="btn btn-secondary">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
