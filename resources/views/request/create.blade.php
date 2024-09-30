@extends('layouts.app')

@section('content')
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex-grow flex items-center justify-center px-4"> <!-- Added px-4 for better small screen spacing -->
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-md w-full h-full max-h-screen overflow-auto border border-gray-300 md:max-w-4xl lg:max-w-6xl"> <!-- Responsive max-width for larger screens -->
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6 text-center md:text-left">REQUEST NEW SYSTEM</h1>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Request Form -->
            <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Responsive Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div>
                        <!-- Department Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Department <span class="text-red-500">*</span></label>
                            <select name="department" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select department</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->DepartmentName }}">{{ $employee->DepartmentName }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Subject <span class="text-red-500">*</span></label>
                            <input type="text" name="subject" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('subject') }}">
                            @error('subject')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Middle Column -->
                    <div>
                        <!-- Purpose Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Purpose <span class="text-red-500">*</span></label>
                            <input type="text" name="purpose" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('purpose') }}">
                            @error('purpose')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Engineer Dropdown -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Engineer <span class="text-red-500">*</span></label>
                            <select name="manager_engineer" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Engineer</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->employeeName }}">{{ $employee->employeeName }}</option>
                                @endforeach
                            </select>
                            @error('manager_engineer')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <!-- Priority Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Priority <span class="text-red-500">*</span></label>
                            <select name="priority" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Priority</option>
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Date <span class="text-red-500">*</span></label>
                            <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('date') }}">
                            @error('date')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attachments Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Attachments</label>
                            <input type="file" name="attachments[]" multiple class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('attachments')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end mt-6 space-x-2">
                    <a href="{{ route('request.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
