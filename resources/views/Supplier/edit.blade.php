<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <a class="nav-link text-dark" href="#"><i class="bi bi-box-seam me-2"></i>Product Stock</a>
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
                <form action="{{ route('supplier.index') }}" method="GET" class="mb-3">
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
              <h3>Edit Supplier</h3>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                    </div>
                        
                @endif
              <form action="{{ route('supplier.update', $supplier->Id_supplier) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="Id_supplier" class="form-label">ID Supplier</label>
                    <input type="text" class="form-control" name="Id_supplier">
                </div>
                <div class="mb-3">
                    <label for="Nama_Produck" class="form-label">Nama product</label>
                    <input type="text" class="form-control" name="Nama_Produck" id="Nama_Produck" value="{{ $supplier->Nama_Produck }}">
                </div>
                <div class="mb-3">
                    <label for="Tanggal_Masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="Tanggal_Masuk" id="Tanggal_Masuk" value="{{ $supplier->Tanggal_Masuk }}">
                </div>
                <div class="mb-3">
                    <label for="Tanggal_Kadaluarsa" class="form-label">Tanggal Expired</label>
                    <input type="date" class="form-control" name="Tanggal_Kadaluarsa" id="Tanggal_Kadaluarsa" value="{{ $supplier->Tanggal_Kadaluarsa }}">
                </div>
                <div class="mb-3">
                    <label for="Jumlah" class="form-label">Jumlah</label>
                    <input type="text" class="form-control" name="Jumlah" id="Jumlah" value="{{ $supplier->Jumlah }}">
                </div>
                <div class="mb-3">
                    <label for="Total_Harga" class="form-label">Total Harga</label>
                    <input type="text" class="form-control" name="Total_Harga" id="Total_Harga" value="{{ $supplier->Total_Harga }}">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><- Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>

            
        </div>
    </div>
</div>


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#Id_supplier').on('keyup change', function () {
        let id = $(this).val();
        console.log("ID yang diketik: ", id);

        if (id !== '') {
            $.ajax({
                url: `/api/Supplier/${id}`,
                type: 'GET',
                success: function (data) {
                    $('#Nama_Produck').val(data.Nama_Produck || '');
                    $('#Tanggal_Masuk').val(data.Tanggal_Masuk || '');
                    $('#Tanggal_Kadaluarsa').val(data.Tanggal_Kadaluarsa || '');
                    $('#Jumlah').val(data.Jumlah || '');
                    $('#Total_Harga').val(data.Total_Harga || '');
                },
                error: function () {
                    $('#Nama_Produck').val('');
                    $('#Tanggal_Masuk').val('');
                    $('#Tanggal_Kadaluarsa').val('');
                    $('#Jumlah').val('');
                    $('#Total_Harga').val('');
                }
            });
        }
    });

    $(document).ready(function () {
        $('#Id_supplier').trigger('change');
    });
</script> --}}

</body>
</html>
