<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Sidebar --}}
        <div class="col-md-2 bg-white border-end p-3">
            <div class="text-center mb-4">
                <img src="{{ asset('asset/logo.png') }}" alt="logo" width="80">
                <h5 class="mt-2">Apoteker.ID</h5>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('dashboard_apoteker') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('supplier.index') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="{{ route('product.index') }}">
                        <i class="bi bi-box-seam me-2"></i>Product Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-end align-items-center mb-4">
                <div class="nav justify-content-end">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-cart3 fs-4 text-primary"></i>
                        <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                        <div>
                            <div class="fw-bold">{{ session('Username')}}</div>
                            <small class="text-muted">{{session('role')}}</small>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Dashboard</h3>

            {{-- Statistik Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Produk Tersedia</h6>
                            <h3>{{ $produkAktif }}</h3>
                            <span class="text-muted small">Dengan stok > 0</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Stok Hampir Habis</h6>
                            <h3>{{ $stokMenipis }}</h3>
                            <span class="text-warning small">Stok ≤ 10</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Supplier Aktif</h6>
                            <h3>{{ $supplierAktif }}</h3>
                            <span class="text-success small">Status aktif</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Supplier Tidak Aktif</h6>
                            <h3>{{ $supplierNonaktif }}</h3>
                            <span class="text-danger small">Status nonaktif</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistik Chart --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header"><strong>Statistik Obat Kadaluarsa</strong></div>
                        <div class="card-body">
                            <div id="radialChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header"><strong>Statistik Stok Obat</strong></div>
                        <div class="card-body">
                            <div id="stokDonutChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Kadaluarsa --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header"><strong>Informasi Kadaluarsa Produk</strong></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Id Obat</th>
                                            <th>Nama Obat</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($stokKadaluarsa as $item)
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
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-muted">Tidak ada data kadaluarsa.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Stok --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header"><strong>Informasi Stok Produk</strong></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Id Obat</th>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($stok as $item)
                                            <tr>
                                                <td>{{ $item->Id_Obat }}</td>
                                                <td>{{ $item->Nama_Obat }}</td>
                                                <td>{{ $item->Jumlah }}</td>
                                                <td><span class="badge bg-{{ $item->badge }}">{{ $item->status }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-muted">Semua stok aman.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- End of Main --}}
    </div>
</div>

{{-- Script --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('js/dashboard_apoteker.js') }}"></script>
<script>
    const CHART_DATA = {
        aman: {{ $chartData['Aman'] }},
        hampir: {{ $chartData['Hampir Kadaluarsa'] }},
        kadaluarsa: {{ $chartData['Kadaluarsa'] }}
    };

    const STOK_CHART = {
        habis: {{ $stokChart['Habis'] }},
        bahaya: {{ $stokChart['Hampir Habis'] }},
        menipis: {{ $stokChart['Menipis'] }},
        aman: {{ $stokChart['Banyak'] }},
    };
</script>
</body>
</html>
