<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
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
                    <a class="nav-link active text-primary fw-bold" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-truck me-2"></i>Supplier</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active text-primary fw-bold" href="{{ route('product.index') }}"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-clipboard-check me-2"></i>Presensi</a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-4 bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- <h3>Dashboard</h3> -->
                 <!-- Search Form -->
                <form action="{{ route('product.index') }}" method="GET" class="mb-3">
                    <div class="input-group w-400">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-cart3 fs-4 text-primary"></i>
                    <img src="{{ asset('asset/user.png') }}" width="40" class="rounded-circle" alt="profile">
                    <div>
                        <div class="fw-bold">Dinda</div>
                        <small class="text-muted">Apoteker</small>
                    </div>
                </div>
            </div>
              <h3>Edit Product</h3>
              @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                    </div>
                        
                @endif
                <form action="{{ route('product.update', $product->Id_Obat)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" name="gambar" class="form-control" id="gambar" value="{{ $product->gambar }}">
                    </div>
                    <div class="mb-3">
                        <label for="Id_Obat" class="form-label">Id Obat</label>
                        <input type="text" class="form-control" name="Id_Obat" id="Id_Obat" value="{{ $product->Id_Obat }}">
                    </div>
                    <div class="mb-3">
                        <label for="Nama_Obat" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" name="Nama_Obat" id="Nama_Obat" value="{{ $product->Nama_Obat }}">
                    </div>
                    <div class="mb-3">
                        <label for="Tanggal_Kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" name="Tanggal_Kadaluarsa" id="Tanggal_Kadaluarsa" value="{{ $product->Tanggal_Kadaluarsa }}">
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Pilih Supplier</label>
                        <select name="supplier_id" class="form-control" id="supplier_id">
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" 
                                    {{ $supplier->id == $product->supplier_id ? 'selected' : '' }}>
                                    {{ $supplier->Nama_Supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Harga_Jual" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control" name="Harga_Jual" id="Harga_Jual" value="{{ $product->Harga_Jual }}">
                    </div>
                    <div class="mb-3">
                        <label for="Jenis_Satuan" class="form-label">Jenis Satuan</label>
                        <input type="text" class="form-control" name="Jenis_Satuan" id="Jenis_Satuan" value="{{ $product->Jenis_Satuan }}">
                    </div>
                    <div class="mb-3">
                        <label for="Jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" name="Jumlah" id="Jumlah" value="{{ $product->Jumlah }}">
                    </div>
                    <div class="mb-3">
                        <label for="Total_Harga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" name="Total_Harga" id="Total_Harga" value="{{ $product->Total_Harga }}">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">please upload square image size less than 100kb</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple>
                    </div> --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('product.index') }}" class="btn btn-secondary"><- Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
