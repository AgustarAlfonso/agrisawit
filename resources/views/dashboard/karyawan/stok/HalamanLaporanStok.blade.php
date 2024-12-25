@extends('layouts.masterkaryawan')

@section('title', 'Data Stok')

@section('content')
<div class="container-fluid mt-4 px-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2 class="text-4xl font-extrabold dark:text-white">Melihat Stok</h2>


            <div class="overflow-x-auto mt-9">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-40">Jenis Perubahan</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-48">Tanggal Perubahan</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 w-40">Jumlah Perubahan</th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($stok as $item)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">{{ ucfirst($item->jenisPerubahan) }}</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">{{ \Carbon\Carbon::parse($item->tanggalBerubah)->format('d-m-y') }}</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                                {{ $item->jumlahPerubahan > 0 ? '+' : '' }}{{ number_format($item->jumlahPerubahan, 0, ',', '.') }} Kg
                            </td>
                            
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-center ml-20 mt-1">
                <!-- Help text -->
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    tampilkan <span class="font-semibold text-gray-900 dark:text-white">{{ $stok->firstItem() }}</span> sampai <span class="font-semibold text-gray-900 dark:text-white">{{ $stok->lastItem() }}</span> dari <span class="font-semibold text-gray-900 dark:text-white">{{ $stok->total() }}</span> Entries
                </span>
                <!-- Pagination -->
                <ol class="flex justify-center gap-1 text-xs font-medium mt-2">
                    <!-- Previous Button -->
                    @if ($stok->onFirstPage())
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
                            <a href="{{ $stok->previousPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-100">
                                <span class="sr-only">Prev Page</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    @endif
            
                    <!-- Page Number Buttons -->
                    @foreach ($stok->getUrlRange(1, $stok->lastPage()) as $page => $url)
                        <li>
                            @if ($stok->currentPage() == $page)
                                <span class="block px-4 py-2 rounded border-purple-600 bg-purple-600 text-center leading-8 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="block px-4 py-2 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900 hover:bg-gray-100">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
            
                    <!-- Next Button -->
                    @if ($stok->hasMorePages())
                        <li>
                            <a href="{{ $stok->nextPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-100">
                                <span class="sr-only">Next Page</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    @else
                        <li>
                            <button class="inline-flex items-center justify-center px-3 py-2 rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 cursor-not-allowed" disabled>
                                <span class="sr-only">Next Page</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmHapus(actionUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = actionUrl;
            }
        });
    }
</script>
@endpush
