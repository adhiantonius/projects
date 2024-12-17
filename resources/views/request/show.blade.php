@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md border border-gray-300 w-full grid grid-cols-1 md:grid-cols-3 gap-6">
   
    <!-- Left Section: Request Information -->
    <div class="md:col-span-2 space-y-4">
        <!-- Back Button and Delete Button -->
        <div class="flex justify-between items-center mb-5">
            <a href="{{ route('request.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 text-sm rounded focus:outline-none">
                &larr; Back
            </a>

            <!-- Show Delete Button for Admins Only -->
            @if(Auth::user()->role === 'Admin')
            <form action="{{ route('request.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this request?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-white-700 hover:bg-gray-200 p-2 rounded-full focus:outline-none" title="Delete request">
                    <!-- Icon for delete button -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5L19.625 18.132a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </button>
            </form>
            @endif
        </div>

        
       <!-- Request Details -->
       <div>
            <h1 class="text-3xl font-bold mb-2">Request System</h1>

            <!-- Priority and Status -->
            <div class="flex items-center space-x-2 mb-4">
                @if($request->priority === 'Low')
                    <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full">Low</span>
                @elseif($request->priority === 'Medium')
                    <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full">Medium</span>
                @elseif($request->priority === 'High')
                    <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full">High</span>
                @else
                    <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full">N/A</span>
                @endif
                <p class="{{ $request->status === 'Active' ? 'text-green-600' : ($request->status === 'InProgress' ? 'text-yellow-600' : 'text-red-600') }} font-bold">
                    {{ $request->status }}
                </p>
            </div>
            <div class="text-sm text-gray-500">
                <p>Added Date: {{ $request->created_at->format('d M Y h:i A') }}</p>
                <p>Request No: #{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <!-- Detailed Fields -->
            <div class="mt-4 space-y-6">
            <!--department -->
            <h2 class="text-xl font-semibold mb-4">Department</h2>
            <p class="text-black-700 mb-6">{{ $request->department }}</p>
            <!--Subject-->
            <h2 class="text-xl font-semibold mb-4">Subject</h2>
            <p class="text-black-700 mb-6">{{ $request ->subject }}</p> 
            <!--Purpose-->    
            <h2 class="text-xl font-semibold mb-4">Purpose</h2>
            <p class="text-black-700 mb-6">{{ $request->purpose }}</p>
            <!--Engineer-->
            <h2 class="text-xl font-semibold mb-4">Description</h2>
            <p class="text-black-700 mb-6">{{  $request->manager_engineer }}</p>
              
            </div>

            <!-- Attachments -->
            <div class="mt-6">
            <h2 class="text-xl font-semibold mb-4">Attachments</h2>
                @if(!empty($request->attachments))
                    @foreach(explode(',', trim($request->attachments, '[]"')) as $attachment)
                        <a href="{{ asset('storage/' . ltrim($attachment, '/')) }}" target="_blank" class="block text-blue-500 mb-2">
                            <i class="fas fa-paperclip"></i> {{ basename($attachment) }}
                        </a>
                    @endforeach
                @else
                    <p>No attachments found</p>
                @endif
            </div>
        
    </div>
    @if(Auth::user()->role === 'Admin')
        <div class="mt-6 flex flex-col space-y-4">
            <!-- Update Status Form -->
            <form id="status-form" action="{{ route('request.updateStatus', $request->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <label class="block text-gray-700 font-bold mb-2">Update Status</label>
                <select name="status" id="status-select" class="w-45 border border-gray-300 rounded px-3 py-2 mb-4">
                    <option value="Active" {{ $request->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="InProgress" {{ $request->status === 'InProgress' ? 'selected' : '' }}>In Progress</option>
                    <option value="End" {{ $request->status === 'End' ? 'selected' : '' }}>End</option>
                </select>
            </form>
        </div>
        @endif
    </div>

    <!-- Right Section: Participants -->
    <div class="md:col-span-1 bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4">Participants</h3>
        @forelse ($participants as $participant)
            <div class="flex items-center mb-2">
                <img src="https://via.placeholder.com/50" alt="{{ $participant['name'] }}" class="w-10 h-10 rounded-full mr-4">
                <div>
                    <p class="font-bold">{{ $participant['name'] }} ({{ $participant['role'] }})</p>
                    <p class="text-sm text-gray-500">{{ $participant['email'] }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No participants available.</p>
        @endforelse

        <!-- Add Participant Form -->
        <form action="{{ route('request.addParticipant', $request->id) }}" method="POST" id="addParticipantForm">
        @csrf
        <label for="user_id" class="block text-gray-700 font-bold mb-2">Add Participant</label>
        <div class="relative inline-block text-left">
            <button type="button" onclick="toggleDropdown()" class="flex items-center space-x-2 text-blue-500 hover:text-blue-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                </svg>
                <span>Add Participant</span>
            </button>
            <div id="userDropdown" class="hidden mt-2 w-48 border border-gray-300 rounded-lg shadow-lg bg-white z-10">
                <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 p-2">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none">
                    Add Participant
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Submit form when status-select dropdown changes
    document.getElementById('status-select').addEventListener('change', function() {
        document.getElementById('status-form').submit();
    });

    // Function to toggle the visibility of the user dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Event listener for the Add Participant form submission
    document.getElementById('addParticipantForm').addEventListener('submit', function(event) {
      
    });
</script>

@endsection