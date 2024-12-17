<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen items-center justify-center">
        <div class="flex bg-white rounded-lg shadow-lg w-3/4">
            <!-- Illustration Section -->
            <div class="w-1/2 bg-gray-100 flex flex-col items-center justify-center p-8">
                <h1 class="text-2xl font-bold mb-4">Welcome!</h1>
                <h2 class="text-2xl font-mb-4">Ticket Issue & Request System</h2>

                <img src="{{ asset('storage/kom.png') }}" alt="Illustration" class="w-3/4">
            </div>

            <!-- Login Form Section -->
            <div class="w-1/2 p-8">
                <h2 class="text-xl font-bold text-center mb-4">Log in</h2>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf   
                    <!-- Email Field -->
                    <div>
                        <input id="email" type="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <input id="password" type="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center">
                        <input class="form-check-input h-4 w-4 text-blue-600 border-gray-300 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="ml-2 block text-sm text-gray-900" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <!-- Sign In Button -->
                    <div>
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                            {{ __('Sign In') }}
                        </button>
                    </div>
                 


                   
                </form>
            </div>
        </div>
    </div>
</body>

</html>