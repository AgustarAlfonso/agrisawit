@extends('layouts.masterkaryawan')

@section('title', 'Laporan')

@section('content')

<div class="container-fluid mt-4 px-4">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2 class="text-4xl font-extrabold dark:text-white">Laporan</h2>
        </div>
    </div>
<form class="max-w-sm w-full">
    <div class="dropdown-container grid grid-cols-1 md:grid-cols-4 gap-2 mt-4 items-end">
        <!-- Pilihan Jenis Laporan -->
        <div>
            <label for="jenisLaporan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Jenis Laporan
            </label>
            <select id="jenisLaporan" name="jenis_laporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="" disabled selected>Pilih</option>
                <option value="panen">Panen</option>
                <option value="stok">Stok</option>
                <option value="penjualan">Penjualan</option>
            </select>
        </div>

        <!-- Pilihan Bulan -->
        <div>
            <label for="bulanLaporan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Bulan
            </label>
            <select id="bulanLaporan" name="bulan_laporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @foreach (range(1, 12) as $month)
                    <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" {{ $month == now()->month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromDate(null, $month, 1)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pilihan Tahun -->
        <div>
            <label for="tahunLaporan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tahun
            </label>
            <select id="tahunLaporan" name="tahun_laporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @foreach (range(2000, 2030) as $year)

                    <option value="{{ $year }}" {{ $year == now()->year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tombol Unduh -->
        <div class="flex ml-2">
            <a href="#" id="downloadButton" class="btn btn-primary w-full md:w-auto text-center ml-auto" disabled>Unduh PDF</a>
        </div>
    </div>
</form>

  
    
      
    <!-- Preview PDF -->
    <div class="row mt-4">
        <div class="col-md-10 mx-auto">
            <div class="flex justify-center mb-2">
                <h4 class="font-extrabold dark:text-white text-xl">Preview Pdf</h4>
            </div>
            
            <div class="border p-2">
                <iframe name="previewFrame" id="previewFrame" style="width: 100%; height: 450px;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
  document.getElementById('jenisLaporan').addEventListener('change', updatePreviewAndDownload);
document.getElementById('bulanLaporan').addEventListener('change', updatePreviewAndDownload);
document.getElementById('tahunLaporan').addEventListener('change', updatePreviewAndDownload);

function updatePreviewAndDownload() {
    const jenisLaporan = document.getElementById('jenisLaporan').value;
    const bulanLaporan = document.getElementById('bulanLaporan').value;
    const tahunLaporan = document.getElementById('tahunLaporan').value;
    const iframe = document.getElementById('previewFrame');
    const downloadButton = document.getElementById('downloadButton');

    if (jenisLaporan && bulanLaporan && tahunLaporan) {
        // Update src iframe untuk preview
        iframe.src = `/dashboard/karyawan/laporan/preview?jenis_laporan=${jenisLaporan}&bulan_laporan=${bulanLaporan}&tahun_laporan=${tahunLaporan}`;

        // Update href tombol unduh
        downloadButton.href = `/dashboard/karyawan/laporan/unduh?jenis_laporan=${jenisLaporan}&bulan_laporan=${bulanLaporan}&tahun_laporan=${tahunLaporan}`;
        downloadButton.removeAttribute('disabled');
    } else {
        // Nonaktifkan tombol unduh jika tidak ada pilihan
        downloadButton.href = '#';
        downloadButton.setAttribute('disabled', 'disabled');
    }
}

</script>

@endsection
