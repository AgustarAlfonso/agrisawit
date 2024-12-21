@extends('layouts.masterpemilik')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6 flex items-center justify-center min-h-screen">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
        <!-- Jadwal Mendatang -->
        <div class="bg-yellow-200 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Jadwal Mendatang</h3>
            @if($jadwalMendatang)
                <p class="mt-4 text-gray-500">Status: <span class="text-yellow-500 font-bold">{{ $jadwalMendatang->status }}</span></p>
                <p class="mt-2 text-gray-500">
                    Tanggal: 
                    <span class="font-bold">{{ \Carbon\Carbon::parse($jadwalMendatang->tanggal)->format('d/m/Y') }}</span>
                </p>
            @else
                <p class="mt-4 text-gray-500">Tidak ada jadwal mendatang.</p>
            @endif
        </div>

        <!-- Total Stok -->
        <div class="bg-blue-200 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Stok</h3>
            <p class="mt-4 text-3xl font-bold text-blue-500">{{ number_format($totalStok, 0, ',', '.') }} Kg</p>
            <p class="mt-2 text-gray-500">Barang tersedia saat ini.</p>
        </div>

        <!-- Jumlah Panen Terakhir -->
        <div class="bg-green-200 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Jumlah Panen Terakhir</h3>
            <p class="mt-4 text-3xl font-bold text-green-500">{{ number_format($jumlahPanenTerakhir, 0, ',', '.') }} Kg</p>
            <p class="mt-2 text-gray-500">Hasil panen terbaru.</p>
        </div>

        <!-- Jumlah Penjualan Terakhir -->
        <div class="bg-red-200 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Jumlah Penjualan Terakhir</h3>
            <p class="mt-4 text-3xl font-bold text-red-500">{{ number_format($jumlahPenjualanTerakhir, 0, ',', '.') }} Kg</p>
            <p class="mt-2 text-gray-500">Barang terjual terakhir kali.</p>
        </div>
    </div>
</div>
@endsection
