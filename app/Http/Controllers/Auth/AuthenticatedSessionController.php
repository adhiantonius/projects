<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form or handle Windows Authentication if applicable.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        // Check if Windows Authentication is enabled and user is authenticated by IIS
        if (isset($_SERVER['AUTH_USER'])) {
            return $this->windowsAuthenticate($_SERVER['AUTH_USER']);
        }

        // Show the login form for non-Windows authentication
        return view('auth.login');
    }

    /**
     * Handle a form-based authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to intended page or issues page
            return redirect()->intended('/issues');
        }

        // Authentication failed; redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle Windows Authentication.
     *
     * @param  string  $windowsUser
     * @return RedirectResponse
     */
    protected function windowsAuthenticate(string $windowsUser): RedirectResponse
    {
        // Extract the username without the domain part (e.g., DOMAIN\username)
        $username = explode('\\', $windowsUser)[1] ?? $windowsUser;

        // Construct the user's email (customize domain if needed)
        $email = $username . '@yourcompany.com'; // Adjust the domain as necessary

        // Check if the user exists in the database or create a new one
        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $username]
        );

        // Log the user in
        Auth::login($user);

        // Redirect to the intended page or the issues page
        return redirect()->intended('/issues');
    }

    /**
     * Log out the user and invalidate the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the user
        Auth::guard('web')->logout();

        // Invalidate the current session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect('/login');
    }
}
