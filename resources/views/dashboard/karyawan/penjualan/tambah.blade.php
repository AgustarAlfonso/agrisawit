@extends('layouts.masterkaryawan')

@section('title', 'Tambah Data Penjualan')

@section('content')
<div class="container-fluid mt-4 px-4"> <!-- Full-width container -->
    <div class="row">
        <div class="col-md-10 mx-auto"> <!-- Centered content -->

            <div class="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">Tambahkan Laporan Penjualan</h1>
                </div>

                <form action="{{ route('dashboard.karyawan.penjualan.tambah.submit') }}" method="POST" class="mx-auto mt-8 max-w-md space-y-4">
                    @csrf
                    <div>
                        <label for="tanggalPenjualan" class="block text-sm font-medium text-gray-700">Tanggal Penjualan</label>
                        <input 
                            type="date" 
                            id="tanggalPenjualan" 
                            name="tanggalPenjualan" 
                            class="w-full rounded-lg p-4 text-sm shadow-sm @error('tanggalPenjualan') border-red-500 @enderror" 
                            value="{{ old('tanggalPenjualan') }}"
                            required>
                        @error('tanggalPenjualan')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Terjual -->
                    <div>
                        <label for="jumlahTerjualFormatted" class="block text-sm font-medium text-gray-700">Jumlah Terjual (Kg)</label>
                        <input 
                            type="text" 
                            id="jumlahTerjualFormatted" 
                            class="w-full rounded-lg p-4 text-sm shadow-sm @error('jumlahTerjual') border-red-500 @enderror" 
                            placeholder="Masukkan jumlah terjual (Kg)"
                            required>
                        <input 
                            type="hidden" 
                            id="jumlahTerjual" 
                            name="jumlahTerjual" 
                            value="{{ old('jumlahTerjual') }}">
                        @error('jumlahTerjual')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Harga -->
                    <div>
                        <label for="totalHargaFormatted" class="block text-sm font-medium text-gray-700">Total Harga (Rp)</label>
                        <input 
                            type="text" 
                            id="totalHargaFormatted" 
                            class="w-full rounded-lg p-4 text-sm shadow-sm @error('totalHarga') border-red-500 @enderror" 
                            placeholder="Masukkan total harga (Rp)"
                            required>
                        <input 
                            type="hidden" 
                            id="totalHarga" 
                            name="totalHarga" 
                            value="{{ old('totalHarga') }}">
                        @error('totalHarga')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Penjualan -->


                    <!-- Actions -->
                    <div class="flex items-center justify-between space-x-4">
                        <a href="{{ route('dashboard.karyawan.penjualan') }}" class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-sm font-medium text-gray-700 text-center flex-1">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="inline-block rounded-lg bg-green-400 px-5 py-3 text-sm font-medium text-white flex-1 text-center">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const jumlahTerjualFormatted = document.getElementById('jumlahTerjualFormatted');
        const jumlahTerjual = document.getElementById('jumlahTerjual');

        jumlahTerjualFormatted.addEventListener('input', () => {
            let value = jumlahTerjualFormatted.value.replace(/\./g, '').replace(/[^0-9]/g, '');
            jumlahTerjualFormatted.value = new Intl.NumberFormat('id-ID').format(value);
            jumlahTerjual.value = value;
        });

        const totalHargaFormatted = document.getElementById('totalHargaFormatted');
        const totalHarga = document.getElementById('totalHarga');

        totalHargaFormatted.addEventListener('input', () => {
            let value = totalHargaFormatted.value.replace(/\./g, '').replace(/[^0-9]/g, '');
            totalHargaFormatted.value = new Intl.NumberFormat('id-ID').format(value);
            totalHarga.value = value;
        });
    });
</script>
@endpush
