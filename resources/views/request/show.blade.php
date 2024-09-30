@extends('layouts.app')

@section('content')
<div class="w-full h-full bg-gray-100 p-8">
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-300 w-full"> 
        <div class="mb-5">
            <a href="{{ route('request.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-2 text-sm rounded focus:outline-none">
                &larr; Back
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Request System</h1>

            <div class="flex flex-col space-y-2 items-end">
             
                <div class="flex items-center space-x-2">
                    <div class="mb-2">
                        @if($request->priority === 'Low')
                            <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full">Low</span>
                        @elseif($request->priority === 'Medium')
                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full">Medium</span>
                        @elseif($request->priority === 'High')
                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full">High</span>
                        @else
                            <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full">N/A</span>
                        @endif
                    </div>

                    
                    <div class="text-right">
                        <label class="block text-gray-700 font-bold">Status</label>
                        <p class="{{ $request->status === 'Active' ? 'text-green-600' : ($request->status === 'InProgress' ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $request->status }}
                        </p>
                    </div>
                </div>

               
                <div class="text-sm text-gray-500">
                    <p>Added Date: {{ $request->created_at->format('d M Y h:i A') }}</p>
                    <p>Request No: #{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Department</label>
            <p>{{ $request->department }}</p>
        </div>

    
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Subject</label>
            <p>{{ $request->subject }}</p>
        </div>

        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Purpose</label>
            <p>{{ $request->purpose }}</p>
        </div>

        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Engineer</label>
            <p>{{ $request->manager_engineer }}</p>
        </div>

        <!-- Date -->
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold">Date</label>
                <p class="text-gray-800">{{ $request->date }}</p>
            </div>
        </div>

        <!-- Attachments -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Attachments</label>
            @if(!empty($request->attachments))
                @foreach(explode(',', $request->attachments) as $attachment)
                    <a href="{{ url('storage/' . $attachment) }}" target="_blank" class="block text-blue-500 mb-2">
                        <i class="fas fa-paperclip"></i> {{ basename($attachment) }}
                    </a>
                @endforeach
            @else
                <p>No attachments found</p>
            @endif
        </div>

        <!-- Status -->
        <div class="mb-6">
            <form id="status-form" action="{{ route('request.updateStatus', $request->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <label class="block text-gray-700 font-bold mb-2">Update Status</label>
                <select name="status" id="status-select" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
                    <option value="Active" {{ $request->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="InProgress" {{ $request->status === 'InProgress' ? 'selected' : '' }}>In Progress</option>
                    <option value="End" {{ $request->status === 'End' ? 'selected' : '' }}>End</option>
                </select>
            </form>
        </div>

        <!-- Delete Form -->
        <div class="mb-6">
            <form action="{{ route('request.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this request?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                    Delete Request
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
