<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DemoAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Demo users for testing different roles - get actual IDs from database
        $demoUsers = [
            'admin@demo.com' => ['id' => 6, 'name' => 'Admin User', 'role' => 'admin'],
            'seller@demo.com' => ['id' => 7, 'name' => 'Demo Seller', 'role' => 'student'],
            'buyer@demo.com' => ['id' => 8, 'name' => 'Demo Buyer', 'role' => 'guest'],
        ];

        $email = $request->email;
        
        if (isset($demoUsers[$email])) {
            $user = $demoUsers[$email];
            
            // Store user in session
            session([
                'demo_user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $email,
                    'role' => $user['role']
                ]
            ]);

            return redirect('/')->with('success', "Welcome back, {$user['name']}!");
        }

        return back()->withErrors(['email' => 'Invalid credentials. Use: admin@demo.com, seller@demo.com, or buyer@demo.com']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create actual user in database for demo - always as guest initially
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'guest', // All new users start as guests
        ]);

        // Store in session
        session([
            'demo_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);

        return redirect('/')->with('success', "Account created successfully! Welcome, {$user->name}!");
    }

    public function logout()
    {
        session()->forget('demo_user');
        return redirect('/')->with('success', 'You have been logged out.');
    }
}
