<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        table { width: 100%; margin-top: 20px; }
        th, td { padding: 6px; }
    </style>
</head>
<body>
    <h2 class="text-center">Struk Pembelian</h2>

    <p><strong>No. Transaksi:</strong> {{ $cart->Kode_Transaksi }}</p>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($cart->Tanggal_Transaksi)->format('d-m-Y H:i') }}</p>

    <hr>

    <table>
        <tr>
            <td><strong>Nama Obat</strong></td>
            <td>{{ $cart->Nama_Obat }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah</strong></td>
            <td>{{ $cart->Jumlah }}</td>
        </tr>
        <tr>
            <td><strong>Harga Satuan</strong></td>
            <td>Rp {{ number_format($cart->Harga_Satuan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Harga</strong></td>
            <td>Rp {{ number_format($cart->Total_Harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <br><br>
    <p class="text-center">Terima kasih telah berbelanja!</p>
</body>
</html>
