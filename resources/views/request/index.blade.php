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
@extends('layouts.app')

@section('content')


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
<div class="bg-gray-100 min-h-screen flex flex-col">
<div class="max-w-full table-container mt-4 h-full p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4"> Request List</h1>
        <div class="flex justify-end mb-4">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                    onclick="location.href='{{ route('request.create') }}'">
                    <i class="fas fa-plus-circle"></i> Create New Request
            </button>
        </div>

    
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg"> 
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 text-center">No</th>
                        <th class="p-4 text-center">ID</th>
                        <th class="p-4 text-center">Department</th>
                        <th class="p-4 text-center">Subject</th>
                        <th class="p-4 text-center">Engineer</th>
                        <th class="p-4 text-center">Date</th>
                        <th class="p-4 text-center">Priority</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                @if($requests->isEmpty())
                <tr>
                            <td colspan="7" class="py-2 px-4 text-center">No request found.</td>
                        </tr>
        @else
                <tbody>
                    @foreach($requests as $request)
                    <tr class="text-sm bg-white border-b">
                    <td class="p-4 text-center" data-label="No">{{ $loop->iteration }}</td>  
                       
                        <td class="p-4 text-center" data-label="ID">
                        <a href="{{ route('request.show', $request->id) }}" class="text-blue-500 hover:underline">
                            <em>#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</em>
                        </td>
                        <td class="p-4 text-center" data-label="Department">{{ $request->department }}</td>
                        <td class="p-4 text-justify" data-label="Subject">{{ $request->subject }}</td>
                        <td class="p-4 text-center" data-label="Engineer">{{ $request->manager_engineer }}</td>
                        <td class="p-4 text-center" data-label="Date">{{ $request->date }}</td>
                        <td class="p-4 text-center" data-label="Priority">
                            <span class="px-2 py-1 inline-flex text-sm font-semibold rounded-full
                                @if($request->priority === 'Low') bg-blue-200 text-blue-800
                                @elseif($request->priority === 'Medium') bg-yellow-200 text-yellow-800
                                @elseif($request->priority === 'High') bg-red-200 text-red-800
                                @else
                                bg-gray-200 text-gray-800
                                @endif">
                                {{ ucfirst($request->priority) }}
                            </span>
                        </td>
                        <td class="p-4 text-center" data-label="Status"> 
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
    </div>

            <div class="mt-4">
                {{ $requests->links() }} 
            </div>
        @endif
    </div>
@endsection
</body>
</html>
