<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/topsidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tablepresensi.css') }}" rel="stylesheet">
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
                    <a class="nav-link {{ request()->routeIs('dashboard_manager') ? 'active' : '' }}" href="{{ route('dashboard_manager') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Supplier.laporan') ? 'active' : '' }}" href="{{ route('Supplier.laporan') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Product.laporan') ? 'active' : '' }}" href="{{ route('Product.laporan') }}">
                        <i class="bi bi-box-seam me-2"></i>Product Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('Presensi.index') ? 'active' : '' }}" href="{{ route('Presensi.index') }}">
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

                <!-- Search Form -->
                <form method="GET" action="{{ route('Presensi.index') }}" class="flex-grow-1 me-4" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama karyawan...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('Presensi.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
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
                <h4 class="fw-bold">Data Presensi Karyawan</h4>
            </div>

            <div class="row mb-5 g-2">
                <form action="{{ route('Presensi.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                    <div>
                        <input type="date" name="tanggal" value="{{ request('tanggal') ?? now()->format('Y-m-d') }}" class="form-control">
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            {{-- @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}

                </div>
            @endif --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle shadow-sm rounded-3">
                    <thead class="custom-table-header">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th class="text-center">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($presensis as $presensi)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $presensi->Username }}</td>
                                <td>{{ $presensi->role }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $presensi->jam }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        {{-- Badge status --}}
                                        @php
                                            $badgeClass = match($presensi->status_kehadiran) {
                                                'Hadir' => 'success',
                                                'Tidak Hadir' => 'danger',
                                                'Izin' => 'warning',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                                            {{ $presensi->status_kehadiran }}
                                        </span>

                                        {{-- Tombol edit status (ikon) --}}
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary edit-status-btn"
                                            data-id="{{ $presensi->id }}"
                                            data-current="{{ $presensi->status_kehadiran }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle"></i> Data presensi tidak ditemukan.
                                </td>
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

<!-- Simpan nilai ke elemen HTML -->
<div id="presensiConfig"
     data-url="{{ route('Presensi.updateStatus') }}"
     data-token="{{ csrf_token() }}">
</div>

<!-- Modal Pilih Status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusModalLabel">Ubah Status Kehadiran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="statusSelect" class="form-select">
          <option value="Hadir">Hadir</option>
          <option value="Tidak Hadir">Tidak Hadir</option>
          <option value="Izin">Izin</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveStatusBtn">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/topsidebar.js') }}"></script>
<script src="{{ asset('js/update_presensi.js') }}"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
