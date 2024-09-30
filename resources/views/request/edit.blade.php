@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-300">
        <a href="{{ route('request.index') }}" class="inline-block mb-4 text-blue-500">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <h1 class="text-center text-2xl font-bold mb-6">Update Request</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('request.update', $request->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Department <span class="text-red-500">*</span></label>
                        <select name="department" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">Select department</option>
                            <option value="HR" {{ $request->department == 'HR' ? 'selected' : '' }}>HR</option>
                            <option value="IT" {{ $request->department == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Sales" {{ $request->department == 'Sales' ? 'selected' : '' }}>Sales</option>
                        </select>
                        @error('department')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Subject <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" value="{{ $request->subject }}" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('subject')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Purpose <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" value="{{ $request->purpose }}" class="w-full border border-gray-300 rounded px-3 py-10">
                        @error('purpose')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Engineer <span class="text-red-500">*</span></label>
                        <select name="manager_engineer" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employeeName }}" {{ $request->manager_engineer == $employee->employeeName ? 'selected' : '' }}>
                                    {{ $employee->employeeName }}
                                </option>
                            @endforeach
                        </select>
                        @error('manager_engineer')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ $request->date }}" class="border border-gray-300 rounded px-3 py-2">
                        @error('date')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
            <label class="block text-gray-700">Priority <span class="text-red-500">*</span></label>
            <select name="priority" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
                    <div class="mb-4">
                        <label class="block text-gray-700">Attachments</label>
                        <input type="file" name="attachments[]" multiple class="w-full border border-gray-300 rounded px-3 py-20">
                        @error('attachments')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('request.show', $request->id) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
