@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-300 w-full grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Section (Issue Details) -->
        <div class="md:col-span-2">
            <div class="flex justify-between items-center mb-5">
                <!-- Back Button -->
                <a href="{{ route('issues.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 text-sm rounded focus:outline-none">
                    &larr; Back
                </a>

                <!-- Delete Button (Only visible to Admin) -->
                @if(Auth::user()->role === 'Admin')
                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this issue?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white-700 hover:bg-gray-200 p-2 rounded-full focus:outline-none" title="Delete issue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5L19.625 18.132a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>

            <div class="mb-6">
    <!-- Title -->
    <h1 class="text-3xl font-bold">Issue Details</h1>
</div>

<!-- Priority, Status, and Issue Info -->
<div class="flex flex-col space-y-4 mb-6">
    <div class="flex items-center space-x-4">
        <!-- Priority Display -->
        <div>
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

        <!-- Status Display -->
        <div>
            <label class="block text-gray-700 font-bold">Status</label>
            <p class="{{ $issue->status === 'Active' ? 'text-green-600' : ($issue->status === 'InProgress' ? 'text-yellow-600' : 'text-red-600') }}">
                {{ $issue->status }}
            </p>
        </div>
    </div>

    <!-- Issue Info -->
    <div>
        <span class="text-sm text-gray-500 block">Added Date: {{ $issue->created_at->format('d M Y h:i A') }}</span>
        <span class="text-sm text-gray-500 block">Ticket No: #{{ str_pad($issue->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>
</div>


            <!-- Issue Description & Attachments -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Description</h2>
                    <p class="text-black-700 mb-6">{{ $issue->description }}</p>

                    <h2 class="text-xl font-semibold mb-4">Attachments</h2>
                    @if($issue->attachment)
                        <a href="{{ asset($issue->attachment) }}" class="text-blue-500 underline" target="_blank">
                            {{ basename($issue->attachment) }}
                        </a>
                    @else
                        <p class="text-gray-500">No attachments available.</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons (Only for Admins) -->
            @if(Auth::user()->role === 'Admin')
                <div class="mt-6">
                    <!-- Update Status Form -->
                    <form id="status-form" action="{{ route('issues.updateStatus', $issue->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="block text-gray-700 font-bold mb-2">Update Status</label>
                        <select name="status" id="status-select" class="w-45 border border-gray-300 rounded px-3 py-2 mb-4">
                            <option value="Active" {{ $issue->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="InProgress" {{ $issue->status === 'InProgress' ? 'selected' : '' }}>In Progress</option>
                            <option value="End" {{ $issue->status === 'End' ? 'selected' : '' }}>End</option>
                        </select>
                    </form>
                </div>
            @endif
        </div>

        <!-- Right Section (Participants) -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-bold mb-4">Participants</h3>
            @forelse ($participants as $participant)
                <div class="flex items-center mb-2">
                    <div class="mr-4">
                        <!-- Placeholder profile picture for participants -->
                        <img src="https://via.placeholder.com/50" alt="{{ $participant['name'] }}" class="w-10 h-10 rounded-full">
                    </div>
                    <div>
                        <p class="font-bold">{{ $participant['name'] }} ({{ $participant['role'] }})</p>
                        <p class="text-sm text-gray-500">{{ $participant['email'] }}</p>
                    </div>
                </div>
            @empty
            <p class="text-gray-500">No participants available.</p>
@endforelse

<form action="{{ route('issues.addParticipant', $issue->id) }}" method="POST" id="addParticipantForm">
    @csrf
    <label for="user_id" class="block text-gray-700 font-bold mb-2">Add Participant</label>

    <!-- Container for the icon and dropdown -->
    <div class="relative inline-block text-left">
        <!-- Button to toggle dropdown -->
        <button type="button" onclick="toggleDropdown()" class="flex items-center space-x-2 text-blue-500 hover:text-blue-700 focus:outline-none">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
            </svg>
            <span>Add Participant</span>
        </button>

        <!-- Dropdown for user selection -->
        <div id="userDropdown" class="hidden mt-2 w-48 border border-gray-300 rounded-lg shadow-lg bg-white z-10">
            <select name="user_id" id="user_id" class="w-48 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 p-2">
                <option value="">Select a user</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            
            <!-- Add Participant submit button -->  
            <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none">
                Add Participant
            </button>
        </div>
    </div>
</form>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }
    document.getElementById('status-select').addEventListener('change', function() {
        document.getElementById('status-form').submit();
    });
</script>

@endsection
