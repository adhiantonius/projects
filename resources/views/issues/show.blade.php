@extends('layouts.app')

@section('content')

<div class="container mx-auto p-8">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-300">
        <div class="mb-5">
            <a href="{{ route('issues.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-2 text-sm rounded focus:outline-none">
                &larr; Back
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Show Issue</h1>

            <div class="text-right">
                <div class="flex flex-col space-y-2 items-end">
                    <div class="flex items-center space-x-2">
                        <!-- Priority -->
                        <div class="mb-2">
                            @if($issue->priority === 'low')
                                <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-sm">Low</span>
                            @elseif($issue->priority === 'medium')
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm">Medium</span>
                            @elseif($issue->priority === 'high')
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-sm">High</span>
                            @else
                                <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-sm">N/A</span>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="text-right">
                            <label class="block text-gray-700 font-bold">Status</label>
                            <p class="{{ $issue->status === 'Active' ? 'text-green-600' : ($issue->status === 'InProgress' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $issue->status }}
                            </p>
                        </div>
                    </div>

                    <!-- Issue Info -->
                    <div class="text-right">
                        <span class="text-sm text-gray-500 block">Added Date: {{ $issue->created_at->format('d M Y h:i A') }}</span>
                        <span class="text-sm text-gray-500 block">Ticket No: #{{ str_pad($issue->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Issue Details -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Description</h2>
                <p class="text-gray-700 mb-6">{{ $issue->description }}</p>

                <h2 class="text-xl font-semibold mb-4">Attachments</h2>
                @if($issue->attachment)
                    <a href="{{ asset('storage/issues/' . $issue->attachment) }}" target="_blank" class="text-blue-500 underline">
                        {{ basename($issue->attachment) }}
                    </a>
                @else
                    <p class="text-gray-500">No attachments available.</p>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex flex-col space-y-4">
            <!-- Update Status Form -->
            <form id="status-form" action="{{ route('issues.updateStatus', $issue->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <label class="block text-gray-700 font-bold mb-2">Update Status</label>
                <select name="status" id="status-select" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
                    <option value="Active" {{ $issue->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="InProgress" {{ $issue->status === 'InProgress' ? 'selected' : '' }}>In Progress</option>
                    <option value="End" {{ $issue->status === 'End' ? 'selected' : '' }}>End</option>
                </select>
            </form>

            <!-- Delete Issue Button -->
            <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this issue?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none">
                    Delete Issue
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('status-select').addEventListener('change', function() {
        document.getElementById('status-form').submit();
    });
</script>

@endsection
