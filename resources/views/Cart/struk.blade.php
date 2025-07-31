<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .store-info {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 6px;
            font-weight: bold;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .summary {
            margin-top: 10px;
        }

        .summary p {
            margin: 4px 0;
        }

        .total-box {
            background-color: #f8f8f8;
            padding: 10px;
            border: 1px dashed #aaa;
            margin-top: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        hr {
            border: none;
            border-top: 1px dashed #aaa;
            margin: 10px 0;
        }
    </style>
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

        <<div class="total-box">
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
