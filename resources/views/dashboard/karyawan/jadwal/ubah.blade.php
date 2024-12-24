@extends('layouts.masterkaryawan')

@section('title', 'Ubah Jadwal')

@section('content')
<div class="container-fluid mt-4 px-4"> <!-- Full-width container -->
    <div class="row">
                     
        @if (session('gagal'))
        <script>
        Swal.fire({
            title: 'Gagal!',
            html: '{!! implode("<br>", session("gagal")) !!}',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545',
        });
        </script>
        @endif
        <div class="col-md-10 mx-auto"> <!-- Centered content -->

            <div class="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">Ubah  Jadwal</h1>
                </div>

                <form action="{{ route('dashboard.karyawan.jadwal.ubah.submit', $jadwal->id) }}" method="POST" class="mx-auto mt-8 max-w-md space-y-4">
                    @csrf

                    <!-- Jenis Perawatan -->
                    <div>
                        <label for="jenisPerawatan" class="block text-sm font-medium text-gray-700">Jenis Perawatan</label>
                        <input 
                            type="text" 
                            id="jenisPerawatan" 
                            name="jenisPerawatan" 
                            class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm bg-gray-100 cursor-not-allowed" 
                            value="{{ $jadwal->jenisPerawatan }}"
                            readonly
                            >
                    </div>
                
                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input 
                            type="date" 
                            id="tanggal" 
                            name="tanggal" 
                            class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm bg-gray-100 cursor-not-allowed" 
                            value="{{ $jadwal->tanggal }}"
                            readonly
                            >
                    </div>
                
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select 
                            id="status" 
                            name="status" 
                            class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm" 
                            required>
                            <option value="" disabled selected>Pilih status</option>
                            <option value="Pending" {{ $jadwal->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Selesai" {{ $jadwal->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                
                    <!-- Actions -->
                    <div class="flex items-center justify-between space-x-4">
                        <a href="{{ route('dashboard.karyawan.jadwal') }}" class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-sm font-medium text-gray-700 flex-1 text-center">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="inline-block rounded-lg bg-green-400 px-5 py-3 text-sm font-medium text-white flex-1">
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
@endpush
