
@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f3f4f6; 
            margin: 0; 
            padding: 0; 
        }
        .status-cell {
            min-width: 120px; 
            text-align: center; 
        }
        table {
            border-collapse: collapse; 
            width: 100%; 
            margin: 0 auto; 
        }
        th, td {
            text-align: left; 
            padding: 12px; 
            border: none; 
        }
        th {
            background-color: #e5e7eb;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; 
        }
        .table-container {
            margin-top: 8px; 
            padding: 20px; 
        }
    </style>
</head>


<body>
    <div class="max-w-full mx-auto p-6 rounded-lg  table-container"> 
        <h1 class="text-2xl font-bold mb-4">All Requests</h1>
        <div class="flex justify-end mb-4">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                    onclick="location.href='{{ route('request.create') }}'">
                Create New Request
            </button>
        </div>

        @if($requests->isEmpty())
            <p class="text-center text-gray-500">No requests found.</p>
        @else
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                        <th class="p-4"> No </th>
                            <th class="p-4"> ID </th>
                            <th class="p-4">Department</th>
                            <th class="p-4">Subject</th>
                            <th class="p-4">Engineer</th>
                            <th class="p-4">Priority</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Status</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr>
                                
                            <td>{{ $loop->iteration + ($requests->currentPage() - 1) * 5 }}</td>
                            <td class="p-4">{{ $request->id }}</td> 
                                <td class="p-4">{{ $request->department }}</td>
                                <td class="p-4">
                                    <a href="{{ route('request.show', $request->id) }}" class="text-blue-500 hover:underline">
                                        <em>{{ $request->subject }}</em>
                                    </a>
                                </td>
                                <td class="p-4">{{ $request->manager_engineer }}</td>
                                <td class="text-center">
                                    @if($request->priority === 'Low')
                                        <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-sm">Low</span>
                                    @elseif($request->priority === 'Medium')
                                        <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm">Medium</span>
                                    @elseif($request->priority === 'High')
                                        <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-sm">High</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-sm">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $request->date }}</td>
                                <td class="text-center status-cell">
                                    @if($request->status === 'Active')
                                        <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-sm">Active</span>
                                    @elseif($request->status === 'InProgress')
                                        <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm">Progress</span>
                                    @elseif($request->status === 'End')
                                        <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-sm">End</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-sm">Unknown</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $requests->links() }} 
            </div>
        @endif
    </div>
@endsection
</body>
</html>
