<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Panen</title>
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
    <h1>Laporan Panen - Bulan {{ $bulanLaporan }} Tahun {{ $tahunLaporan }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jumlah Panen</th>
                <th>Tanggal Panen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $panen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($panen->jumlahPanen ?? 0, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($panen->tanggalPanen ?? '')->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
