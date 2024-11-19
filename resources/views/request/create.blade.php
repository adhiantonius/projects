@extends('layouts.app')

@section('content')

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex-grow flex items-center justify-center px-4">
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-md w-full max-h-screen overflow-auto border border-gray-300 md:max-w-4xl lg:max-w-6xl"> <!-- Adjusted max-width for different screen sizes -->

            <h1 class="text-2xl font-bold mb-6">Request New System</h1>


            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div>
                <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf



                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Department <span class="text-red-500">*</span></label>
                        <select name="department" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->DepartmentName }}">{{ $department->DepartmentName }}</option>
                            @endforeach
                        </select>
                        @error('department')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Subject Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Subject <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('subject') }}">
                        @error('subject')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Purpose Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Purpose <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('purpose') }}">
                        @error('purpose')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Engineer Dropdown -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Engineer <span class="text-red-500">*</span></label>
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

                    <!-- Priority Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Priority <span class="text-red-500">*</span></label>
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
                        <label class="block text-gray-700 font-semibold">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('date') }}">
                        @error('date')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Attachments Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Attachments</label>
                        <input type="file" name="attachments[]" multiple class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('attachments')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end mt-6 space-x-4">
                <a href="{{ route('request.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</a>
                <form action="{{ route('request.index') }}" method="GET">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Save Changes
                    </button>
                </form>

            </div>
            </form>
        </div>
    </div>
</body>
@endsection