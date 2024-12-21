<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan - Bulan {{ $bulanLaporan }} Tahun {{ $tahunLaporan }}</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jumlah Terjual</th>
                <th>Total Harga</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($penjualan->jumlahTerjual ?? 0, 0, ',', '.') }}</td>                    
                    <td>Rp{{ number_format($penjualan->totalHarga, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggalPenjualan ?? '')->format('d-m-Y') }}</td>                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
