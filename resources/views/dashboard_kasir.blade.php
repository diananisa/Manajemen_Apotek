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
</head>
<body class="bg-light">

@csrf

<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Sidebar --}}
        <div class="col-md-2 bg-white border-end p-3">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>

            {{-- Menu --}}
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_kasir') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('product.utama') }}">
                        <i class="bi bi-box-seam me-2"></i>Product
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('cart.view') }}">
                        <i class="bi bi-cart3 me-2"></i>Keranjang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        <i class="bi bi-clipboard-check me-2"></i>Presensi
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">

            {{-- User Info --}}
            <div class="d-flex justify-content-end align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">{{ session('Username') }}</div>
                        <small class="text-muted">{{ session('role') }}</small>
                    </div>
                </div>
            </div>

            {{-- Chart --}}
            <div class="container mt-4">
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
</div>

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
