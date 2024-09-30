
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="mb-4">
        <a href="{{ route('issues.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-2 text-sm rounded focus:outline-none">
            &larr; Back
        </a>
    </div>    

    <h1 class="text-3xl font-bold mb-6">Edit Issue {{ $issue->title }}</h1>

    <form method="POST" action="{{ route('issues.update', $issue) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea id="description" name="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $issue->description }}</textarea>
        </div>

        <!-- Priority Field -->
        <div class="mb-4">
            <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority:</label>
            <select id="priority" name="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Priority</option>
                <option value="low" {{ $issue->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $issue->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $issue->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <!-- Attachment Field -->
        <div class="mb-4">
            <label for="attachment" class="block text-gray-700 text-sm font-bold mb-2">Attachment:</label>
            <input type="file" id="attachment" name="attachment" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @if($issue->attachment)
                <p class="mt-2 text-sm text-gray-600">Current Attachment: <a href="{{ asset('storage/issues/' . $issue->attachment) }}" class="text-indigo-600 hover:text-indigo-900">{{ $issue->attachment }}</a></p>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Issue
            </button>
        </div>
    </form>
</div>
@endsection
