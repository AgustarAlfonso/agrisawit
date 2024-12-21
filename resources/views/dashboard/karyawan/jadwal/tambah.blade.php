@extends('layouts.masterkaryawan')

@section('title', 'Tambah Data Jadwal')

@section('content')
<div class="container-fluid mt-4 px-4"> <!-- Full-width container -->
    <div class="row">
        <div class="col-md-10 mx-auto"> <!-- Centered content -->

            <div class="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">Tambahkan Jadwal</h1>
                </div>

                <form action="{{ route('dashboard.karyawan.jadwal.tambah.submit') }}" method="POST" class="mx-auto mt-8 max-w-md space-y-4">
                    @csrf
                
                    <!-- Jenis Perawatan -->
                    <div>
                        <label for="jenisPerawatan" class="block text-sm font-medium text-gray-700">Jenis Perawatan</label>
                        <input 
                            type="text" 
                            id="jenisPerawatan" 
                            name="jenisPerawatan" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('jenisPerawatan') border-red-500 @enderror" 
                            placeholder="Masukkan jenis perawatan"
                            value="{{ old('jenisPerawatan') }}"
                            required>
                        @error('jenisPerawatan')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input 
                            type="date" 
                            id="tanggal" 
                            name="tanggal" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('tanggal') border-red-500 @enderror" 
                            value="{{ old('tanggal') }}"
                            required>
                        @error('tanggal')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <input 
                            type="hidden" 
                            id="status" 
                            name="status" 
                            value="Pending">
                        <p class="text-gray-700">Pending</p>
                    </div>
                
                    <!-- Actions -->
                    <div class="flex items-center justify-between space-x-4">
                        <a href="{{ route('dashboard.karyawan.jadwal') }}" class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-sm font-medium text-gray-700 flex-1 text-center">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="inline-block rounded-lg bg-green-400 px-5 py-3 text-sm font-medium text-white flex-1">
                            simpan
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
@endpush
