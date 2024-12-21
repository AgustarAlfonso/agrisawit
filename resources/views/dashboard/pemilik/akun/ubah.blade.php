@extends('layouts.masterpemilik')

@section('title', 'Ubah Akun')

@section('content')
<div class="container-fluid mt-4 px-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">Ubah Data Akun</h1>
                </div>

                <form action="{{ route('dashboard.pemilik.akun.ubah.submit', $akun->id) }}" method="POST" class="mx-auto mt-8 max-w-md space-y-4">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('username') border-red-500 @enderror" 
                            value="{{ old('username', $akun->username) }}" 
                            required>
                        @error('username')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('name') border-red-500 @enderror" 
                            value="{{ old('name', $akun->name) }}" 
                            required>
                        @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select 
                            id="role" 
                            name="role" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('role') border-red-500 @enderror" 
                            required>
                            <option value="pemilik" {{ old('role', $akun->role) === 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                            <option value="karyawan" {{ old('role', $akun->role) === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        </select>
                        @error('role')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('password') border-red-500 @enderror" 
                            placeholder="Masukkin password "
                            required>
                        @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full rounded-lg  p-4 text-sm shadow-sm @error('password_confirmation') border-red-500 @enderror" 
                            placeholder="Konfirmasi password "
                            required>
                        @error('password_confirmation')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->


                    <!-- Actions -->
                    <div class="flex items-center justify-between space-x-4">
                        <a href="{{ route('dashboard.pemilik.akun') }}" class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-center text-sm font-medium  text-gray-700 flex-1">
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
