<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-4xl border border-gray-300">
        <h1 class="text-center text-2xl font-bold mb-6">Request Detail</h1>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">ID</label>
            <p class="border border-gray-300 p-2 rounded-md">{{ $request->id }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Department</label>
            <p class="border border-gray-300 p-2 rounded-md">{{ $request->department }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Subject</label>
            <p class="border border-gray-300 p-2 rounded-md">{{ $request->subject }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Purpose</label>
            <p class="border border-gray-300 p-2 rounded-md">{{ $request->purpose }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Date</label>
            <p class="border border-gray-300 p-2 rounded-md">{{ $request->date }}</p>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('request.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Back to List</a>
        </div>
    </div>
</body>
</html>
