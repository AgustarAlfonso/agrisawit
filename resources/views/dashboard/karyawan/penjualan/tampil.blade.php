@extends('layouts.masterkaryawan')

@section('title', 'Data Penjualan')

@section('content')

<div class="container-fluid mt-4 px-4">
    <!-- Use container-fluid for full width -->
     <div class="row">
         <div class="col-md-10 mx-auto">
            <!-- Adjust column width and offset for sidebar -->
             <h2 class="text-4xl font-extrabold dark:text-white">Laporan Penjualan</h2>
             
             <!-- Tombol Tambah yang memunculkan Modal -->
             <div class="flex justify-end">
                 <a href="{{ route('dashboard.karyawan.penjualan.tambah') }}">
                 <button
                     class="inline-flex items-center gap-2 rounded-md bg-green-400 px-4 py-2 text-sm text-white shadow-sm hover:bg-green-500 focus:relative">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                     </svg>
                     Tambahkan
                 </button>
             </a>
             </div>  
 
             @if (session('berhasilDibuat'))
             <script>
             Swal.fire({
                 title: '{{ session('berhasilDibuat') }}',
                 imageUrl: '/images/icon-berhasil.png', // Ikon khusus
                 imageWidth: 100, // Lebar gambar
                 imageHeight: 100, // Tinggi gambar
                 confirmButtonText: 'Selesai', // Teks tombol dengan ikon
                 confirmButtonColor: '#28a745', // Warna tombol (contoh: hijau)
 
             });
             </script>
             @endif
             
             @if (session('berhasilDihapus'))
             <script>
             Swal.fire({
                 title: '{{ session('berhasilDihapus') }}',
                 imageUrl: '/images/icon-hapus-2.png', // Ikon khusus
                 imageWidth: 100, // Lebar gambar
                 imageHeight: 100, // Tinggi gambar
                 confirmButtonText: 'Selesai', // Teks tombol dengan ikon
                 confirmButtonColor: '#dc3545', // Warna tombol (contoh: merah)
             });
             </script>
             @endif         
 
             <div class="overflow-x-auto">
                 <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                     <thead>
                         <tr>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-48">Tanggal Penjualan</th>
                           <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-40">Jumlah Terjual</th>
                           <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-40">Total Harga</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-32"> Aksi </th>
                         </tr>
                       </thead>
               
                   <tbody class="divide-y divide-gray-200">
                     @forelse ($penjualans as $penjualan)
                     <tr>
                        <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">{{ \Carbon\Carbon::parse($penjualan->tanggalPenjualan)->format('d-m-Y') }}</td>
                         <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">{{ number_format($penjualan->jumlahTerjual, 0, ',', '.') }} Kg </td>
                         <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                            {{ 'Rp ' . number_format($penjualan->totalHarga, 0, ',', '.') }},00
                        </td>
                       <td class="whitespace-nowrap px-4 py-2 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dashboard.karyawan.penjualan.ubah', $penjualan->id) }}">
                                <button class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm text-white shadow-sm hover:bg-green-100 focus:relative">
                                    <img src="/images/icon-edit.png" alt="edit" class="w-4 h-4" />
                                </button>
                            </a>
                            <button class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm text-white shadow-sm hover:bg-green-100 focus:relative"
                                    onclick="confirmHapus('{{ route('dashboard.karyawan.penjualan.hapus', $penjualan->id) }}')">
                                <img src="/images/icon-hapus.png" alt="delete" class="w-4 h-4" />
                            </button>
                        </div>
                        
                       </td>
                     </tr>
                     @empty
                     <tr>
                       <td colspan="5" class="whitespace-nowrap px-4 py-2 text-center text-gray-700">Tidak ada data penjualan</td>
                     </tr>
                     @endforelse
                   </tbody>
                 </table>
               </div>
               <div class="flex flex-col items-center ml-20 mt-1">
                 <!-- Help text -->
                 <span class="text-sm text-gray-700 dark:text-gray-400">
                     tampilkan <span class="font-semibold text-gray-900 dark:text-white">{{ $penjualans->firstItem() }}</span> sampai <span class="font-semibold text-gray-900 dark:text-white">{{ $penjualans->lastItem() }}</span> dari <span class="font-semibold text-gray-900 dark:text-white">{{ $penjualans->total() }}</span> Entries
                 </span>
                 <!-- Pagination -->
                 <ol class="flex justify-center gap-1 text-xs font-medium mt-2">
                     <!-- Previous Button -->
                     @if ($penjualans->onFirstPage())
                         <li>
                             <button class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 cursor-not-allowed" disabled>
                                 <span class="sr-only">Prev Page</span>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                 </svg>
                             </button>
                         </li>
                     @else
                         <li>
                             <a href="{{ $penjualans->previousPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-100">
                                 <span class="sr-only">Prev Page</span>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                 </svg>
                             </a>
                         </li>
                     @endif
             
                     <!-- Page Number Buttons -->
                     @foreach ($penjualans->getUrlRange(1, $penjualans->lastPage()) as $page => $url)
                         <li>
                             @if ($penjualans->currentPage() == $page)
                                 <span class="block px-4 py-2 rounded border-purple-600 bg-purple-600 text-center leading-8 text-white">{{ $page }}</span>
                             @else
                                 <a href="{{ $url }}" class="block px-4 py-2 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900 hover:bg-gray-100">{{ $page }}</a>
                             @endif
                         </li>
                     @endforeach
             
                     <!-- Next Button -->
                     @if ($penjualans->hasMorePages())
                         <li>
                             <a href="{{ $penjualans->nextPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-100">
                                 <span class="sr-only">Next Page</span>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4-4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                 </svg>
                             </a>
                         </li>
                     @else
                         <li>
                             <button class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 cursor-not-allowed" disabled>
                                 <span class="sr-only">Next Page</span>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4-4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                 </svg>
                             </button>
                         </li>
                     @endif
                 </ol>
             </div>
@endsection

@push('scripts')
    <!-- Include Bootstrap JS (jika belum ada) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmHapus(actionUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data Penjualan ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL penghapusan
                window.location.href = actionUrl;
            }
        });
    }
    </script>
@endpush
