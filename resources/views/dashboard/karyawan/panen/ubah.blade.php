@extends('layouts.masterkaryawan')

@section('title', 'Ubah Data Panen')

@section('content')
<div class="container-fluid mt-4 px-4"> <!-- Full-width container -->
    <div class="row">
        <div class="col-md-10 mx-auto"> <!-- Centered content -->

            <div class="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">Ubah Data Panen</h1>
                </div>

                <form action="{{ route('dashboard.karyawan.panen.ubah.submit', $panen->id) }}" method="POST" class="mx-auto mt-8 max-w-md space-y-4">
                    @csrf

                    <!-- tanggalPanen -->
                    <div>
                        <label for="tanggalPanen" class="block text-sm font-medium text-gray-700">Tanggal Panen</label>
                        <input 
                            type="date" 
                            id="tanggalPanen" 
                            name="tanggalPanen" 
                            class="w-full rounded-lg p-4 text-sm shadow-sm @error('tanggalPanen') border-red-500 @enderror" 
                            value="{{ old('tanggalPanen', $panen->tanggalPanen) }}"
                            required>
                        @error('tanggalPanen')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- jumlahPanen -->
                    <div>
                        <label for="jumlahPanenFormatted" class="block text-sm font-medium text-gray-700">Jumlah Panen (Kg)</label>
                        <input 
                            type="text" 
                            id="jumlahPanenFormatted" 
                            class="w-full rounded-lg p-4 text-sm shadow-sm @error('jumlahPanen') border-red-500 @enderror" 
                            placeholder="Masukkan jumlah Panen"
                            value="{{ number_format(old('jumlahPanen', $panen->jumlahPanen), 0, ',', '.') }}"
                            required>
                        <input 
                            type="hidden" 
                            id="jumlahPanen" 
                            name="jumlahPanen" 
                            value="{{ old('jumlahPanen', $panen->jumlahPanen) }}">
                        @error('jumlahPanen')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Actions -->
                    <div class="flex items-center justify-between space-x-4">
                        <a href="{{ route('dashboard.karyawan.panen') }}" class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-sm font-medium text-gray-700 text-center flex-1">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="inline-block rounded-lg bg-green-400 px-5 py-3 text-sm font-medium text-white flex-1 ">
                            Simpan Perubahan
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
        const formattedInput = document.getElementById('jumlahPanenFormatted');
        const hiddenInput = document.getElementById('jumlahPanen');

        // Format initial value on page load
        let initialValue = formattedInput.value.replace(/\./g, '').replace(/[^0-9]/g, '');
        formattedInput.value = new Intl.NumberFormat('id-ID').format(initialValue);

        formattedInput.addEventListener('input', () => {
            // Ambil nilai input dan hapus semua non-digit
            let value = formattedInput.value.replace(/\./g, '').replace(/[^0-9]/g, '');

            // Format ulang dengan titik setiap 3 digit
            formattedInput.value = new Intl.NumberFormat('id-ID').format(value);

            // Simpan nilai asli (tanpa titik) di input hidden
            hiddenInput.value = value;
        });
    });
</script>
@endpush
