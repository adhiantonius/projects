<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WindowsAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if Windows Authentication provides the username
        if (isset($_SERVER['AUTH_USER'])) {
            $windowsUsername = $_SERVER['AUTH_USER'];

            // Extract the username without the domain (e.g., "DOMAIN\username")
            $username = explode('\\', $windowsUsername)[1] ?? $windowsUsername;

            // Find or create the user in the database
            $user = User::firstOrCreate(
                ['email' => $username . '@yourcompany.com'], // Adjust email logic as needed
                ['name' => $username] // Add other user details if required
            );

            // Log the user in
            Auth::login($user);
        }

        return $next($request);
    }
}
