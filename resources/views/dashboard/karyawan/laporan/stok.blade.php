<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok</title>
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
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-stok {
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Stok - Bulan {{ $bulanLaporan }} Tahun {{ $tahunLaporan }}</h1>
        <div class="total-stok mb">
            Total Stok: {{ $data->sum('jumlahPerubahan') }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Perubahan</th>
                <th>Jumlah Perubahan</th>
                <th>Tanggal Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $stok)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stok->jenisPerubahan }}</td>
                    <td>{{ number_format($stok->jumlahPerubahan ?? 0, 0, ',', '.') }}</td>     
                    <td>{{ \Carbon\Carbon::parse($stok->tanggalBerubah ?? '')->format('d-m-Y') }}</td>                
                </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
