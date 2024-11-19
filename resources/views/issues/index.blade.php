<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issues List</title>


    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    

    <!--  Toastr.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    /* Custom styles */
    .status-cell {
        min-width: 120px;
        text-align: center;
    }

   
    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block; 
        }

        thead tr {
            display: none; 
        }

        tr {
            margin-bottom: 1rem;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 0.5rem;
        }

        td {
            text-align: left;
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        td:before {
            content: attr(data-label); /* Add labels for mobile */
            font-weight: bold;
            width: 50%;
            flex-shrink: 0;
        }
    }
 
</style>

</head>

@extends('layouts.app')

@section('content')

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="flex-grow">
        <div class="max-w-full table-container mt-4 h-full p-4 bg-white rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Issues List</h1>

            <div class="flex justify-end mb-5">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow"
                    onclick="location.href='{{ route('issues.create') }}'">
                    <i class="fas fa-plus-circle"></i> Create New Issue
                </button>
            </div>

        
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-4 text-center">No</th>
                            <th class="p-4 text-center">ID</th>
                            <th class="p-4 text-center">Date</th>
                            <th class="p-4 text-center">Description</th>
                            <th class="p-4 text-center">Priority</th>
                            <th class="p-4 text-center">Attachment</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($issues->isEmpty())
                        <tr>
                            <td colspan="7" class="py-2 px-4 text-center">No issues found.</td>
                        </tr>
                        @else
                        @foreach($issues as $issue)
                        <tr class="text-sm bg-white border-b hover:bg-gray-50">
                            <td class="p-4 text-center" data-label="No">{{ $loop->iteration }}</td>
                            <td class="p-4 text-center" data-label="ID">
                                <a href="{{ route('issues.show', $issue->id) }}" class="text-blue-500 hover:underline">
                                    <em>#{{ str_pad($issue->id, 4, '0', STR_PAD_LEFT) }}</em>
                                </a>
                            </td>
                            <td class="p-4 text-center" data-label="Date">{{ \Carbon\Carbon::parse($issue->date)->format('Y-m-d') }}</td>
                            <td class="p-4 text-justify" data-label="Description">{{ Str::limit($issue->description, 100) }}</td>
                            <td class="p-4 text-center" data-label="Priority">
                                <span class="px-2 py-1 inline-flex text-sm font-semibold rounded-full
                                    @if($issue->priority == 'low') bg-blue-200 text-blue-800
                                    @elseif($issue->priority == 'medium') bg-yellow-200 text-yellow-800
                                    @elseif($issue->priority == 'high') bg-red-200 text-red-800
                                    @endif">
                                    {{ ucfirst($issue->priority) }}
                                </span>
                            </td>
                            <td class="p-4 text-center" data-label="Attachment">
                                @if($issue->attachment)
                                <a href="{{ asset($issue->attachment) }}" class="text-blue-500 underline" target="_blank">
                                    <i class="fas fa-paperclip"></i> View Attachment
                                </a>
                                @else
                                No attachment
                                @endif
                            </td>
                            <td class="p-4 text-center" data-label="Status">
                                <span class="py-1 px-3 rounded-full text-sm
                                    @if($issue->status === 'Active') bg-green-200 text-green-800
                                    @elseif($issue->status === 'InProgress') bg-yellow-200 text-yellow-800
                                    @elseif($issue->status === 'End') bg-red-200 text-red-800
                                    @else bg-gray-200 text-gray-800 @endif">
                                    {{ ucfirst($issue->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $issues->links() }}
            </div>
        </div>
    </div>

    <!-- Toastr Notifications -->
    <script>
        $(document).ready(function () {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
</body>

@endsection
