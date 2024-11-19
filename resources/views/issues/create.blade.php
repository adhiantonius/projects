<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Form</title>
    @vite('resources/css/app.css') 
</head>
@extends('layouts.app')
@section('content')
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="w-full h-full max-w-7xl mx-auto p-6 bg-white shadow-md rounded-lg">

        <h1 class="text-2xl font-bold mb-6">Ticket Issue</h1>

        <div class="mb-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Form Start -->
        <form method="POST" action="{{ route('issues.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Date Field -->
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md">
            </div>

            <!-- Description Field -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority Field -->
            <div class="mb-4">
                <label for="priority" class="block text-gray-700">Priority <span class="text-red-500">*</span></label>
                <select id="priority" name="priority" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md">
                    <option value="">Select Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attachments Field -->
            <div class="mb-4">
                <label for="attachment" class="block text-gray-700">Attachments <span class="text-red-500">*</span></label>
                <input type="file" id="attachment" name="attachment" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md">
                @error('attachment')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('issues.store') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md">Cancel</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">Save Changes</button>
            </div>
        </form>
    </div>

</body>
@endsection
