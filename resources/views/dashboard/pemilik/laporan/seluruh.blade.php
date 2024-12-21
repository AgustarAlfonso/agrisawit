<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Seluruh</title>
</head>
<body>
    <h1>Laporan Gabungan - {{ $bulanLaporan }} {{ $tahunLaporan }}</h1>
    <div class="total-stok">
        Total Stok: {{ $totalStok }}
    </div>

    <h2>Data Panen</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Jumlah Panen</th>
                <th>Tanggal Panen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['panen'] as $panen)
                <tr>
                    <td>{{ number_format($panen->jumlahPanen ?? 0, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($panen->tanggalPanen ?? '')->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Stok</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Jenis Perubahan</th>
                <th>Jumlah Perubahan</th>
                <th>Tanggal Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['stok'] as $stok)
                <tr>
                    <td>{{ $stok->jenisPerubahan }}</td>
                    <td>{{ number_format($stok->jumlahPerubahan ?? 0, 0, ',', '.') }}</td>     
                    <td>{{ \Carbon\Carbon::parse($stok->tanggalBerubah ?? '')->format('d-m-Y') }}</td>  
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Penjualan</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Jumlah Terjual</th>
                <th>Total Harga</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['penjualan'] as $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($penjualan->jumlahTerjual ?? 0, 0, ',', '.') }}</td>                    
                    <td>Rp{{ number_format($penjualan->totalHarga, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggalPenjualan ?? '')->format('d-m-Y') }}</td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
