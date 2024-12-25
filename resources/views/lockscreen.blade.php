@extends('layouts.mastererror')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-gray-300 p-8 rounded-lg shadow-2xl w-full max-w-sm">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">🔒 Lock Screen</h2>

        <!-- Menampilkan nama pengguna -->
        <p class="text-center text-lg font-medium text-gray-700 mb-6">Welcome back, <span class="text-indigo-600">{{ Auth::user()->name }}</span>!</p>

        <form action="{{ route('lockscreen.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Enter your password:</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" 
                    required
                >
                @error('password')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white py-2 rounded-md shadow-md hover:shadow-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none">
                Unlock
            </button>
        </form>
        <div class="mt-6 text-center">
            <a 
                href="{{ route('logout') }}" 
                class="text-sm font-medium text-purple-600 hover:underline hover:text-purple-800">
                Logout
            </a>
        </div>
    </div>
</div>
@endsection
