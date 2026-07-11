<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .subtitle {
            margin-bottom: 20px;
            color: #4b5563;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #e5e7eb;
        }
        .total {
            margin-top: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="title">{{ $reportTitle }}</div>
    <div class="subtitle">Periode: {{ $reportPeriod }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal Bayar</th>
                <th>Kode Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Tagihan</th>
                <th>Bayar</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_bayar->format('d M Y H:i') }}</td>
                    <td>{{ $item->pesanan->kode_pesanan ?? '-' }}</td>
                    <td>{{ $item->pesanan->nama_pelanggan ?? '-' }}</td>
                    <td>Rp {{ number_format($item->pesanan->total_harga ?? 0) }}</td>
                    <td>Rp {{ number_format($item->bayar) }}</td>
                    <td>Rp {{ number_format($item->kembalian) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total Pendapatan: Rp {{ number_format($totalPendapatan) }}</div>
</body>
</html>
