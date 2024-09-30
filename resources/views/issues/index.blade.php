<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issues List</title>
    
    <!-- Include Tailwind CSS -->
    @vite('resources/css/app.css') 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Custom Styles */
        .status-cell {
            min-width: 120px; 
            text-align: center;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            /* Display each table row as a block for mobile */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            /* Hide the table header */
            thead tr {
                display: none;
            }

            /* Each table row becomes a card */
            tr {
                margin-bottom: 1rem;
                border-bottom: 1px solid #ddd;
                background-color: #f9f9f9;
                padding: 1rem;
                border-radius: 0.5rem;
            }

            /* Make the cells stack on top of each other */
            td {
                text-align: left;
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
            }

            /* Add labels before the cell values */
            td:before {
                content: attr(data-label);
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
        <div class="max-w-full table-container mt-4 h-full"> 
            <h1 class="text-2xl font-bold mb-4">Issues List</h1>
            <div class="flex justify-end mb-5">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                        onclick="location.href='{{ route('issues.create') }}'">
                    Create New Issue
                </button>
            </div>
            <div class="overflow-x-auto"> <!-- Container to enable horizontal scrolling -->
                <table class="min-w-full bg-white shadow rounded-lg"> <!-- Responsive table -->
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
                                <tr class="text-sm bg-white border-b">
                                    <td class="p-4 text-center" data-label="No">{{ $loop->iteration }}</td> 
                                    <td class="p-4 text-center" data-label="ID">{{ $issue->id }}</td> 
                                    <td class="p-4 text-center" data-label="Date">{{ $issue->date }}</td> 
                                    <td class="p-4 text-justify" data-label="Description">{{ $issue->description }}</td>
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
                                            <a href="{{ route('issues.show', $issue->id) }}" class="text-blue-500 underline">
                                                <i class="fas fa-paperclip"></i> View Attachment
                                            </a>
                                        @else
                                            No attachment
                                        @endif
                                    </td>
                                    <td class="p-4 text-center" data-label="Status"> 
                                        @if($issue->status === 'Active') 
                                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-sm">Active</span>
                                        @elseif($issue->status === 'End') 
                                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-sm">End</span>
                                        @elseif($issue->status === 'InProgress') 
                                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm">Progress</span>
                                        @else
                                            <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-sm">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
           
            <div class="mt-4">
                {{ $issues->links() }} 
            </div>
        </div>
    </div>

</body>
@endsection
</html>
