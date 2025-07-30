<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #000; }
    </style>
</head>
<body>
    <h2 class="text-center">Struk Pembelian</h2>

    @if(count($carts) > 0)
        <p><strong>No. Transaksi:</strong> {{ $kode }}</p>
         <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y H:i') }}</p>
         
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
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

        <br>
        <p class="text-right"><strong>Total Bayar: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
    @else
        <p>Tidak ada data transaksi.</p>
    @endif

    <br><br>
    <p class="text-center">Terima kasih telah berbelanja!</p>
</body>
</html>
