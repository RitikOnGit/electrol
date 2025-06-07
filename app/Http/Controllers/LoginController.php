<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller{
    public function index(){
        return view('login.login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // Validate the login form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Authentication successful, redirect to dashboard or intended page
            session()->put('user_id', Auth::id());
            return redirect()->intended('/');
        } else {
            // Check if the email is correct
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Email does not exist
                return redirect()->back()->withInput()->withErrors(['email' => 'This email is not registered.']);
            } else {
                // Email exists, but password is incorrect
                return redirect()->back()->withInput()->withErrors(['password' => 'Incorrect password.']);
            }
        }
    }
    public function signup(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        Auth::login($user);

        session()->put('user_id', Auth::id());

        return redirect()->intended('/dashboard')->with('success', 'Signup successful! Welcome.');
        }

        public function logout(Request $request){
            Auth::logout();

            // Invalidate the session and regenerate CSRF token for security
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('success', 'Logged out successfully.');

        }

}

