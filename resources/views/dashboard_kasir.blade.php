<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="{{ asset('css/topsidebar.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

    @csrf
    <div class="d-flex"> <!-- Wrapper Flex -->

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
                    <a class="nav-link {{ request()->routeIs('dashboard_kasir') ? 'active' : '' }}" href="{{ route('dashboard_kasir') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('Product.utama') ? 'active' : '' }}" href="{{ route('Product.utama') }}">
                        <i class="bi bi-box-seam me-2"></i>Product
                    </a>
                </li>
                @php
                    use App\Http\Controllers\PresensiController;
                    $statusKehadiran = app(PresensiController::class)->cekStatusHariIni();
                @endphp

                <li class="nav-item">
                    @if($statusKehadiran === 'Tidak Hadir' || $statusKehadiran === null)
                        <a class="nav-link {{ request()->routeIs('Presensi.kasir.belum') ? 'active' : '' }}"
                        href="{{ route('Presensi.kasir.belum') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Presensi
                        </a>
                    @else
                        <a class="nav-link {{ request()->routeIs('Presensi.kasir.sudah') ? 'active' : '' }}"
                        href="{{ route('Presensi.kasir.sudah') }}">
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
                <div class="user-menu-wrapper d-flex align-items-center gap-3 position-relative">

                    <!-- Tombol Keranjang -->
                    <a href="{{ route('cart.view') }}"
                        class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center cart-btn">
                        <i class="bi bi-cart3 fs-4"></i>
                    </a>

                    <!-- User Info (Dropdown Toggle) -->
                    <div id="userMenuToggle" class="d-flex align-items-center gap-2" style="cursor:pointer;">
                        <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                        <div>
                            <div class="fw-bold">{{ session('Username') }}</div>
                            <small class="text-muted">{{ session('role') }}</small>
                        </div>
                        <i class="bi bi-caret-down-fill text-muted small"></i>
                    </div>

                    <!-- Dropdown Menu -->
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

            <h3>Dashboard</h3>

            {{-- Chart --}}
            <div class="mt-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">Total Penjualan</h4>
                        <div class="card-body" style="height: 350px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                            <div class="d-flex justify-content-end align-items-center mb-3">
                            <form method="GET" action="{{ route('dashboard_kasir') }}" class="d-flex flex-wrap gap-2 align-items-center">
                                <!-- Filter Utama -->
                                <div>
                                    <select name="filter" class="form-select" onchange="this.form.submit()">
                                        <option value="tahun" {{ $filter=='tahun' ? 'selected' : '' }}>Tahunan</option>
                                        <option value="bulan" {{ $filter=='bulan' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="hari" {{ $filter=='hari' ? 'selected' : '' }}>Tanggal Harian</option>
                                        <option value="jam" {{ $filter=='jam' ? 'selected' : '' }}>Jam</option>
                                    </select>
                                </div>

                                <!-- Tahunan -->
                                @if($filter == 'tahun')
                                    @if(count($availableYears) > 3)
                                        <div>
                                            <select name="tahun_mulai" class="form-select" onchange="this.form.submit()">
                                                @foreach($availableYears as $y)
                                                    <option value="{{ $y }}" {{ $tahunMulai==$y ? 'selected' : '' }}>{{ $y }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <select name="tahun_akhir" class="form-select" onchange="this.form.submit()">
                                                @foreach($availableYears as $y)
                                                    <option value="{{ $y }}" {{ $tahunAkhir==$y ? 'selected' : '' }}>{{ $y }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @endif

                                <!-- Bulanan -->
                                @if($filter == 'bulan')
                                    <div>
                                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                                            @foreach($availableYears as $y)
                                                <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Harian -->
                                @if($filter == 'hari')
                                    <div>
                                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                                            @foreach($availableYears as $y)
                                                <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <select name="bulan" class="form-select" onchange="this.form.submit()">
                                            @for($i=1;$i<=12;$i++)
                                                <option value="{{ $i }}" {{ $bulan==$i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                @endif

                                <!-- Jam -->
                                @if($filter == 'jam')
                                    <div>
                                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control" onchange="this.form.submit()">
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('js/topsidebar.js') }}"></script>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Kirim Data Penjualan dari Laravel ke JS --}}
<script>
    window.salesDataLabels = {!! json_encode($salesData->pluck('label')) !!};
    window.salesDataValues = {!! json_encode($salesData->pluck('total_penjualan')) !!};
    window.filterType = "{{ $filter }}";
</script>

{{-- File Chart JS Terpisah --}}
<script src="{{ asset('js/dashboard_kasir.js') }}"></script>

</body>
</html>
