@extends('layouts.app')

@section('content')
<div class="flex-grow">
    <div class="max-w-full table-container mt-4 h-full p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Latest Issues and Requests</h1>

        <!-- Issues Filter Section -->
        <div class="mb-8  p-1 " style="width: 15%;">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Filter Issues</h2>
                <button type="button" onclick="toggleFilter('issues-filter')" class="focus:outline-none flex items-center">
                    <span id="issues-icon" class="text-gray-600 text-2xl">+</span>
                </button>
            </div>
            <div id="issues-filter" class="mt-4 hidden">
                <form method="GET" action="{{ url()->current() }}" class="space-y-2">
                    <input type="hidden" name="filter_type" value="issues">
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label for="issues_start_date" class="block font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="issues_start_date" value="{{ request('start_date') }}" class="border rounded-md px-2 py-1 w-full focus:ring focus:ring-blue-200">
                        </div>
                        <div class="flex-1">
                            <label for="issues_end_date" class="block font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="issues_end_date" value="{{ request('end_date') }}" class="border rounded-md px-2 py-1 w-full focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="flex justify mt-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700 transition-colors">
                            Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Issues Table -->
        <h2 class="text-xl font-bold mb-4">Issues List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 text-center">Date</th>
                        <th class="p-2 text-center">ID</th>
                        <th class="p-2">Description</th>
                        <th class="p-2 text-center">Priority</th>
                        <th class="p-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issues as $issue)
                        <tr class="text-sm bg-white border-b hover:bg-gray-100">
                            <td class="p-2 text-center">{{ $issue->created_at->format('d-m-Y') }}</td>
                            <td class="p-4 text-center" data-label="ID">
                                <a href="{{ route('issues.show', $issue->id) }}" class="text-blue-500 hover:underline">
                                    <em>#{{ str_pad($issue->id, 4, '0', STR_PAD_LEFT) }}</em>
                                </a>
                            <td class="p-2">{{ $issue->description }}</td>
                            <td class="p-2 text-center">{{ ucfirst($issue->priority) }}</td>
                            <td class="p-2 text-center">{{ $issue->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">No issues found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $issues->links() }}
            </div>
        </div>

        <!-- Requests Filter Section -->
        <div class="mb-8  p-1  rounded-lg" style="width: 15%;">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Filter Requests</h2>
                <button type="button" onclick="toggleFilter('requests-filter')" class="focus:outline-none flex items-center">
                    <span id="requests-icon" class="text-gray-600 text-2xl">+</span>
                </button>
            </div>
            <div id="requests-filter" class="mt-4 hidden">
                <form method="GET" action="{{ url()->current() }}" class="space-y-2">
                    <input type="hidden" name="filter_type" value="requests">
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label for="requests_start_date" class="block font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="requests_start_date" value="{{ request('start_date') }}" class="border rounded-md px-2 py-1 w-full focus:ring focus:ring-green-200">
                        </div>
                        <div class="flex-1">
                            <label for="requests_end_date" class="block font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="requests_end_date" value="{{ request('end_date') }}" class="border rounded-md px-2 py-1 w-full focus:ring focus:ring-green-200">
                        </div>
                    </div>
                    <div class="flex justify mt-2">
                        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded-md hover:bg-green-600 transition-colors">
                            Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Requests Table -->
        <h2 class="text-xl font-bold mt-8 mb-4">Requests List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 text-center">Date</th>
                        <th class="p-2 text-center">ID</th>
                        <th class="p-2 text-center">Department</th>
                        <th class="p-2">Subject</th>
                        <th class="p-2 text-center">Engineer</th>
                        <th class="p-2 text-center">Priority</th>
                        <th class="p-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr class="text-sm bg-white border-b hover:bg-gray-100">
                            <td class="p-2 text-center">{{ $request->created_at->format('d-m-Y') }}</td>
                            <td class="p-4 text-center" data-label="ID">
                        <a href="{{ route('request.show', $request->id) }}" class="text-blue-500 hover:underline">
                            <em>#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</em>
                        </td>
                            <td class="p-2 text-center">{{ $request->department }}</td>
                            <td class="p-2">{{ $request->subject }}</td>
                            <td class="p-2 text-center">{{ $request->manager_engineer }}</td>
                            <td class="p-2 text-center">{{ ucfirst($request->priority) }}</td>
                            <td class="p-2 text-center">{{ $request->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4">No requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFilter(filterId) {
        const filterElement = document.getElementById(filterId);
        const iconElement = document.getElementById(filterId + '-icon');
        filterElement.classList.toggle('hidden');
        iconElement.textContent = filterElement.classList.contains('hidden') ? '+' : '-';
    }
</script>
@endsection
