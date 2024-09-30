<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-[#28c45c] flex items-center justify-center min-h-screen">
    <div class="flex items-center justify-center w-full">
        <!-- Welcome Section with Image -->
        <div class="w-1/2 flex justify-center">
            <div class="text-center">
                <img alt="Logo" class="mx-auto mb-4" src="{{ asset('plaza.png') }}" alt="Image" width="100" height="50"/>
                <h1 class="text-white text-4xl font-bold mb-2" style="font-family: 'Poppins', sans-serif;">
                    Welcome, caca!
                </h1>
                <p class="text-white text-lg mb-8">
                    hehheheeh
                </p>
                <img alt="Illustration of people working on a checklist and collaborating in an office environment" class="w-full" src="https://oaidalleapiprodscus.blob.core.windows.net/private/org-RcpoXHkzChYnDbFAyeQ8tamr/user-ehrvabJ3DufsCu8YJ7PqY5gl/img-32aWRK0LpL5KsoJlwkAKzZ5Q.png?st=2024-09-26T04%3A49%3A35Z&se=2024-09-26T06%3A49%3A35Z&sp=r&sv=2024-08-04&sr=b&rscd=inline&rsct=image/png&skoid=d505667d-d6c1-4a0a-bac7-5c84a87759f8&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2024-09-25T23%3A21%3A56Z&ske=2024-09-26T23%3A21%3A56Z&sks=b&skv=2024-08-04&sig=%2B5YmfXTCSprcSk%2BuhLK9/qii6yjGX7usc%2BkcALDZjas%3D" width="400" height="300"/>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="w-1/2 flex justify-center">
            <div class="bg-white shadow-md rounded-lg p-8 w-96">
                <h2 class="text-xl font-semibold mb-6 text-center">
                    Log in
                </h2>
                <form>
                    <div class="mb-4">
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Username" type="text"/>
                    </div>
                    <div class="mb-6">
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password" type="password"/>
                    </div>
                    <div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700" type="submit">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Conditional Login/Register Links -->
    <div class="absolute top-10 right-10 text-center">
        @if (Route::has('login'))
            @auth
                <div class="bg-gray-800 text-white p-8 rounded-lg shadow-lg mb-4">
                    <p class="mb-4">You are logged in!</p>
                    <a href="{{ url('/dashboard') }}" class="bg-white text-gray-800 px-4 py-2 rounded">Dashboard</a>
                </div>
            @else
                <div class="bg-gray-800 text-white p-8 rounded-lg shadow-lg mb-4">
                    <p class="mb-4">I already have an account.</p>
                    <a href="{{ route('login') }}" class="bg-white text-gray-800 px-4 py-2 rounded">Login</a>
                </div>
                @if (Route::has('register'))
                    <div class="bg-white text-gray-800 p-8 rounded-lg shadow-lg">
                        <p class="mb-4">I'm new here!</p>
                        <a href="{{ route('register') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Create an account</a>
                    </div>
                @endif
            @endauth
        @endif
    </div>
</body>
</html>
