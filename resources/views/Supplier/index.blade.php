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
                    <a class="nav-link text-dark" href="{{ route('dashboard_apoteker') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('supplier.index') }}">
                        <i class="bi bi-truck me-2"></i>Supplier
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
                {{-- Main Content --}}

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Supplier</h4>
                <a href="{{ route('supplier.add') }}" class="btn btn-primary">
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
                                <td>Rp. {{ number_format($supplier->Total_Harga, 0, ',', '.') }}</td>
 --}}
                                <td>
                                    <a href="{{ route('supplier.edit', $supplier->Id_supplier) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('supplier.destroy', $supplier->Id_supplier) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
