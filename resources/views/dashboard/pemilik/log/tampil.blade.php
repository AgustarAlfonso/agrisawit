@extends('layouts.masterpemilik')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-4xl font-extrabold dark:text-white">Activity Logs</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
            <thead>
                <tr>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Role</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Activity Description</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Date & Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($logs as $log)
                <tr>
                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                        {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                        {{ $log->user_name }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                        {{ $log->user_role }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                        {{ $log->activity_description }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-center">
                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="whitespace-nowrap px-4 py-2 text-center text-gray-700">No logs available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="flex justify-center mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
