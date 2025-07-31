<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager</title>

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
                <a class="nav-link active text-primary fw-bold" href="#">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('supplier.laporan') }}">
                    <i class="bi bi-truck me-2"></i>Supplier
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('Product.laporan') }}">
                    <i class="bi bi-box-seam me-2"></i>Product Stock
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('presensi.belum') }}">
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
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                <div>
                    <div class="fw-bold">{{ session('Username') }}</div>
                    <small class="text-muted">{{ session('role') }}</small>
                </div>
            </div>
        </div>

        <div style="height: 80px;"></div>

        <h3>Dashboard</h3>

        {{-- Chart Penjualan --}}
        <div class="mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Total Penjualan</h4>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="salesChart"></canvas>
                    </div>

                    {{-- Filter Penjualan --}}
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <form method="GET" action="{{ route('dashboard_manager') }}" class="d-flex flex-wrap gap-2 align-items-center">

                            {{-- Filter Utama --}}
                            <div>
                                <select name="filter" class="form-select" onchange="this.form.submit()">
                                    <option value="tahun" {{ $filter=='tahun' ? 'selected' : '' }}>Tahunan</option>
                                    <option value="bulan" {{ $filter=='bulan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="hari" {{ $filter=='hari' ? 'selected' : '' }}>Tanggal Harian</option>
                                    <option value="jam" {{ $filter=='jam' ? 'selected' : '' }}>Jam</option>
                                </select>
                            </div>

                            {{-- Tahunan --}}
                            @if($filter == 'tahun' && count($availableYears) > 3)
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

                            {{-- Bulanan --}}
                            @if($filter == 'bulan')
                                <div>
                                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                                        @foreach($availableYears as $y)
                                            <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            {{-- Harian --}}
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
                                        @for($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}" {{ $bulan==$i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            @endif

                            {{-- Jam --}}
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

        {{-- Tabel Kadaluarsa --}}
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header"><strong>Informasi Kadaluarsa Produk</strong></div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Id Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status Stok</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($stok as $item)
                                    <tr>
                                        <td>{{ $item->Id_Obat }}</td>
                                        <td>{{ $item->Nama_Obat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->Tanggal_Kadaluarsa)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td><span class="badge bg-{{ $item->badge }}">{{ $item->status }}</span></td>
                                        <td>
                                            @if (isset($item->sisa_hari))
                                            @if ($item->sisa_hari === 0)
                                            Hari Ini
                                                @elseif ($item->sisa_hari > 0)
                                                {{ $item->sisa_hari }} hari
                                                @else
                                                -
                                                @endif
                                                @else
                                                -
                                                @endif
                                            </td>
                                        <td>{{ $item->Jumlah }}</td>
                                        <td><span class="badge bg-{{ $item->badge_stok }}">{{ $item->status_stok }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-muted">Tidak ada data kadaluarsa.</td>
                                        </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- End Main Content --}}
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
