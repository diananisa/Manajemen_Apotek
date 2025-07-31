<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <link rel="stylesheet" href="file://{{ public_path('css/struk.css') }}">
</head>
<body>

    <h2>Apotek Al Naafi</h2>
    <div class="store-info">
        Dusun Simanggis, Desa Redin<br>
        RT01/RW02, Kec. Gebang Kab. Purworejo
    </div>

    <div class="info">
        <p><strong>No. Transaksi:</strong> {{ $kode }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y H:i') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ strtoupper($metode) }}</p>
        <p><strong>Kasir:</strong>{{ session('Username')}}</p>
    </div>

    <hr>

    @if(count($carts) > 0)
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $item)
                    <tr>
                        <td>{{ $item->Nama_Obat }}</td>
                        <td class="text-center">{{ $item->Jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($item->Harga_Satuan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            <p class="text-right"><strong>Total Bayar:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>

            @if(isset($dibayar))
                <p class="text-right"><strong>Dibayar:</strong> Rp {{ number_format($dibayar, 0, ',', '.') }}</p>
            @endif

            @if(strtolower($metode) === 'cash' && isset($kembali))
                <p class="text-right"><strong>Kembali:</strong> Rp {{ number_format($kembali, 0, ',', '.') }}</p>
            @endif
        </div>

        <div class="summary">
            <p><strong>Terbilang:</strong> {{ ucwords($terbilang) }}</p>
        </div>

    @else
        <p class="text-center">Tidak ada data transaksi.</p>
    @endif

    <div class="footer">
        <hr>
        <p>Terima kasih telah berbelanja di Apotek Sehat Selalu</p>
        <p>Semoga lekas sembuh!</p>
    </div>

</body>
</html>
