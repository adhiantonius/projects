@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Latest Issues and Requests</h1>

    <h2 class="text-xl font-semibold mb-2">Latest Issues</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-300">ID</th>
                    <th class="py-2 px-4 border border-gray-300">Date</th>
                    <th class="py-2 px-4 border border-gray-300">Priority</th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border border-gray-300">{{ $issue->id }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $issue->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 px-4 border-b text-center">
                                        <span class="px-2 py-1 inline-flex text-sm  rounded-full
                                            @if($issue->priority == 'low') bg-blue-200 text-blue-800
                                            @elseif($issue->priority == 'medium') bg-yellow-200 text-yellow-800
                                            @elseif($issue->priority == 'high') bg-red-200 text-red-800
                                            @endif">
                                            {{ ucfirst($issue->priority) }}
                                        </span>




                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $issues->links() }}
    </div>

    <h2 class="text-xl font-semibold mt-8 mb-2">Latest Requests</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-300">ID</th>
                    <th class="py-2 px-4 border border-gray-300">Date</th>
                    <th class="py-2 px-4 border border-gray-300">Priority</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border border-gray-300">{{ $request->id }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @if($request->priority === 'Low')
                            <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-sm">Low</span>
                        @elseif($request->priority === 'Medium')
                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm">Medium</span>
                        @elseif($request->priority === 'High')
                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-sm">High</span>
                       
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection
